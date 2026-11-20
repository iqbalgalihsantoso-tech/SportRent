<?php

namespace App\Controllers;

use App\Models\LapanganModel;
use App\Models\BookingModel;
use App\Models\UserModel;
use App\Models\PaymentModel;

class Dashboard extends BaseController
{
    public function index()
    {
        $role = session()->get('role');
        if ($role === 'admin') {
            return $this->adminDashboard();
        } else {
            return $this->customerDashboard();
        }
    }

    public function adminDashboard()
    {
        $lapanganModel = new LapanganModel();
        $bookingModel  = new BookingModel();
        $userModel     = new UserModel();
        $paymentModel  = new PaymentModel();
        $db            = \Config\Database::connect();

        // 1. Metrik Utama
        $totalLapangan    = $lapanganModel->countAllResults();
        $totalPelanggan   = $userModel->where('role', 'customer')->countAllResults();
        $totalBooking     = $bookingModel->countAllResults();
        $bookingPending   = $bookingModel->where('status', 'Pending')->countAllResults();
        $bookingConfirmed = $bookingModel->where('status', 'Dikonfirmasi')->countAllResults();
        $bookingSelesai   = $bookingModel->where('status', 'Selesai')->countAllResults();
        $bookingDibatalkan= $bookingModel->where('status', 'Dibatalkan')->countAllResults();

        // 2. Pendapatan terverifikasi (dari payments status 'Dibayar')
        $incomeRow = $db->table('payments')
                        ->selectSum('jumlah_pembayaran', 'total')
                        ->where('status_pembayaran', 'Dibayar')
                        ->get()
                        ->getRow();
        $totalPendapatan = $incomeRow ? (int)$incomeRow->total : 0;

        // Pendapatan menunggu verifikasi (potensi omset)
        $pendingIncomeRow = $db->table('payments')
                               ->selectSum('jumlah_pembayaran', 'total')
                               ->where('status_pembayaran', 'Menunggu Verifikasi')
                               ->get()
                               ->getRow();
        $pendingPendapatan = $pendingIncomeRow ? (int)$pendingIncomeRow->total : 0;

        // 3. 5 Booking Terbaru
        $recentBookings = $bookingModel->getBookingsFull();
        $recentBookings = array_slice($recentBookings, 0, 6);

        // 4. Jadwal Main Hari Ini
        $todayBookings = $bookingModel->getBookingsFull([
            'tanggal' => date('Y-m-d')
        ]);

        // 5. Pembayaran Menunggu Verifikasi
        $pendingPayments = $paymentModel->getPaymentsWithBooking();
        $pendingPayments = array_filter($pendingPayments, fn($p) => $p['status_pembayaran'] === 'Menunggu Verifikasi');
        $pendingPayments = array_slice($pendingPayments, 0, 5);

        // 6. Data Tren Booking 7 Hari Terakhir (untuk Chart.js)
        $chartLabels = [];
        $chartBookings = [];
        $chartOmset = [];

        for ($i = 6; $i >= 0; $i--) {
            $date = date('Y-m-d', strtotime("-$i days"));
            $chartLabels[] = date('d M', strtotime($date));

            $countDay = $db->table('bookings')
                           ->where('tanggal_booking', $date)
                           ->whereNotIn('status', ['Dibatalkan'])
                           ->countAllResults();
            $chartBookings[] = $countDay;

            $sumDay = $db->table('bookings')
                         ->selectSum('total_harga', 'total')
                         ->join('payments', 'payments.booking_id = bookings.id', 'left')
                         ->where('bookings.tanggal_booking', $date)
                         ->where('payments.status_pembayaran', 'Dibayar')
                         ->get()
                         ->getRow();
            $chartOmset[] = $sumDay && $sumDay->total ? (int)$sumDay->total : 0;
        }

        // 7. Status Kategori Lapangan
        $courtStats = $db->table('lapangan')
                         ->select('lapangan.id, lapangan.nama_lapangan, lapangan.jenis_lantai, lapangan.harga_per_jam, lapangan.status, COUNT(bookings.id) as total_dipakai')
                         ->join('bookings', 'bookings.lapangan_id = lapangan.id', 'left')
                         ->groupBy('lapangan.id')
                         ->orderBy('total_dipakai', 'DESC')
                         ->get()
                         ->getResultArray();

        $data = [
            'title'             => 'Dashboard Administrator - SportRent',
            'totalLapangan'     => $totalLapangan,
            'totalPelanggan'    => $totalPelanggan,
            'totalBooking'      => $totalBooking,
            'bookingPending'    => $bookingPending,
            'bookingConfirmed'  => $bookingConfirmed,
            'bookingSelesai'    => $bookingSelesai,
            'bookingDibatalkan' => $bookingDibatalkan,
            'totalPendapatan'   => $totalPendapatan,
            'pendingPendapatan' => $pendingPendapatan,
            'recentBookings'    => $recentBookings,
            'todayBookings'     => $todayBookings,
            'pendingPayments'   => $pendingPayments,
            'chartLabels'       => json_encode($chartLabels),
            'chartBookings'     => json_encode($chartBookings),
            'chartOmset'        => json_encode($chartOmset),
            'courtStats'        => $courtStats,
        ];

        return view('admin/dashboard', $data);
    }

    public function customerDashboard()
    {
        $userId        = session()->get('user_id');
        $userModel     = new UserModel();
        $bookingModel  = new BookingModel();
        $lapanganModel = new LapanganModel();

        $user = $userModel->find($userId);

        $myBookings = $bookingModel->getBookingsFull(['user_id' => $userId]);

        $myTotalBooking    = count($myBookings);
        $myPendingBooking  = count(array_filter($myBookings, fn($b) => $b['status'] === 'Pending'));
        $myActiveBooking   = count(array_filter($myBookings, fn($b) => $b['status'] === 'Dikonfirmasi'));
        $mySelesaiBooking  = count(array_filter($myBookings, fn($b) => $b['status'] === 'Selesai'));

        // Jadwal Terdekat Mendatang (Upcoming Match)
        $today = date('Y-m-d');
        $upcomingBookings = array_filter($myBookings, function($b) use ($today) {
            return ($b['tanggal_booking'] >= $today) && in_array($b['status'], ['Pending', 'Dikonfirmasi']);
        });

        // Pengeluaran Total Customer
        $totalPengeluaran = 0;
        foreach ($myBookings as $b) {
            if ($b['status_pembayaran'] === 'Dibayar') {
                $totalPengeluaran += $b['total_harga'];
            }
        }

        $availableLapangans = $lapanganModel->getAvailableFields();

        $data = [
            'title'              => 'Dashboard Member - SportRent',
            'user'               => $user,
            'myBookings'         => array_slice($myBookings, 0, 6),
            'upcomingBookings'   => array_slice($upcomingBookings, 0, 3),
            'myTotalBooking'     => $myTotalBooking,
            'myPendingBooking'   => $myPendingBooking,
            'myActiveBooking'    => $myActiveBooking,
            'mySelesaiBooking'   => $mySelesaiBooking,
            'totalPengeluaran'   => $totalPengeluaran,
            'availableLapangans' => $availableLapangans,
        ];

        return view('customer/dashboard', $data);
    }
}
