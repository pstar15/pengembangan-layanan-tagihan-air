<?php

namespace App\Controllers\Api;

use CodeIgniter\RESTful\ResourceController;
use App\Models\PhoneUser;

class AuthUsers extends ResourceController
{
    protected $format = 'json';

    public function index()
    {
        //
    }

    public function register()
    {
        $request = $this->request->getJSON();

        $username = $request->username;
        $email = $request->email;
        $password = password_hash($request->password, PASSWORD_BCRYPT);

        $PhoneUser = new \App\Models\PhoneUser();

        // Cek jika email sudah terdaftar
        if ($PhoneUser->where('email', $email)->first()) {
            return $this->response->setJSON([
                'status' => false,
                'message' => 'Email sudah terdaftar'
            ]);
        }

        $PhoneUser->insert([
            'username' => $username,
            'email'    => $email,
            'password' => $password
        ]);

        return $this->response->setJSON([
            'status' => true,
            'message' => 'Registrasi berhasil'
        ]);
    }

    public function login()
    {
        $model = new PhoneUser();
        $data = $this->request->getJSON(true);
        $user = $model->where('email', $data['email'])->first();

        if (!$user || !password_verify($data['password'], $user['password'])) {
            return $this->respond(['status' => false, 'message' => 'Email atau password salah.'], 401);
        }

        return $this->respond(['status' => true, 'message' => 'Login berhasil.', 'user' => $user]);
    }

    public function list()
    {
        $model = new PhoneUser();
        return $this->respond($model->findAll());
    }
}
