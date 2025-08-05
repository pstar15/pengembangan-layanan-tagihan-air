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

        $tagihan = $model->find($id);
        if (!$tagihan) {
            return $this->failNotFound("Data dengan ID $id tidak ditemukan");
        }

        if ($model->delete($id)) {
            return $this->respond([
                'status' => true,
                'message' => "Data berhasil dihapus"
            ], 200);
        }

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

        // Validasi field
        $required = ['nama_pelanggan', 'nomor_meter', 'periode', 'jumlah_tagihan', 'user_id'];
        foreach ($required as $field) {
            if (empty($data[$field])) {
                return $this->respond([
                    'status' => false,
                    'message' => "Field '$field' wajib diisi"
                ], 400);
            }
        }

        try {
            $dbAplikasi = \Config\Database::connect('db_tagihanaplikasi');
            $dbRekap = \Config\Database::connect('db_rekapitulasi_tagihan_air');

            // Simpan ke table riwayat aplikasi
            $dbAplikasi->table('riwayataplikasi')->insert([
                'user_id' => $data['user_id'],
                'nama_pelanggan' => $data['nama_pelanggan'],
                'alamat' => $data['alamat'] ?? null,
                'nomor_meter' => $data['nomor_meter'],
                'jumlah_meter' => $data['jumlah_meter'] ?? null,
                'periode' => $data['periode'],
                'jumlah_tagihan' => $data['jumlah_tagihan'],
                'status' => $data['status'] ?? 'Belum Lunas',
                'created_at' => date('Y-m-d H:i:s')
            ]);

            // Simpan ke table riwayat_tagian
            $dbRekap->table('riwayat_tagihan')->insert([
                'user_id' => $data['user_id'],
                'nama_pelanggan' => $data['nama_pelanggan'],
                'alamat' => $data['alamat'] ?? null,
                'nomor_meter' => $data['nomor_meter'],
                'jumlah_meter' => $data['jumlah_meter'] ?? null,
                'periode' => $data['periode'],
                'jumlah_tagihan' => $data['jumlah_tagihan'],
                'status' => $data['status'] ?? 'Belum Lunas',
                'created_at' => date('Y-m-d H:i:s')
            ]);

            // Notifikasi
            $judul = sprintf(
                "Tagihan atas nama %s (%s) periode %s sebesar Rp%s telah dikirim",
                $data['nama_pelanggan'],
                $data['nomor_meter'],
                $data['periode'],
                number_format((int)$data['jumlah_tagihan'], 0, ',', '.')
            );

            $waktu = date('Y-m-d H:i:s');
            $deskripsi = "Pengiriman berhasil dilakukan pada $waktu.";

            $dbRekap->table('notifikasi_tagihan')->insert([
                'user_id' => $data['user_id'],
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
        $model = new TagihanAplikasiModel();

        $data = $model->find($id);

        if (!$data) {
            return $this->failNotFound("Data dengan ID $id tidak ditemukan.");
        }

        return $this->respond([
            'status' => true,
            'data' => $data
        ]);
    }
}
