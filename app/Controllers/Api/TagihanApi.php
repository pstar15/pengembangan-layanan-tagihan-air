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

    public function update($id = null)
    {
        $json = $this->request->getJSON();
        $model = new TagihanAplikasiModel();

        $data = [
            'nama_pelanggan' => $json->namaPelanggan,
            'alamat' => $json->alamat,
            'nomor_meter' => $json->nomorMeter,
            'jumlah_meter' => $json->jumlahMeter,
            'periode' => $json->periode,
            'jumlah_tagihan' => $json->jumlahTagihan,
            'status' => $json->status,
            'updated_at' => date('Y-m-d H:i:s')
        ];

        $model->update($id, $data);

        return $this->respond(['message' => 'Data berhasil diupdate']);
    }

}
