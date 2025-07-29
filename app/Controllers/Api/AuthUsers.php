<?php

namespace App\Controllers\Api;

use CodeIgniter\RESTful\ResourceController;
use App\Models\PhoneUser;

class AuthUsers extends ResourceController
{
    protected $format = 'json';

    public function registerPhone()
    {
        $json = $this->request->getJSON();
        $model = new PhoneUser();

        // Validasi jika data tidak lengkap
        if (!isset($json->username) || !isset($json->email) || !isset($json->password)) {
            return $this->respond([
                'status' => false,
                'message' => 'Field tidak boleh kosong.'
            ], 400);
        }

        $existingUser = $model->where('email', $json->email)->first();
        if ($existingUser) {
            return $this->respond([
                'status' => false,
                'message' => 'Email sudah terdaftar.'
            ], 409);
        }

        $data = [
            'username' => $json->username,
            'email'    => $json->email,
            'password' => password_hash($json->password, PASSWORD_DEFAULT)
        ];

        if ($model->insert($data)) {
            return $this->respond([
                'status' => true,
                'message' => 'Registrasi berhasil.'
            ], 200);
        } else {
            return $this->respond([
                'status' => false,
                'message' => 'Registrasi gagal menyimpan data.'
            ], 500);
        }
    }

    public function loginPhone()
    {
        $model = new PhoneUser();
        $data = $this->request->getJSON(true);
        $user = $model->where('email', $data['email'])->first();

        if (!$user || !password_verify($data['password'], $user['password'])) {
            return $this->respond(['status' => false, 'message' => 'Email atau password salah.'], 401);
        }

        $model->update($user['id'], [
            'is_online'    => 1,
            'last_online'  => date('Y-m-d H:i:s')
        ]);

        return $this->respond([
            'status' => true,
            'message' => 'Login berhasil.',
            'user' => $user
        ]);
    }

    public function list()
    {
        $model = new PhoneUser();
        return $this->respond($model->findAll());
    }

    public function logoutPhone($id)
    {
        $model = new PhoneUser();
        $model->update($id, ['is_online' => 0]);
        return $this->respond(['status' => true, 'message' => 'Logout berhasil.']);
    }
}
