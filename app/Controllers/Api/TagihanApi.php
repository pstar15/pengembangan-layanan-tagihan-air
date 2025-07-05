<?php

namespace App\Controllers\Api;

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
        $data = $this->request->getJSON(true); // true untuk array asosiatif

        // Contoh validasi sederhana
        if (!isset($data['nama_pelanggan']) || !isset($data['nomor_meter'])) {
            return $this->fail('Data tidak lengkap', 400);
        }

        $db = \Config\Database::connect();
        $builder = $db->table('tagihan');

        $simpan = $builder->insert($data);

        if ($simpan) {
            return $this->respond(['status' => true, 'message' => 'Tagihan berhasil disimpan']);
        } else {
            return $this->fail('Gagal menyimpan', 500);
        }
    }

}
