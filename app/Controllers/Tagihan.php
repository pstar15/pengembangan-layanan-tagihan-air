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

        $query = $model;

        if ($keyword) {
            $query = $query->like('nama_pelanggan', $keyword)->orLike('nomor_meter', $keyword);
        }

        if ($status) {
            $query = $query->where('status', $status);
        }

        $data['tagihan'] = $query->findAll();

        return view('tagihan/index', $data);
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
            'nomor_meter'    => 'required',
            'jumlah_meter'   => 'required',
            'periode'        => 'required',
            'jumlah_tagihan' => 'required|numeric',
            'status'         => 'required|in_list[Lunas,Belum Lunas, Tidak Ada]',
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Silakan isi semua data dengan benar.');
        }

        $model = new \App\Models\TagihanModel();
        $model->save([
            'nama_pelanggan' => $this->request->getPost('nama_pelanggan'),
            'alamat'         => $this->request->getPost('alamat'),
            'nomor_meter'    => $this->request->getPost('nomor_meter'),
            'jumlah_meter'   => $this->request->getPost('jumlah_meter'),
            'periode'        => $this->request->getPost('periode'),
            'jumlah_tagihan' => $this->request->getPost('jumlah_tagihan'),
            'status'         => $this->request->getPost('status'),
        ]);

        return redirect()->to('/tagihan')->with('success', 'Tagihan berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $model = new TagihanModel();
        $data['tagihan'] = $model->find($id);

        return view('/tagihan/edit', $data);
    }

    public function update($id)
    {
        $model = new TagihanModel();

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
            return redirect()->back()->withInput()->with('error', 'Data tidak boleh kosong.');
        }

        $model->update($id, $data);

        return redirect()->to('/tagihan')->with('success', 'Tagihan berhasil diupdate!');
    }

    public function delete($id)
    {
        $model = new TagihanModel();
        $model->delete($id);

        return redirect()->to('/tagihan')->with('success', 'Data tagihan berhasil dihapus.');
    }
    public function lunas()
    {
        $model = new TagihanModel();
        $data['tagihan'] = $model->where('status', 'Lunas')->findAll();
        return view('tagihan/index', $data);
    }

    public function belumLunas()
    {
        $model = new TagihanModel();
        $data['tagihan'] = $model->where('status', 'Belum Lunas', 'Tidak Ada')->findAll();
        return view('tagihan/index', $data);
    }
    public function simpanSemua()
    {
        $tagihanModel = new \App\Models\TagihanModel();
        $riwayatModel = new \App\Models\RiwayatTagihanModel();

        // Ambil semua data tagihan
        $dataTagihan = $tagihanModel->findAll();

        if (empty($dataTagihan)) {
            return redirect()->back()->with('error', 'Tidak ada data tagihan yang tersedia.');
        }

        foreach ($dataTagihan as $tagihan) {
            // Cek apakah data sudah lengkap
            if (
                !empty($tagihan['periode']) &&
                !empty($tagihan['jumlah_tagihan']) &&
                !empty($tagihan['status'])
            ) {
                // Simpan ke riwayat
                $riwayatModel->save([
                    'nama_pelanggan' => $tagihan['nama_pelanggan'],
                    'alamat'         => $tagihan['alamat'],
                    'nomor_meter'    => $tagihan['nomor_meter'],
                    'jumlah_meter'   => $tagihan['jumlah_meter'],
                    'periode'        => $tagihan['periode'],
                    'jumlah_tagihan' => $tagihan['jumlah_tagihan'],
                    'status'         => $tagihan['status'],
                ]);

                // Kosongkan kolom tertentu di tabel tagihan untuk penagihan berikutnya
                $tagihanModel->update($tagihan['id'], [
                    'periode'        => null,
                    'jumlah_tagihan' => null,
                    'status'         => null,
                ]);
            }
        }

        return redirect()->to('/tagihan')->with('success', 'Data berhasil dipindahkan ke riwayat. Data kosong tetap berada di tabel tagihan.');
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
        $tagihanModel = new \App\Models\TagihanModel();
        $data = $tagihanModel->find($id);

        if (!$data) {
            return redirect()->back()->with('error', 'Data tidak ditemukan.');
        }

        $dbAplikasi = \Config\Database::connect('db_tagihanaplikasi');

        $cek = $dbAplikasi->table('tagihanaplikasi')
            ->where('nomor_meter', $data['nomor_meter'])
            ->where('periode', $data['periode'])
            ->get()
            ->getRow();

        if ($cek) {
            return redirect()->back()->with('warning', 'Data ini sudah pernah dikirim.');
        }

        $dbAplikasi->table('tagihanaplikasi')->insert([
            'nama_pelanggan' => $data['nama_pelanggan'],
            'alamat' => $data['alamat'],
            'nomor_meter' => $data['nomor_meter'],
            'jumlah_meter' => $data['jumlah_meter'],
            'periode' => $data['periode'], // tetap dikirim
            'jumlah_tagihan' => $data['jumlah_tagihan'],
            'status' => $data['status'],
        ]);

        $tagihanModel->update($id, [
            'jumlah_tagihan' => null,
            'status' => 'Tidak Ada'
        ]);

        return redirect()->back()->with('success', 'Data berhasil dikirim dan disiapkan untuk periode berikutnya.');
    }
    
}
