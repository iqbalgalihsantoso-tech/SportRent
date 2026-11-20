<?php

namespace App\Controllers;

use App\Models\UserModel;

class Pelanggan extends BaseController
{
    protected $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    public function index()
    {
        $data = [
            'title'     => 'Data Pelanggan Terdaftar - SportRent Admin',
            'pelanggan' => $this->userModel->getCustomersWithBookingCount(),
        ];

        return view('admin/pelanggan/index', $data);
    }
}
