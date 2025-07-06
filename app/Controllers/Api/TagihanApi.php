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

    public function getSummary()
    {
        $db = \Config\Database::connect();

        $total = $db->table('tagihan')->countAll();
        $lunas = $db->table('tagihan')->where('status', 'Lunas')->countAllResults();
        $belumLunas = $db->table('tagihan')->where('status !=', 'Lunas')->countAllResults();

        $totalTagihan = $db->table('tagihan')->selectSum('jumlah_tagihan')->get()->getRow()->jumlah_tagihan ?? 0;
        $lunasTagihan = $db->table('tagihan')->where('status', 'Lunas')->selectSum('jumlah_tagihan')->get()->getRow()->jumlah_tagihan ?? 0;
        $belumLunasTagihan = $totalTagihan - $lunasTagihan;

        return $this->respond([
            'status' => true,
            'data' => [
                'total' => $total,
                'lunas' => $lunas,
                'belum_lunas' => $belumLunas,
                'total_tagihan' => (int) $totalTagihan,
                'total_lunas' => (int) $lunasTagihan,
                'total_belum_lunas' => (int) $belumLunasTagihan
            ]
        ]);
    }

}
