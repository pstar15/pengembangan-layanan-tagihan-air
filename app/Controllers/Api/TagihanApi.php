<?php

namespace App\Controllers\Api;

use App\Models\TagihanAplikasiModel;
use CodeIgniter\RESTful\ResourceController;

class TagihanApi extends ResourceController
{
    protected $format = 'json';
    protected $modelName = 'App\Models\TagihanAplikasiModel';

    public function index()
    {
        //
        $model = new TagihanAplikasiModel();
        $data = $model->findAll();
        return $this->respond(['status' => true, 'data' => $data], 200);
    }

    public function simpan()
    {
        $data = $this->request->getJSON(true);

        if (!$data) {
            return $this->respond([
                'status' => false,
                'message' => 'Data JSON tidak valid'
            ], 400);
        }

        $model = new TagihanAplikasiModel();
        $model->insert($data);

        return $this->respond([
            'status' => true,
            'message' => 'Data tagihan berhasil disimpan'
        ], 200);
    }

    public function cardData()
    {
        $db = \Config\Database::connect('db_tagihanaplikasi');

        $total = $db->table('tagihanaplikasi')->countAll();
        $lunas = $db->table('tagihanaplikasi')->where('status', 'Lunas')->countAllResults();
        $belum = $db->table('tagihanaplikasi')->where('status !=', 'Lunas')->countAllResults();

        $totalTagihan = $db->table('tagihanaplikasi')->selectSum('jumlah_tagihan')->get()->getRow()->jumlah_tagihan ?? 0;
        $lunasTagihan = $db->table('tagihanaplikasi')->where('status', 'Lunas')->selectSum('jumlah_tagihan')->get()->getRow()->jumlah_tagihan ?? 0;
        $belumTagihan = $totalTagihan - $lunasTagihan;

        return $this->respond([
            'status' => true,
            'data' => [
                'total' => $total,
                'lunas' => $lunas,
                'belum_lunas' => $belum,
                'total_tagihan' => (int) $totalTagihan,
                'total_lunas' => (int) $lunasTagihan,
                'total_belum_lunas' => (int) $belumTagihan
            ]
        ]);
    }

    public function update($id = null)
    {
        $data = $this->request->getJSON(true);

        if (!$data) {
            return $this->fail(['message' => 'Data tidak boleh kosong'], 400);
        }

        $model = new TagihanAplikasiModel();
        $tagihan = $model->find($id);

        if (!$tagihan) {
            return $this->failNotFound("Data dengan ID $id tidak ditemukan");
        }

        $updateData = [
            'nama_pelanggan' => $data['nama_pelanggan'] ?? $tagihan['nama_pelanggan'],
            'alamat'         => $data['alamat'] ?? $tagihan['alamat'],
            'nomor_meter'    => $data['nomor_meter'] ?? $tagihan['nomor_meter'],
            'jumlah_meter'   => $data['jumlah_meter'] ?? $tagihan['jumlah_meter'],
            'periode'        => $data['periode'] ?? $tagihan['periode'],
            'jumlah_tagihan' => $data['jumlah_tagihan'] ?? $tagihan['jumlah_tagihan'],
            'status'         => $data['status'] ?? $tagihan['status'],
            'updated_at'     => date('Y-m-d H:i:s')
        ];

        $model->update($id, $updateData);

        return $this->respond([
            'status' => true,
            'message' => 'Data berhasil diperbarui',
            'data' => $updateData
        ]);
    }

    public function delete($id = null)
    {
        $model = new \App\Models\TagihanAplikasiModel();

        // Cek apakah data dengan ID tersebut ada
        $tagihan = $model->find($id);
        if (!$tagihan) {
            return $this->failNotFound("Data dengan ID $id tidak ditemukan");
        }

        // Hapus data
        if ($model->delete($id)) {
            return $this->respond([
                'status' => true,
                'message' => "Data berhasil dihapus"
            ], 200);
        }

        // Jika gagal menghapus
        return $this->failServerError("Gagal menghapus data");
    }

    public function kirim()
    {
        log_message('info', 'API - Memproses kirim tagihan...');

        $data = $this->request->getJSON(true);
        log_message('info', 'Data diterima: ' . json_encode($data));

        if (!$data || !is_array($data)) {
            return $this->respond(['status' => false, 'message' => 'Data tidak valid'], 400);
        }

        if (!isset($data['nama_pelanggan']) || !isset($data['jumlah_tagihan'])) {
            return $this->respond(['status' => false, 'message' => 'Field wajib tidak ada'], 400);
        }

        try {
            // Simpan ke database aplikasi
            $dbAplikasi = \Config\Database::connect('db_tagihanaplikasi');
            $dbAplikasi->table('riwayataplikasi')->insert($data);

            // Simpan ke database pusat
            $dbPusat = \Config\Database::connect('db_rekapitulasi_tagihan_air');
            $dbPusat->table('riwayat_tagihan')->insert($data);

            // Simpan notifikasi
            $bulanTahun = date('m/Y');
            $waktu = date('Y-m-d H:i:s');
            $judul = "Tagihan $bulanTahun berhasil dikirim";
            $deskripsi = "Tagihan bulan $bulanTahun telah dikirim pada $waktu.";

            $dbPusat->table('notifikasi_tagihan')->insert([
                'judul' => $judul,
                'deskripsi' => $deskripsi,
                'waktu' => $waktu
            ]);

            return $this->respond([
                'status' => true,
                'message' => 'Data berhasil dikirim dan notifikasi ditambahkan.'
            ]);
        } catch (\Throwable $e) {
            log_message('error', 'Gagal kirim tagihan: ' . $e->getMessage());
            return $this->respond([
                'status' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }


    public function show($id = null)
    {
        // Ambil model
        $model = new TagihanAplikasiModel();

        // Cek apakah data dengan ID tersedia
        $data = $model->find($id);

        // Jika tidak ditemukan
        if (!$data) {
            return $this->failNotFound("Data dengan ID $id tidak ditemukan.");
        }

        // Jika ditemukan
        return $this->respond([
            'status' => true,
            'data' => $data
        ]);
    }

}
