<?php

namespace App\Controllers;

use App\Models\BookingModel;

class Laporan extends BaseController
{
    protected $bookingModel;

    public function __construct()
    {
        $this->bookingModel = new BookingModel();
    }

    public function index()
    {
        $startDate = $this->request->getGet('start_date') ?? date('Y-m-01');
        $endDate   = $this->request->getGet('end_date') ?? date('Y-m-t');

        $db = \Config\Database::connect();
        $builder = $db->table('bookings')
                      ->select('bookings.*, users.nama as nama_pelanggan, lapangan.nama_lapangan, payments.status_pembayaran, payments.metode_pembayaran')
                      ->join('users', 'users.id = bookings.user_id')
                      ->join('lapangan', 'lapangan.id = bookings.lapangan_id')
                      ->join('payments', 'payments.booking_id = bookings.id', 'left')
                      ->where('bookings.tanggal_booking >=', $startDate)
                      ->where('bookings.tanggal_booking <=', $endDate)
                      ->orderBy('bookings.tanggal_booking', 'ASC');

        $reports = $builder->get()->getResultArray();

        $totalOmset = 0;
        foreach ($reports as $r) {
            if ($r['status_pembayaran'] === 'Dibayar') {
                $totalOmset += $r['total_harga'];
            }
        }

        $data = [
            'title'      => 'Laporan Transaksi & Pendapatan - SportRent Admin',
            'reports'    => $reports,
            'startDate'  => $startDate,
            'endDate'    => $endDate,
            'totalOmset' => $totalOmset,
        ];

        return view('admin/laporan/index', $data);
    }
}
