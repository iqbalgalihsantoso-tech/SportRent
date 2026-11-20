<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class AuthFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $session = session();

        // 1. Cek apakah user sudah login
        if (!$session->get('logged_in')) {
            $session->setFlashdata('error', 'Silakan login terlebih dahulu untuk mengakses halaman ini.');
            return redirect()->to('/login');
        }

        // 2. Jika ada argumen role (misal: ['admin'] atau ['customer'])
        if (!empty($arguments)) {
            $userRole = $session->get('role');
            if (!in_array($userRole, $arguments)) {
                $session->setFlashdata('error', 'Akses ditolak. Anda tidak memiliki izin untuk membuka halaman tersebut.');
                if ($userRole === 'admin') {
                    return redirect()->to('/admin/dashboard');
                } else {
                    return redirect()->to('/customer/dashboard');
                }
            }
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Do nothing
    }
}
