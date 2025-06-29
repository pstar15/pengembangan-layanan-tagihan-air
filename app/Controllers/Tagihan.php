<?php

namespace App\Controllers;

use Dompdf\Dompdf;
use App\Models\TagihanModel;
use App\Controllers\BaseController;
use App\Models\RiwayatTagihanModel;
use CodeIgniter\HTTP\ResponseInterface;

class Tagihan extends BaseController
{
    protected $TagihanModel;

    public function __construct()
    {
        $this->TagihanModel = new TagihanModel();
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
            'status'         => 'required|in_list[Lunas,Belum Lunas]',
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Silakan isi semua data dengan benar.');
        }

        // Simpan data jika valid
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

        // Optional: validasi sederhana
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
        $data['tagihan'] = $model->where('status', 'Belum Lunas')->findAll();
        return view('tagihan/index', $data);
    }
    public function simpanSemua()
    {
        $tagihanModel = new TagihanModel();
        $riwayatModel = new RiwayatTagihanModel();

        $semuaTagihan = $tagihanModel->findAll();

        foreach ($semuaTagihan as $row) {
            $riwayatModel->save([
                'nama_pelanggan' => $row['nama_pelanggan'],
                'alamat'         => $row['alamat'],
                'nomor_meter'    => $row['nomor_meter'],
                'jumlah_meter'   => $row['jumlah_meter'],
                'periode'        => $row['periode'],
                'jumlah_tagihan' => $row['jumlah_tagihan'],
                'status'         => $row['status'],
                'created_at'     => date('Y-m-d H:i:s')
            ]);
        }

        $tagihanModel->truncate();

        return redirect()->to('/tagihan')->with('success', 'Semua tagihan berhasil dipindahkan ke riwayat.');
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
}
