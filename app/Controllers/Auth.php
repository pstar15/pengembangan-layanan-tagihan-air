<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\TagihanModel;
use App\Models\NotifikasiTagihan;
use App\Controllers\BaseController;
use App\Models\RiwayatLoginModel;
use App\Models\RiwayatTagihanModel;
use CodeIgniter\HTTP\ResponseInterface;
use Google\Client as GoogleClient;
use Google\Service\Oauth2;
use Google_Client;
use Google_Service_Oauth2;

require_once ROOTPATH . 'vendor/autoload.php';


class Auth extends BaseController
{

    protected $userModel;

    public function __construct()
    {
        helper('cookie');

        $this->userModel = new \App\Models\UserModel();

        if (!session()->get('logged_in') && get_cookie('remember_me')) {
            $token = get_cookie('remember_me');
            $user = $this->userModel->where('remember_token', $token)->first();

            if ($user) {
                session()->set([
                    'user_id'   => $user['id'],
                    'username'  => $user['username'],
                    'email'     => $user['email'],
                    'logged_in' => true
                ]);
            }
        }
    }

    public function index()
    {
        //
        $tagihanModel = new \App\Models\TagihanModel();

        $status  = $this->request->getGet('status_tagihan');
        $keyword = $this->request->getGet('keyword');

        $builder = $tagihanModel;

        if ($status === 'Lunas' || $status === 'Belum Lunas') {
            $builder = $builder->where('status', $status);
        }

        if (!empty($keyword)) {
            $builder = $builder->groupStart()
                        ->like('nama_pelanggan', $keyword)
                        ->orLike('nomor_meter', $keyword)
                    ->groupEnd();
        }

        $data['tagihan'] = $builder->findAll();

        return view('auth/dashboard', $data);
    }

    public function login()
    {
        $data = [];

        if (session()->getFlashdata('reset_token')) {
            $data['reset_token'] = session()->getFlashdata('reset_token');
        }

        return view('auth/login', $data);
    }

    public function register()
    {
        return view('auth/register');
    }

    public function registerProcess()
    {
        $validation = \Config\Services::validation();
        $validation->setRules([
            'password' => 'required|min_length[6]',
            'confirm_password' => 'required|matches[password]'
        ], [
            'confirm_password' => [
                'matches' => 'Konfirmasi password tidak sesuai dengan password.'
            ]
        ]);

        $userModel = new UserModel();
        $data = [
            'username' => $this->request->getPost('username'),
            'email'    => $this->request->getPost('email'),
            'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
        ];
        $userModel->save($data);
        return redirect()->to('/login')->with('success', 'Registrasi berhasil! Silakan masukkan email dan password untuk login.');
    }

    public function loginProcess()
    {
        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');
        $remember = $this->request->getPost('remember');
        $userModel = new \App\Models\UserModel();
        $loginModel = new RiwayatLoginModel();

        $user = $userModel->where('email', $email)->first();
        $status = 'Gagal';
        $userId = $user['id'] ?? null;

        if ($user && password_verify($password, $user['password'])) {
            session()->set([
                'user_id'   => $user['id'],
                'username'  => $user['username'],
                'email'     => $user['email'],
                'logged_in' => true
            ]);

            $status = 'Sukses';

            if ($remember) {
                $token = bin2hex(random_bytes(32));
                $userModel->update($user['id'], ['remember_token' => $token]);
                setcookie('remember_me', $token, time() + (86400 * 30), "/");
            }

            $loginModel->insert([
                'user_id'    => $user['id'],
                'waktu'      => date('Y-m-d H:i:s'),
                'ip_address' => $this->request->getIPAddress(),
                'lokasi'     => $this->getGeoLocation($this->request->getIPAddress()), // optional
                'perangkat'  => $this->request->getUserAgent()->getAgentString(),
                'status'     => $status
            ]);

            return redirect()->to('/auth/dashboard');
        } else {
            if ($userId) {
                $loginModel->insert([
                    'user_id'    => $userId,
                    'waktu'      => date('Y-m-d H:i:s'),
                    'ip_address' => $this->request->getIPAddress(),
                    'lokasi'     => $this->getGeoLocation($this->request->getIPAddress()), // optional
                    'perangkat'  => $this->request->getUserAgent()->getAgentString(),
                    'status'     => 'Gagal'
                ]);
            }

            return redirect()->back()->withInput()->with('error', 'Email atau password yang anda masukkan salah.');
        }
    }

