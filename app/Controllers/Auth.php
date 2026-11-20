<?php

namespace App\Controllers;

use App\Models\UserModel;

class Auth extends BaseController
{
    protected $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    public function login()
    {
        if (session()->get('logged_in')) {
            return session()->get('role') === 'admin' 
                ? redirect()->to('/admin/dashboard') 
                : redirect()->to('/customer/dashboard');
        }

        return view('auth/login', [
            'title' => 'Masuk - SportRent'
        ]);
    }

    public function prosesLogin()
    {
        $rules = [
            'email'    => 'required|valid_email',
            'password' => 'required',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $email    = $this->request->getPost('email');
        $password = $this->request->getPost('password');

        $user = $this->userModel->where('email', $email)->first();

        if ($user) {
            if (password_verify($password, $user['password'])) {
                // Set Session
                $sessionData = [
                    'user_id'   => $user['id'],
                    'nama'      => $user['nama'],
                    'email'     => $user['email'],
                    'role'      => $user['role'],
                    'no_hp'     => $user['no_hp'],
                    'logged_in' => true,
                ];
                session()->set($sessionData);
                session()->setFlashdata('success', 'Selamat datang kembali, ' . esc($user['nama']) . '!');

                if ($user['role'] === 'admin') {
                    return redirect()->to('/admin/dashboard');
                } else {
                    return redirect()->to('/customer/dashboard');
                }
            } else {
                return redirect()->back()->withInput()->with('error', 'Password yang Anda masukkan salah.');
            }
        } else {
            return redirect()->back()->withInput()->with('error', 'Akun dengan email tersebut tidak ditemukan.');
        }
    }

    public function register()
    {
        if (session()->get('logged_in')) {
            return redirect()->to('/customer/dashboard');
        }

        return view('auth/register', [
            'title' => 'Daftar Akun Baru - SportRent'
        ]);
    }

    public function prosesRegister()
    {
        $rules = [
            'nama'             => 'required|min_length[3]|max_length[150]',
            'email'            => 'required|valid_email|is_unique[users.email]',
            'no_hp'            => 'required|min_length[8]|max_length[20]',
            'password'         => 'required|min_length[6]',
            'password_confirm' => 'required|matches[password]',
        ];

        $messages = [
            'nama' => [
                'required'   => 'Nama lengkap wajib diisi.',
                'min_length' => 'Nama lengkap minimal 3 karakter.',
            ],
            'email' => [
                'required'    => 'Email wajib diisi.',
                'valid_email' => 'Format email tidak valid.',
                'is_unique'   => 'Email ini sudah terdaftar. Silakan gunakan email lain atau login.',
            ],
            'no_hp' => [
                'required'   => 'Nomor HP wajib diisi untuk konfirmasi booking.',
                'min_length' => 'Nomor HP minimal 8 digit.',
            ],
            'password' => [
                'required'   => 'Password wajib diisi.',
                'min_length' => 'Password minimal 6 karakter.',
            ],
            'password_confirm' => [
                'required' => 'Konfirmasi password wajib diisi.',
                'matches'  => 'Konfirmasi password tidak cocok dengan password.',
            ],
        ];

        if (!$this->validate($rules, $messages)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // Simpan data customer (Role dipastikan selalu customer untuk keamanan)
        $this->userModel->save([
            'nama'     => $this->request->getPost('nama'),
            'email'    => $this->request->getPost('email'),
            'no_hp'    => $this->request->getPost('no_hp'),
            'password' => password_hash($this->request->getPost('password'), PASSWORD_BCRYPT),
            'role'     => 'customer',
        ]);

        session()->setFlashdata('success', 'Pendaftaran akun berhasil! Silakan login menggunakan akun baru Anda.');
        return redirect()->to('/login');
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login')->with('success', 'Anda telah berhasil keluar (logout).');
    }
}
