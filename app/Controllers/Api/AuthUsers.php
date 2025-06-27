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
        $json = $this->request->getJSON();
        $model = new PhoneUser();

        $data = [
            'username' => $json->username,
            'email'    => $json->email,
            'password' => password_hash($json->password, PASSWORD_DEFAULT)
        ];

        $model->insert($data);

        return $this->respond(['status' => true, 'message' => 'Register success'], 200);
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
