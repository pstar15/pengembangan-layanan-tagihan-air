<?php

namespace App\Controllers;

use App\Models\PhoneUser;
use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class SettingAccountApp extends BaseController
{
    public function index()
    {
        //
        $userId = session()->get('user_id');
        
        if (!$userId) {
            return redirect()->to('/login')->with('error', 'Silakan login terlebih dahulu.');
        }

        $model = new PhoneUser();
        $data['akun'] = $model->findAll();

        return view('account/account_aplikasi', $data);
    }

    public function edit($id)
    {
        $userId = session()->get('user_id');
        
        if (!$userId) {
            return redirect()->to('/login')->with('error', 'Silakan login terlebih dahulu.');
        }

        $model = new PhoneUser();
        $data['akun'] = $model->find($id);

        return view('account/edit_account_app', $data);
    }

    public function update($id)
    {
        $model = new PhoneUser();
        $akun = $model->find($id);

        if (!$akun) {
            return redirect()->to('/account')->with('error', 'Mohon maaf akun tidak ditemukan.');
        }

        $data = [
            'username'   => $this->request->getPost('username'),
            'email'      => $this->request->getPost('email'),
            'is_online'  => $this->request->getPost('is_online'),
        ];

        $passwordLama = $this->request->getPost('password_lama');
        $passwordBaru = $this->request->getPost('password_baru');
        $konfirmasi   = $this->request->getPost('konfirmasi_password');

        // Jika user ingin mengganti password
        if (!empty($passwordLama) || !empty($passwordBaru) || !empty($konfirmasi)) {
            // Cek password lama
            if (!password_verify($passwordLama, $akun['password'])) {
                return redirect()->back()->withInput()->with('error', 'Password lama yang anda masukkan salah, silakan coba lagi.');
            }

            // Cek konfirmasi
            if ($passwordBaru !== $konfirmasi) {
                return redirect()->back()->withInput()->with('error', 'Konfirmasi password yang anda masukkan tidak sesuai, silakan coba lagi.');
            }

            // Simpan password baru
            $data['password'] = password_hash($passwordBaru, PASSWORD_DEFAULT);
        }

        $model->update($id, $data);
        return redirect()->to('/account')->with('success', 'Selamat, akun berhasil diperbarui.');
    }

    public function delete($id)
    {
        $model = new PhoneUser();
        $model->delete($id);
        return redirect()->to('/account')->with('success', 'Selamat, akun berhasil dihapus.');
    }
}
