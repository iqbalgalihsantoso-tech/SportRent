<?php

namespace App\Controllers;

use App\Models\PaymentModel;
use App\Models\BookingModel;

class Pembayaran extends BaseController
{
    protected $paymentModel;
    protected $bookingModel;

    public function __construct()
    {
        $this->paymentModel = new PaymentModel();
        $this->bookingModel = new BookingModel();
    }

    public function index()
    {
        $data = [
            'title'    => 'Kelola Data Pembayaran - SportRent Admin',
            'payments' => $this->paymentModel->getPaymentsWithBooking(),
        ];

        return view('admin/pembayaran/index', $data);
    }

    public function verifikasi($id)
    {
        $payment = $this->paymentModel->find($id);
        if (!$payment) {
            return redirect()->to('/admin/pembayaran')->with('error', 'Data pembayaran tidak ditemukan.');
        }

        $statusBaru = $this->request->getPost('status_pembayaran');

        $this->paymentModel->update($id, [
            'status_pembayaran' => $statusBaru,
            'tanggal_pembayaran'=> date('Y-m-d H:i:s'),
        ]);

        // Sinkronisasi status booking jika pembayaran disetujui atau ditolak
        if ($statusBaru === 'Dibayar') {
            $this->bookingModel->update($payment['booking_id'], ['status' => 'Dikonfirmasi']);
        } elseif ($statusBaru === 'Ditolak') {
            $this->bookingModel->update($payment['booking_id'], ['status' => 'Pending']);
        }

        return redirect()->to('/admin/pembayaran')->with('success', 'Status pembayaran berhasil diperbarui menjadi: ' . $statusBaru);
    }
}
