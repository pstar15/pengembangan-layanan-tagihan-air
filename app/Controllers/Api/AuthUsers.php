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
        $model = new PhoneUser();
        $data = $this->request->getJSON(true);

        if ($model->where('email', $data['email'])->first()) {
            return $this->respond(['status' => false, 'message' => 'Email sudah digunakan.'], 409);
        }

        $model->insert([
            'username' => $data['username'],
            'email'    => $data['email'],
            'password' => password_hash($data['password'], PASSWORD_DEFAULT),
        ]);

        return $this->respond(['status' => true, 'message' => 'Registrasi berhasil.']);
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
