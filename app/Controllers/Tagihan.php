<?php

namespace App\Controllers;

use App\Models\TagihanModel;
use App\Controllers\BaseController;
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

        $tagihan = $model->where('user_id', $userId)->find($id);
        if (!$tagihan) {
            return redirect()->to('/tagihan')->with('error', 'Mohon maaf, data anda tidak ditemukan.');
        }

        $model->delete($id);

        return redirect()->to('/tagihan')->with('success', 'Selamat, Data tagihan berhasil dihapus.');
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

    public function kirimData($id = null)
    {
        $userId = session()->get('user_id');
        $tagihanModel = new \App\Models\TagihanModel();
        $data = $tagihanModel->where('user_id', $userId)->find($id);

        if (!$data) {
            return redirect()->back()->with('error', 'Mohon maaf, data tidak ditemukan.');
        }

        $dbAplikasi = \Config\Database::connect('db_tagihanaplikasi');

        $cek = $dbAplikasi->table('tagihanaplikasi')
            ->where('nomor_meter', $data['nomor_meter'])
            ->where('periode', $data['periode'])
            ->get()
            ->getRow();

        if ($cek) {
            return redirect()->back()->with('warning', 'Mohon maaf, data ini sudah pernah dikirim.');
        }

        $dbAplikasi->table('tagihanaplikasi')->insert([
            'nama_pelanggan' => $data['nama_pelanggan'],
            'alamat' => $data['alamat'],
            'nomor_meter' => $data['nomor_meter'],
            'jumlah_meter' => $data['jumlah_meter'],
            'periode' => $data['periode'],
            'jumlah_tagihan' => $data['jumlah_tagihan'],
            'status' => $data['status'],
        ]);

        $tagihanModel->update($id, [
            'jumlah_tagihan' => null,
            'status' => 'Tidak Ada'
        ]);

        return redirect()->back()->with('success', 'Selamat, data berhasil dikirim dan disiapkan untuk periode berikutnya.');
    }
}