    public function dashboard()
    {
        if (!session()->get('logged_in')) {
            return redirect()->to('/login')->with('error', 'Silakan login terlebih dahulu.');
        }

        $userId              = session()->get('user_id');
        $TagihanModel        = new TagihanModel();
        $RiwayatTagihanModel = new RiwayatTagihanModel();
        $PhoneUser           = new \App\Models\PhoneUser();
        $totalTagihan        = $RiwayatTagihanModel->getTotalTagihan();
        $totalAkun           = $PhoneUser->countAll();
        $totalAktif          = $PhoneUser->where('is_online', 'Aktif')->countAllResults();
        $totalNonAktif       = $PhoneUser->where('is_online', 'Aktif')->countAllResults();

        $riwayat = $RiwayatTagihanModel->select('periode, SUM(jumlah_tagihan) as total')
                                    ->where('user_id', $userId)
                                    ->groupBy('periode')
                                    ->findAll();

        $gabungan = [];

        foreach ($riwayat as $r) {
            if (isset($gabungan[$r['periode']])) {
                $gabungan[$r['periode']] += $r['total'];
            } else {
                $gabungan[$r['periode']] = $r['total'];
            }
        }

        ksort($gabungan);

        $periode = array_keys($gabungan);
        $total = array_values($gabungan);

        $data['periode'] = json_encode($periode);
        $data['total'] = json_encode($total);

        $data['total_tagihan'] = $TagihanModel->where('user_id', $userId)->countAllResults();
        $data['total_lunas'] = $TagihanModel->where(['user_id' => $userId, 'status' => 'Lunas'])->countAllResults();
        $data['total_belum_lunas'] = $TagihanModel->where(['user_id' => $userId, 'status' => 'Belum Lunas'])->countAllResults();

        $data['username'] = session()->get('username');

        $data['tagihan'] = $TagihanModel->where('user_id', $userId)->findAll();

        $data['akun_android'] = $PhoneUser->findAll();

        $data['notifikasi'] = $this->getNotifikasiTagihan();
        $data['notifikasi_baru'] = $this->getNotifikasiBaruCount();

        $data['totalTagihan'] = $totalTagihan;

        $data['totalAkun'] = $totalAkun;

        $data['totalAktif'] = $totalAktif;
        $data['totalNonAktif'] = $totalNonAktif;

        return view('auth/dashboard', $data);
    }

    public function logout()
    {
        session()->destroy();

        delete_cookie('remember_me');

        return redirect()->to('/login')->with('success', 'Anda berhasil logout.');
    }

    public function registerGoogle()
    {
        return view('auth/register_google');
    }

    public function registerGoogleProcess()
    {
        $validation = \Config\Services::validation();
        $validation->setRules([
            'username' => 'required',
            'password' => 'required|min_length[6]',
            'confirm_password' => 'required|matches[password]'
        ], [
            'confirm_password' => [
                'matches' => 'Konfirmasi password tidak sesuai dengan password.'
            ]
        ]);

        if (!$this->validate($validation->getRules())) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        $userModel = new \App\Models\UserModel();

        $data = [
            'username' => $this->request->getPost('username'),
            'email'    => session()->get('google_email'),
            'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
        ];

        if ($userModel->save($data)) {
            $user = $userModel->where('email', $data['email'])->first();

            session()->set([
                'user_id'   => $user['id'],
                'username'  => $user['username'],
                'email'     => $user['email'],
                'logged_in' => true
            ]);

            return redirect()->to('/auth/dashboard');
        } else {
            return redirect()->back()->withInput()->with('errors', $userModel->errors());
        }
    }

    public function googleLogin()
    {
        $client = new Google_Client();
        $client->setClientId(env('GOOGLE_CLIENT_ID'));
        $client->setClientSecret(env('GOOGLE_CLIENT_SECRET'));
        $client->setRedirectUri(env('GOOGLE_REDIRECT_URI'));
        $client->addScope("email");
        $client->addScope("profile");

        $authUrl = $client->createAuthUrl();
        return redirect()->to($authUrl);
    }

    public function googleCallback()
    {
        require_once ROOTPATH . 'vendor/autoload.php';

        $client = new Google_Client();
        $client->setClientId(env('GOOGLE_CLIENT_ID'));
        $client->setClientSecret(env('GOOGLE_CLIENT_SECRET'));
        $client->setRedirectUri(env('GOOGLE_REDIRECT_URI'));
        $client->addScope("email");
        $client->addScope("profile");

        $code = $this->request->getGet('code');

        if ($code) {
            $token = $client->fetchAccessTokenWithAuthCode($code);

            if (isset($token['error'])) {
                return redirect()->to('/login')->with('error', 'Token tidak valid dari Google.');
            }

            $client->setAccessToken($token);
            $oauth2 = new Oauth2($client);
            $googleUser = $oauth2->userinfo->get();

            $email = $googleUser->email;
            $userModel = new \App\Models\UserModel();
            $user = $userModel->where('email', $email)->first();

            if ($user) {
                // Auto-login
                session()->set([
                    'user_id'   => $user['id'],
                    'username'  => $user['username'],
                    'email'     => $user['email'],
                    'logged_in' => true
                ]);
                return redirect()->to('/auth/dashboard');
            } else {
                // Belum terdaftar, redirect ke form registerGoogle
                session()->set('google_email', $email);
                return redirect()->to('/auth/registerGoogle');
            }
        }

        return redirect()->to('/login')->with('error', 'Gagal login dengan Google.');
    }

