<?php

namespace App\Controllers;

use App\Models\LapanganModel;
use App\Models\BookingModel;
use App\Models\UserModel;

class Home extends BaseController
{
    public function index(): string
    {
        $lapanganModel = new LapanganModel();
        $bookingModel  = new BookingModel();
        $userModel     = new UserModel();

        // Data statistik dinamis dari database
        $stats = [
            'total_lapangan'  => $lapanganModel->countAllResults(),
            'total_booking'   => $bookingModel->countAllResults(),
            'total_pelanggan' => $userModel->where('role', 'customer')->countAllResults(),
        ];

        // Daftar lapangan aktif untuk ditampilkan di beranda
        $lapangan = $lapanganModel->where('status', 'Tersedia')->findAll();

        $data = [
            'title'    => 'SportRent - Futsal Court Booking Management System',
            'stats'    => $stats,
            'lapangan' => $lapangan,
        ];

        return view('home/index', $data);
    }

    public function lapangan(): string
    {
        $lapanganModel = new LapanganModel();
        $data = [
            'title'    => 'Daftar Lapangan Futsal - SportRent',
            'lapangan' => $lapanganModel->findAll(),
        ];

        return view('home/lapangan', $data);
    }

    public function detailLapangan($id): string
    {
        $lapanganModel = new LapanganModel();
        $lapangan = $lapanganModel->find($id);

        if (!$lapangan) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Lapangan tidak ditemukan');
        }

        $data = [
            'title'    => 'Detail ' . $lapangan['nama_lapangan'] . ' - SportRent',
            'lapangan' => $lapangan,
        ];

        return view('home/lapangan_detail', $data);
    }
}
