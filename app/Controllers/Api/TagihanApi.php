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
        $data = $this->model->findAll();
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

    public function listDataTagihan()
    {
        $db = \Config\Database::connect('db_tagihanaplikasi');
        $query = $db->table('tagihanaplikasi')->get()->getResult();

        return $this->respond([
            'status' => true,
            'data' => $query
        ]);
    }

    public function kirimKDataTagihan()
    {
        $json = $this->request->getJSON(true);

        if (!$json || !is_array($json)) {
            return $this->respond(['status' => false, 'message' => 'Data tidak valid'], 400);
        }

        $db = \Config\Database::connect();
        $builder = $db->table('riwayat_tagihan');

        foreach ($json as $row) {
            $builder->insert([
                'nama_pelanggan' => $row['nama_pelanggan'],
                'alamat' => $row['alamat'],
                'nomor_meter' => $row['nomor_meter'],
                'jumlah_meter' => $row['jumlah_meter'],
                'periode' => $row['periode'],
                'jumlah_tagihan' => $row['jumlah_tagihan'],
                'status' => $row['status'],
                'created_at' => date('Y-m-d H:i:s')
            ]);
        }

        return $this->respond(['status' => true, 'message' => 'Data berhasil disimpan']);
    }

    public function riwayat()
    {
        $db = \Config\Database::connect();
        $riwayat = $db->table('riwayat_tagihan')->orderBy('created_at', 'DESC')->get()->getResult();

        return $this->respond([
            'status' => true,
            'data' => $riwayat
        ]);
    }

    public function getAllTagihan()
    {
        $model = new \App\Models\TagihanAplikasiModel();
        $data = $model->findAll();

        return $this->response->setJSON([
            'status' => true,
            'message' => 'Data tagihan berhasil dimuat',
            'data' => $data
        ]);
    }

    public function delete($id = null)
    {
        $model = new \App\Models\TagihanAplikasiModel();
        $deleted = $model->delete($id);

        if ($deleted) {
            return $this->response->setJSON(['status' => true, 'message' => 'Data berhasil dihapus']);
        } else {
            return $this->response->setJSON(['status' => false, 'message' => 'Gagal menghapus data']);
        }
    }

    public function update($id = null)
    {
        $model = new \App\Models\TagihanAplikasiModel();
        $data = $this->request->getJSON(true);
        $data['updated_at'] = date('Y-m-d H:i:s');

        $model->update($id, $data);
        return $this->response->setJSON(['status' => true, 'message' => 'Data berhasil diperbarui']);
    }

}
