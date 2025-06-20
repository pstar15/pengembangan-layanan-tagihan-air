<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\TagihanModel;
use App\Controllers\BaseController;
use App\Models\RiwayatTagihanModel;
use CodeIgniter\HTTP\ResponseInterface;

class Auth extends BaseController
{
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
        return view('auth/login');
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
        return redirect()->to('/login')->with('success', 'Registrasi berhasil!');
    }

    public function loginProcess()
    {
        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');

        $userModel = new \App\Models\UserModel();
        $user = $userModel->where('email', $email)->first();

        if ($user && password_verify($password, $user['password'])) {
            session()->set([
                'user_id'   => $user['id'],
                'username'  => $user['username'],
                'email'     => $user['email'],
                'logged_in' => true
            ]);
            

            return redirect()->to('/auth/dashboard');
        } else {
            return redirect()->back()->withInput()->with('error', 'Email atau password salah.');
        }
    }

    public function dashboard()
    {
        if (!session()->get('logged_in')) {
            return redirect()->to('/login')->with('error', 'Silakan login terlebih dahulu.');
        }

        $TagihanModel = new TagihanModel();
        $RiwayatTagihanModel = new RiwayatTagihanModel();

        // Ambil data tagihan dari kedua tabel, lalu gabungkan dan hitung per periode
        $tagihan = $TagihanModel->select('periode, SUM(jumlah_tagihan) as total')
                                ->groupBy('periode')
                                ->findAll();

        $riwayat = $RiwayatTagihanModel->select('periode, SUM(jumlah_tagihan) as total')
                                    ->groupBy('periode')
                                    ->findAll();

        // Gabungkan data berdasarkan periode
        $gabungan = [];

        foreach ($tagihan as $t) {
            $gabungan[$t['periode']] = $t['total'];
        }

        foreach ($riwayat as $r) {
            if (isset($gabungan[$r['periode']])) {
                $gabungan[$r['periode']] += $r['total'];
            } else {
                $gabungan[$r['periode']] = $r['total'];
            }
        }

        ksort($gabungan); // Urutkan berdasarkan periode

        // Siapkan data untuk chart
        $periode = array_keys($gabungan);
        $total = array_values($gabungan);

        $data['periode'] = json_encode($periode);
        $data['total'] = json_encode($total);

        // Tambahkan informasi dashboard lainnya jika ada
        $data['total_tagihan'] = $TagihanModel->countAll() + $RiwayatTagihanModel->countAll();
        $data['total_lunas'] = $TagihanModel->where('status', 'Lunas')->countAllResults() +
                            $RiwayatTagihanModel->where('status', 'Lunas')->countAllResults();
        $data['total_belum_lunas'] = $TagihanModel->where('status', 'Belum Lunas')->countAllResults() +
                                    $RiwayatTagihanModel->where('status', 'Belum Lunas')->countAllResults();
        $data['username'] = session()->get('username');
        $data['tagihan'] = $RiwayatTagihanModel->findAll();

        return view('auth/dashboard', $data);
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login')->with('success', 'Anda berhasil logout.');
    }
}
