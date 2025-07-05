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

}
