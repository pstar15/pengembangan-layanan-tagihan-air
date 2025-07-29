<?php

namespace App\Controllers;

use App\Models\TagihanModel;
use App\Controllers\BaseController;
use App\Models\PhoneUser;
use App\Models\RiwayatTagihanModel;
use App\Models\TagihanAplikasiModel;
use Config\Database;

class Tagihan extends BaseController
{
    protected $TagihanModel;
    protected $TagihanAplikasiModel;

    public function __construct()
    {
        $this->TagihanModel         = new TagihanModel();
        $this->TagihanAplikasiModel = new TagihanAplikasiModel();
    }

    public function index()
    {
        //
        $model = new TagihanModel();
        $keyword = $this->request->getGet('keyword');
        $status  = $this->request->getGet('status');
        $userId  = session()->get('user_id');
        $PhoneUser = new PhoneUser();
        
        $query = $model->where('user_id', $userId);

        $query = $model;

        if ($keyword) {
            $query = $query->like('nama_pelanggan', $keyword)->orLike('nomor_meter', $keyword);
        }

        if ($status) {
            $query = $query->where('status', $status);
        }

        $data['tagihan'] = $query->findAll();
        $data['notifikasi'] = $this->getNotifikasiTagihan();
        $data['notifikasi_baru'] = $this->getNotifikasiBaruCount();
        $data['akun_android'] = $PhoneUser->findAll();

        return view('tagihan/index', $data);
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

    public function create()
    {
        return view('tagihan/create');
    }

    public function store()
    {
        $validation = \Config\Services::validation();
        $validation->setRules([
            'nama_pelanggan' => 'required',
            'alamat'         => 'required',
            'nomor_meter'    => 'required|exact_length[8]',
            'jumlah_meter'   => 'required|numeric',
            'periode'        => 'required',
            'jumlah_tagihan' => 'required',
            'status'         => 'required|in_list[Lunas,Belum Lunas,Tidak Ada]',
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Silakan isi semua data dengan benar. Pastikan No. Meter berisi 8 karakter.');
        }

        $model = new \App\Models\TagihanModel();
        $model->save([
            'user_id'        => session()->get('user_id'),
            'nama_pelanggan' => $this->request->getPost('nama_pelanggan'),
            'alamat'         => $this->request->getPost('alamat'),
            'nomor_meter'    => $this->request->getPost('nomor_meter'),
            'jumlah_meter'   => $this->request->getPost('jumlah_meter'),
            'periode'        => $this->request->getPost('periode'),
            'jumlah_tagihan' => $this->request->getPost('jumlah_tagihan'),
            'status'         => $this->request->getPost('status'),
        ]);

        return redirect()->to('/tagihan')->with('success', 'Selamat, Data Tagihan berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $userId = session()->get('user_id');
        $model = new TagihanModel();
        $data['tagihan'] = $model->where('user_id', $userId)->find($id);

        if (!$data['tagihan']) {
            return redirect(`/tagihan`)->with('error', 'Mohon maaf, data anda tidak ditemukan.');
        }

        return view('/tagihan/edit', $data);
    }

    public function update($id)
    {
        $userId = session()->get('user_id');
        $model = new TagihanModel();

        $tagihan = $model->where('user_id', $userId)->find($id);
        if (!$tagihan) {
            return redirect(`/tagihan`)->with('error', 'Mohon maaf, data anda tidak ditemukan.');
        }

        $data = [
            'nama_pelanggan' => $this->request->getPost('nama_pelanggan'),
            'alamat'         => $this->request->getPost('alamat'),
            'nomor_meter'    => $this->request->getPost('nomor_meter'),
            'jumlah_meter'   => $this->request->getPost('jumlah_meter'),
            'periode'        => $this->request->getPost('periode'),
            'jumlah_tagihan' => $this->request->getPost('jumlah_tagihan'),
            'status'         => $this->request->getPost('status'),
        ];

        if (empty($data['nama_pelanggan']) || empty($data['nomor_meter'])) {
            return redirect()->back()->withInput()->with('error', 'Mohon maaf, data tidak boleh kosong.');
        }

        $model->update($id, $data);

        $data['tagihan'] = $model->where('user_id', $userId)->find($id);

        return redirect()->to('/tagihan')->with('success', 'Selamat, Data tagihan berhasil diupdate!');
    }

    public function delete($id)
    {
        $userId = session()->get('user_id');
        $model = new TagihanModel();

        $tagihan = $model->where('id', $id)->where('user_id', $userId)->first();
        if (!$tagihan) {
            return redirect()->to('/tagihan')->with('error', 'Mohon maaf, data anda tidak ditemukan.');
        }

        if ($model->delete($id)) {
            return redirect()->to('/tagihan')->with('seccess', 'Selamat, Data tagihan anda berhasil dihapus.');
        } else {
            return redirect()->to('/tagihan')->with('error', 'Gagal menghapus data tagihan, silahkan coba lagi.');
        }
    }
    public function lunas()
    {
        $userId = session()->get('user_id');
        $model = new TagihanModel();
        $data['tagihan'] = $model->where('user_id', $userId)->where('status', 'Lunas')->findAll();
        return view('tagihan/index', $data);
    }

    public function belumLunas()
    {
        $userId = session()->get('user_id');
        $model = new TagihanModel();
        $data['tagihan'] = $model->where('user_id', $userId)->where('status', 'Belum Lunas')->findAll();
        return view('tagihan/index', $data);
    }

    public function riwayat()
    {
        $periode = $this->request->getGet('periode');
        $model = new RiwayatTagihanModel();
            $periode = $this->request->getGet('periode');

            if ($periode && preg_match('/^\d{4}-\d{2}$/', $periode)) {
                $data['riwayat'] = $model->like('periode', $periode)->findAll();
            } else {
                $data['riwayat'] = $model->findAll();
            }

            $data['periode'] = $periode;

            return view('tagihan/riwayat', $data);
    }

    public function kirimMultiUser()
    {
        $request = $this->request->getJSON(true);

        $tagihanId = $request['tagihan_id'] ?? null;
        $userIds = $request['user_ids'] ?? [];

        if (!$tagihanId || empty($userIds)) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Data tidak lengkap.'
            ]);
        }

        $tagihanModel = new \App\Models\TagihanModel();
        $tagihan = $tagihanModel->find($tagihanId);
        if (!$tagihan) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Data tagihan tidak ditemukan.'
            ]);
        }

        $dbApp = \Config\Database::connect('db_tagihanaplikasi');
        $inserted = 0;

        foreach ($userIds as $userId) {
            $cek = $dbApp->table('tagihanaplikasi')
                ->where('user_id', $userId)
                ->where('nomor_meter', $tagihan['nomor_meter'])
                ->where('periode', $tagihan['periode'])
                ->get()
                ->getRow();

            if ($cek) continue;

            $dbApp->table('tagihanaplikasi')->insert([
                'user_id' => $userId,
                'nama_pelanggan' => $tagihan['nama_pelanggan'],
                'alamat' => $tagihan['alamat'],
                'nomor_meter' => $tagihan['nomor_meter'],
                'jumlah_meter' => $tagihan['jumlah_meter'],
                'periode' => $tagihan['periode'],
                'jumlah_tagihan' => $tagihan['jumlah_tagihan'],
                'status' => $tagihan['status'],
            ]);
            $inserted++;
        }

        return $this->response->setJSON([
            'success' => true,
            'message' => "Berhasil mengirim ke $inserted akun."
        ]);
    }

}
