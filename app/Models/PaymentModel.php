<?php

namespace App\Models;

use CodeIgniter\Model;

class PaymentModel extends Model
{
    protected $table            = 'payments';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'booking_id',
        'metode_pembayaran',
        'jumlah_pembayaran',
        'status_pembayaran',
        'bukti_transfer',
        'tanggal_pembayaran',
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    // Validation
    protected $validationRules = [
        'booking_id'        => 'required|numeric',
        'metode_pembayaran' => 'required',
        'jumlah_pembayaran' => 'required|numeric|greater_than[0]',
        'status_pembayaran' => 'required|in_list[Belum Dibayar,Menunggu Verifikasi,Dibayar,Ditolak]',
    ];

    public function getPaymentsWithBooking()
    {
        return $this->select('payments.*, bookings.kode_booking, bookings.total_harga, bookings.tanggal_booking, bookings.jam_mulai, users.nama as nama_pelanggan, lapangan.nama_lapangan')
                    ->join('bookings', 'bookings.id = payments.booking_id')
                    ->join('users', 'users.id = bookings.user_id')
                    ->join('lapangan', 'lapangan.id = bookings.lapangan_id')
                    ->orderBy('payments.id', 'DESC')
                    ->findAll();
    }
}
