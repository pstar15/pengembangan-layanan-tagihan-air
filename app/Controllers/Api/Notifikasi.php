<?php

namespace App\Controllers\Api;

use CodeIgniter\RESTful\ResourceController;

class Notifikasi extends ResourceController
{
    protected $format = 'json';

    public function index()
    {
        //
        $db = \Config\Database::connect('db_rekapitulasi_tagihan_air');
        $query = $db->table('notifikasi_tagihan')->orderBy('waktu', 'DESC')->get();
        $data = $query->getResult();

        return $this->respond([
            'status' => true,
            'data' => $data
        ]);
    }

    public function filterByMonthYear($bulan, $tahun)
    {
        $db = \Config\Database::connect('db_rekapitulasi_tagihan_air');

        $query = $db->table('notifikasi_tagihan')
            ->where("MONTH(waktu)", $bulan)
            ->where("YEAR(waktu)", $tahun)
            ->orderBy('waktu', 'DESC')
            ->get();

        $data = $query->getResult();

        return $this->respond([
            'status' => true,
            'data' => $data
        ]);
    }

    public function delete($id = null)
    {
        $db = \Config\Database::connect('db_rekapitulasi_tagihan_air');

        $check = $db->table('notifikasi_tagihan')->where('id', $id)->get()->getRow();
        if (!$check) {
            return $this->failNotFound("Notifikasi dengan ID $id tidak ditemukan.");
        }

        $db->table('notifikasi_tagihan')->where('id', $id)->delete();

        return $this->respond([
            'status' => true,
            'message' => 'Notifikasi berhasil dihapus.'
        ]);
    }
}
