<?php

namespace App\Models;

use CodeIgniter\Model;

class BookingModel extends Model
{
    protected $table            = 'bookings';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'kode_booking',
        'user_id',
        'lapangan_id',
        'tanggal_booking',
        'jam_mulai',
        'durasi',
        'total_harga',
        'status',
        'catatan',
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    // Validation
    protected $validationRules = [
        'kode_booking'    => 'required|is_unique[bookings.kode_booking,id,{id}]',
        'user_id'         => 'required|numeric',
        'lapangan_id'     => 'required|numeric',
        'tanggal_booking' => 'required|valid_date[Y-m-d]',
        'jam_mulai'       => 'required',
        'durasi'          => 'required|numeric|greater_than[0]',
        'total_harga'     => 'required|numeric|greater_than[0]',
        'status'          => 'required|in_list[Pending,Dikonfirmasi,Selesai,Dibatalkan]',
    ];

    /**
     * Generate unique booking code: BK-YYYYMM-XXXX
     */
    public function generateKodeBooking()
    {
        $prefix = 'BK-' . date('Ym') . '-';
        $lastBooking = $this->like('kode_booking', $prefix, 'after')
                            ->orderBy('id', 'DESC')
                            ->first();

        if ($lastBooking) {
            $lastCode = $lastBooking['kode_booking'];
            $number = (int) substr($lastCode, -4);
            $newNumber = str_pad($number + 1, 4, '0', STR_PAD_LEFT);
        } else {
            $newNumber = '0001';
        }

        return $prefix . $newNumber;
    }

    /**
     * Get bookings with user, field, and payment info
     */
    public function getBookingsFull($filters = [])
    {
        $builder = $this->select('bookings.*, users.nama as nama_pelanggan, users.email as email_pelanggan, users.no_hp as no_hp_pelanggan, lapangan.nama_lapangan, lapangan.jenis_lantai, lapangan.harga_per_jam, payments.id as payment_id, payments.metode_pembayaran, payments.status_pembayaran, payments.bukti_transfer')
                        ->join('users', 'users.id = bookings.user_id')
                        ->join('lapangan', 'lapangan.id = bookings.lapangan_id')
                        ->join('payments', 'payments.booking_id = bookings.id', 'left');

        if (!empty($filters['user_id'])) {
            $builder->where('bookings.user_id', $filters['user_id']);
        }

        if (!empty($filters['status'])) {
            $builder->where('bookings.status', $filters['status']);
        }

        if (!empty($filters['tanggal'])) {
            $builder->where('bookings.tanggal_booking', $filters['tanggal']);
        }

        if (!empty($filters['search'])) {
            $search = $filters['search'];
            $builder->groupStart()
                    ->like('bookings.kode_booking', $search)
                    ->orLike('users.nama', $search)
                    ->orLike('lapangan.nama_lapangan', $search)
                    ->groupEnd();
        }

        return $builder->orderBy('bookings.tanggal_booking', 'DESC')
                       ->orderBy('bookings.jam_mulai', 'DESC')
                       ->findAll();
    }

    /**
     * Get single booking with all relations
     */
    public function getBookingDetail($id)
    {
        return $this->select('bookings.*, users.nama as nama_pelanggan, users.email as email_pelanggan, users.no_hp as no_hp_pelanggan, lapangan.nama_lapangan, lapangan.jenis_lantai, lapangan.harga_per_jam, payments.id as payment_id, payments.metode_pembayaran, payments.status_pembayaran, payments.jumlah_pembayaran, payments.bukti_transfer, payments.tanggal_pembayaran')
                    ->join('users', 'users.id = bookings.user_id')
                    ->join('lapangan', 'lapangan.id = bookings.lapangan_id')
                    ->join('payments', 'payments.booking_id = bookings.id', 'left')
                    ->where('bookings.id', $id)
                    ->first();
    }

    /**
     * Check if schedule overlaps with existing active bookings
     * An overlap occurs when:
     * Existing Start < Requested End AND Existing End > Requested Start
     * Status Dibatalkan is excluded.
     */
    public function isScheduleOverlap($lapangan_id, $tanggal, $jam_mulai, $durasi, $exclude_booking_id = null)
    {
        $startSeconds = strtotime("1970-01-01 $jam_mulai");
        $endSeconds = $startSeconds + ($durasi * 3600);
        $jam_selesai = date('H:i:s', $endSeconds);

        $builder = $this->where('lapangan_id', $lapangan_id)
                        ->where('tanggal_booking', $tanggal)
                        ->whereNotIn('status', ['Dibatalkan']);

        if ($exclude_booking_id) {
            $builder->where('id !=', $exclude_booking_id);
        }

        // Add calculated column: ADDTIME(jam_mulai, SEC_TO_TIME(durasi * 3600))
        $builder->where("jam_mulai <", $jam_selesai)
                ->where("ADDTIME(jam_mulai, SEC_TO_TIME(durasi * 3600)) >", $jam_mulai);

        $conflict = $builder->first();
        return $conflict ? true : false;
    }
}
