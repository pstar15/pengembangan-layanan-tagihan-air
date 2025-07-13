<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class Account extends BaseController
{
    public function index()
    {
        //
        $data['notifikasi'] = $this->getNotifikasiTagihan();
        return view('account/index', $data);
    }

    protected function getNotifikasiTagihan()
    {
        $db = \Config\Database::connect();
        return $db->table('notifikasi_tagihan')
                ->orderBy('waktu', 'DESC')
                ->limit(5)
                ->get()
                ->getResult();
    }

    public function setting()
    {
        return view('account/setting');
    }

    public function checkOldPassword()
    {
        $userModel = new \App\Models\UserModel();
        $userId = session()->get('user_id');
        $user = $userModel->find($userId);

        $oldPassword = $this->request->getPost('current_password');

        if (password_verify($oldPassword, $user['password'])) {
            return redirect()->back()->with('success_password', 'Password lama benar.');
        } else {
            return redirect()->back()->with('error_password', 'Password lama salah!');
        }
    }


    public function updateUsername()
    {
        $userModel = new \App\Models\UserModel();
        $userId = session()->get('user_id');
        $newUsername = $this->request->getPost('username');

        $userModel->update($userId, ['username' => $newUsername]);

        // Update session username
        session()->set('username', $newUsername);

        return redirect()->back()->with('success_username', 'Username berhasil diperbarui!');
    }


    public function updateEmail()
    {
        $userModel = new UserModel();
        $newEmail = $this->request->getPost('email');
        $userId = session()->get('user_id');

        $userModel->update($userId, ['email' => $newEmail]);

        return redirect()->back()->with('success_email', 'Email berhasil diperbarui!');
    }

    public function updatePassword()
    {
        $userModel = new \App\Models\UserModel();
        $userId = session()->get('user_id');
        
        // Ambil input dari form
        $currentPassword = $this->request->getPost('current_password');
        $newPassword     = $this->request->getPost('new_password');
        $confirmPassword = $this->request->getPost('confirm_password');

        // Ambil data user dari database
        $user = $userModel->find($userId);

        // Validasi password lama cocok
        if (!password_verify($currentPassword, $user['password'])) {
            return redirect()->back()->with('error', 'Password lama tidak sesuai!');
        }

        // Validasi password baru dan konfirmasi harus sama
        if ($newPassword !== $confirmPassword) {
            return redirect()->back()->with('error', 'Konfirmasi password baru tidak cocok!');
        }

        // Simpan password baru yang di-hash
        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
        $userModel->update($userId, ['password' => $hashedPassword]);

        return redirect()->back()->with('success', 'Password berhasil diperbarui!');
    }

}
