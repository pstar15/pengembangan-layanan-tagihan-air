<?php

namespace App\Controllers\Api;

use App\Models\TagihanAplikasiModel;
use CodeIgniter\RESTful\ResourceController;

class TagihanApi extends ResourceController
{
    protected $format = 'json';

    public function index()
    {
        //
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

}
