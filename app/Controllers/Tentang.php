<?php

namespace App\Controllers;

class Tentang extends BaseController
{
    public function index()
    {
        $data = [
            'title'       => 'Tentang Aplikasi SportRent - UTS Pemrograman Web',
            'appName'     => 'SportRent',
            'appDesc'     => 'Sistem Informasi Pemesanan Lapangan Futsal Berbasis Web Modern, Responsif, dan Terintegrasi Database.',
            'creatorName' => 'Iqbal Galih Santoso',
            'npm'         => '24311147',
            'kelas'       => 'SI24B',
            'prodi'       => 'Sistem Informasi',
            'kampus'      => 'Universitas Teknokrat Indonesia',
            'tahun'       => '2026',
        ];

        return view('tentang', $data);
    }
}