    private function getNotifikasiTagihan()
    {
        $db = \Config\Database::connect('db_rekapitulasi_tagihan_air');

        return $db->table('notifikasi_tagihan')
        ->where('dilihat', 0)
        ->orderBy('waktu', 'DESC')
            ->limit(10)
            ->get()
            ->getResultArray();
    }

    private function getNotifikasiBaruCount(): int
    {
        $db = \Config\Database::connect('db_rekapitulasi_tagihan_air');

        return $db->table('notifikasi_tagihan')
            ->where('dilihat', 0)
            ->countAllResults();
    }

    public function forgot()
    {
        return view('auth/forgot');
    }

    public function forgotProcess()
    {
        $email = $this->request->getPost('email');
        $user = $this->userModel->where('email', $email)->first();

        if (!$user) {
            return redirect()->back()->with('error', 'Email Anda tidak ditemukan.');
        }

        // Generate token dan waktu kadaluarsa
        $token = bin2hex(random_bytes(32));
        $expired = date('Y-m-d H:i:s', strtotime('+1 hour'));

        // Simpan token ke database
        $this->userModel->update($user['id'], [
            'reset_token'      => $token,
            'token_expired_at' => $expired
        ]);

        // Kirim email ke pengguna
        $resetLink = base_url('/auth/resetPassword/' . $token);

        $emailService = \Config\Services::email();
        $emailService->setTo($email);
        $emailService->setFrom('akunemail@gmail.com', 'Sistem Notifikasi');
        $emailService->setSubject('Permintaan Reset Password');
        $emailService->setMailType('html');
        $emailService->setMessage("
            <p>Hai <b>{$user['username']}</b>,</p>
            <p>Kami menerima permintaan untuk mereset password Anda.</p>
            <p>Klik link berikut ini untuk mengatur ulang password Anda:</p>
            <p><a href='{$resetLink}'>{$resetLink}</a></p>
            <p>Link ini hanya berlaku selama 1 jam.</p>
            <br>
            <p>Jika Anda tidak meminta reset ini, abaikan email ini.</p>
            <p><b>Sistem Notifikasi</b></p>
        ");

        if ($emailService->send()) {
            return redirect()->to('/login')->with('success', 'Link reset telah dikirim ke email Anda.');
        } else {
            log_message('error', 'Gagal mengirim email: ' . $emailService->printDebugger(['headers']));
            return redirect()->back()->with('error', 'Gagal mengirim email. Coba lagi.');
        }
    }

    public function resetPassword($token)
    {
        $user = $this->userModel->where('reset_token', $token)->first();

        if (!$user || strtotime($user['token_expired_at']) < time()) {
            return redirect()->to('/login')->with('error', 'Token tidak valid atau kadaluarsa.');
        }

        return view('auth/reset_password', ['token' => $token]);
    }

    public function resetProcess()
    {
        $token    = $this->request->getPost('token');
        $password = $this->request->getPost('password');
        $confirm  = $this->request->getPost('confirm_password');

        if ($password !== $confirm) {
            return redirect()->back()->with('error', 'Konfirmasi password tidak cocok.');
        }

        $user = $this->userModel->where('reset_token', $token)->first();

        if (!$user || strtotime($user['token_expired_at']) < time()) {
            return redirect()->to('/login')->with('error', 'Token tidak valid atau sudah kadaluarsa.');
        }

        $this->userModel->update($user['id'], [
            'password'         => password_hash($password, PASSWORD_DEFAULT),
            'reset_token'      => null,
            'token_expired_at' => null
        ]);

        return redirect()->to('/login')->with('success', 'Password berhasil direset. Silakan login.');
    }

    public function resetKataSandi($token)
    {
        $user = $this->userModel->where('reset_token', $token)->first();
        if (!$user || strtotime($user['token_expired_at']) < time()) {
            return redirect()->to('/login')->with('error', 'Token tidak valid atau kadaluarsa.');
        }

        return view('auth/reset_password', ['token' => $token]);
    }

    private function getGeoLocation($ip)
    {
        if ($ip === '127.0.0.1' || $ip === '::1') {
            $lokasi = 'Localhost';
        } else {
            $json = @file_get_contents("http://ip-api.com/json/{$ip}");
            if ($json) {
                $data = json_decode($json, true);
                if (isset($data['status']) && $data['status'] === 'success') {
                    $city = $data['city'] ?? '';
                    $country = $data['country'] ?? '';
                    $lokasi = trim("{$city}, {$country}");
                } else {
                    $lokasi = 'Unknown';
                }
            } else {
                $lokasi = 'Unknown';
            }
        }

        if (session()->get('isLoggedIn')) {
            $userId = session()->get('user_id');
            $db = \Config\Database::connect();
            $builder = $db->table('user_locations');
            $builder->insert([
                'user_id' => $userId,
                'ip_address' => $ip,
                'location' => $lokasi
            ]);
        }

        return $lokasi;
    }

}
