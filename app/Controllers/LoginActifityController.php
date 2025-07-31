<?php

namespace App\Controllers;

use App\Models\RiwayatLoginModel;
use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class LoginActifityController extends BaseController
{
    public function index()
    {
        //
        $loginModel = new RiwayatLoginModel();

        $userId = session()->get('user_id');
        
        if (!$userId) {
            return redirect()->to('/login')->with('error', 'Silakan login terlebih dahulu.');
        }

        $riwayat = $loginModel->where('user_id', $userId)
            ->orderBy('waktu', 'DESC')
            ->findAll(50);

        $data['riwayat_login'] = $riwayat;
        $data['notifikasi'] = $this->getNotifikasiTagihan();
        $data['notifikasi_baru'] = $this->getNotifikasiBaruCount();

        return view('account/login_aktivity', $data);
    }

    private function getNotifikasiTagihan()
    {
        $db = \Config\Database::connect('db_rekapitulasi_tagihan_air');
        return $db->table('notifikasi_tagihan')
            ->where('dilihat', 0)
            ->orderBy('waktu', 'DESC')
            ->limit(10)
            ->get()
            ->getResultArray();
    }

    private function getNotifikasiBaruCount(): int
    {
        $db = \Config\Database::connect('db_rekapitulasi_tagihan_air');
        return $db->table('notifikasi_tagihan')
            ->where('dilihat', 0)
            ->countAllResults();
    }
}
