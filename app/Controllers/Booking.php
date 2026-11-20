<?php

namespace App\Controllers;

use App\Models\BookingModel;
use App\Models\LapanganModel;
use App\Models\UserModel;
use App\Models\PaymentModel;

class Booking extends BaseController
{
    protected $bookingModel;
    protected $lapanganModel;
    protected $userModel;
    protected $paymentModel;

    public function __construct()
    {
        $this->bookingModel  = new BookingModel();
        $this->lapanganModel = new LapanganModel();
        $this->userModel     = new UserModel();
        $this->paymentModel  = new PaymentModel();
    }

    // ==========================================
    // BAGIAN ADMIN: CRUD BOOKING
    // ==========================================

    public function adminIndex()
    {
        $status  = $this->request->getGet('status');
        $tanggal = $this->request->getGet('tanggal');
        $search  = $this->request->getGet('search');

        $filters = [
            'status'  => $status,
            'tanggal' => $tanggal,
            'search'  => $search,
        ];

        $data = [
            'title'    => 'Kelola Data Booking - SportRent Admin',
            'bookings' => $this->bookingModel->getBookingsFull($filters),
            'filter'   => $filters,
        ];

        return view('admin/booking/index', $data);
    }

    public function adminTambah()
    {
        $data = [
            'title'     => 'Tambah Booking Manual - SportRent Admin',
            'lapangan'  => $this->lapanganModel->getAvailableFields(),
            'customers' => $this->userModel->where('role', 'customer')->findAll(),
        ];

        return view('admin/booking/tambah', $data);
    }

    public function adminSimpan()
    {
        $rules = [
            'user_id'         => 'required|numeric',
            'lapangan_id'     => 'required|numeric',
            'tanggal_booking' => 'required|valid_date[Y-m-d]',
            'jam_mulai'       => 'required',
            'durasi'          => 'required|numeric|greater_than[0]',
            'status'          => 'required|in_list[Pending,Dikonfirmasi,Selesai,Dibatalkan]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $lapanganId = $this->request->getPost('lapangan_id');
        $tanggal    = $this->request->getPost('tanggal_booking');
        $jamMulai   = $this->request->getPost('jam_mulai');
        $durasi     = (int) $this->request->getPost('durasi');

        // Validasi tanggal tidak boleh di masa lalu
        if (strtotime($tanggal) < strtotime(date('Y-m-d'))) {
            return redirect()->back()->withInput()->with('error', 'Tanggal booking tidak boleh di masa lalu.');
        }

        // Cek overlap jadwal
        if ($this->bookingModel->isScheduleOverlap($lapanganId, $tanggal, $jamMulai, $durasi)) {
            return redirect()->back()->withInput()->with('error', 'Jadwal bentrok! Lapangan sudah dipesan pada rentang jam tersebut. Silakan pilih jam atau lapangan lain.');
        }

        // Hitung total harga otomatis di backend
        $lapangan = $this->lapanganModel->find($lapanganId);
        if (!$lapangan) {
            return redirect()->back()->withInput()->with('error', 'Lapangan tidak valid.');
        }

        $totalHarga = $lapangan['harga_per_jam'] * $durasi;
        $kodeBooking = $this->bookingModel->generateKodeBooking();

        $bookingData = [
            'kode_booking'    => $kodeBooking,
            'user_id'         => $this->request->getPost('user_id'),
            'lapangan_id'     => $lapanganId,
            'tanggal_booking' => $tanggal,
            'jam_mulai'       => $jamMulai,
            'durasi'          => $durasi,
            'total_harga'     => $totalHarga,
            'status'          => $this->request->getPost('status'),
            'catatan'         => $this->request->getPost('catatan'),
        ];

        $bookingId = $this->bookingModel->insert($bookingData);

        // Buat record payment awal
        $this->paymentModel->insert([
            'booking_id'        => $bookingId,
            'metode_pembayaran' => 'Cash / Bayar di Kasir',
            'jumlah_pembayaran' => $totalHarga,
            'status_pembayaran' => ($this->request->getPost('status') === 'Dikonfirmasi') ? 'Dibayar' : 'Menunggu Verifikasi',
            'tanggal_pembayaran'=> date('Y-m-d H:i:s'),
        ]);

        return redirect()->to('/admin/booking')->with('success', 'Data booking baru berhasil ditambahkan dengan kode: ' . $kodeBooking);
    }

    public function adminEdit($id)
    {
        $booking = $this->bookingModel->getBookingDetail($id);
        if (!$booking) {
            return redirect()->to('/admin/booking')->with('error', 'Data booking tidak ditemukan.');
        }

        $data = [
            'title'     => 'Edit Data Booking - SportRent Admin',
            'booking'   => $booking,
            'lapangan'  => $this->lapanganModel->findAll(),
            'customers' => $this->userModel->where('role', 'customer')->findAll(),
        ];

        return view('admin/booking/edit', $data);
    }

    public function adminUpdate($id)
    {
        $booking = $this->bookingModel->find($id);
        if (!$booking) {
            return redirect()->to('/admin/booking')->with('error', 'Data booking tidak ditemukan.');
        }

        $rules = [
            'user_id'         => 'required|numeric',
            'lapangan_id'     => 'required|numeric',
            'tanggal_booking' => 'required|valid_date[Y-m-d]',
            'jam_mulai'       => 'required',
            'durasi'          => 'required|numeric|greater_than[0]',
            'status'          => 'required|in_list[Pending,Dikonfirmasi,Selesai,Dibatalkan]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $lapanganId = $this->request->getPost('lapangan_id');
        $tanggal    = $this->request->getPost('tanggal_booking');
        $jamMulai   = $this->request->getPost('jam_mulai');
        $durasi     = (int) $this->request->getPost('durasi');
        $status     = $this->request->getPost('status');

        // Jika status bukan Dibatalkan, periksa bentrok jadwal (kecualikan booking id sendiri)
        if ($status !== 'Dibatalkan' && $this->bookingModel->isScheduleOverlap($lapanganId, $tanggal, $jamMulai, $durasi, $id)) {
            return redirect()->back()->withInput()->with('error', 'Perubahan jam bentrok dengan jadwal booking lain!');
        }

        $lapangan = $this->lapanganModel->find($lapanganId);
        $totalHarga = $lapangan['harga_per_jam'] * $durasi;

        $this->bookingModel->update($id, [
            'user_id'         => $this->request->getPost('user_id'),
            'lapangan_id'     => $lapanganId,
            'tanggal_booking' => $tanggal,
            'jam_mulai'       => $jamMulai,
            'durasi'          => $durasi,
            'total_harga'     => $totalHarga,
            'status'          => $status,
            'catatan'         => $this->request->getPost('catatan'),
        ]);

        // Perbarui jumlah pembayaran di tabel payments jika ada
        $payment = $this->paymentModel->where('booking_id', $id)->first();
        if ($payment) {
            $this->paymentModel->update($payment['id'], [
                'jumlah_pembayaran' => $totalHarga,
                'status_pembayaran' => ($status === 'Dikonfirmasi' || $status === 'Selesai') ? 'Dibayar' : $payment['status_pembayaran'],
            ]);
        }

        return redirect()->to('/admin/booking')->with('success', 'Data booking berhasil diperbarui.');
    }

    public function adminHapus($id)
    {
        $booking = $this->bookingModel->find($id);
        if (!$booking) {
            return redirect()->to('/admin/booking')->with('error', 'Data booking tidak ditemukan.');
        }

        // Hapus pembayaran terkait lalu booking (Cascade)
        $this->paymentModel->where('booking_id', $id)->delete();
        $this->bookingModel->delete($id);

        return redirect()->to('/admin/booking')->with('success', 'Data booking berhasil dihapus.');
    }

    public function adminBatalkan($id)
    {
        $booking = $this->bookingModel->find($id);
        if (!$booking) {
            return redirect()->to('/admin/booking')->with('error', 'Data booking tidak ditemukan.');
        }

        $this->bookingModel->update($id, ['status' => 'Dibatalkan']);

        $payment = $this->paymentModel->where('booking_id', $id)->first();
        if ($payment) {
            $this->paymentModel->update($payment['id'], ['status_pembayaran' => 'Ditolak']);
        }

        return redirect()->back()->with('success', 'Booking ' . esc($booking['kode_booking']) . ' berhasil dibatalkan oleh admin.');
    }

    public function adminDetail($id)
    {
        $booking = $this->bookingModel->getBookingDetail($id);
        if (!$booking) {
            return redirect()->to('/admin/booking')->with('error', 'Data booking tidak ditemukan.');
        }

        return view('admin/booking/detail', [
            'title'   => 'Detail Booking ' . $booking['kode_booking'],
            'booking' => $booking,
        ]);
    }

    // ==========================================
    // BAGIAN CUSTOMER: FORM BOOKING & RIWAYAT
    // ==========================================

    public function customerForm()
    {
        $lapanganId = $this->request->getGet('lapangan_id');

        $data = [
            'title'               => 'Pesan Lapangan Futsal - SportRent',
            'lapangan'            => $this->lapanganModel->getAvailableFields(),
            'selected_lapangan_id'=> $lapanganId,
        ];

        return view('customer/booking/form', $data);
    }

    public function customerSimpan()
    {
        $rules = [
            'lapangan_id'     => 'required|numeric',
            'tanggal_booking' => 'required|valid_date[Y-m-d]',
            'jam_mulai'       => 'required',
            'durasi'          => 'required|numeric|greater_than[0]|less_than_equal_to[8]',
            'metode_pembayaran'=> 'required',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $userId      = session()->get('user_id');
        $lapanganId  = $this->request->getPost('lapangan_id');
        $tanggal     = $this->request->getPost('tanggal_booking');
        $jamMulai    = $this->request->getPost('jam_mulai');
        $durasi      = (int) $this->request->getPost('durasi');
        $metodeBayar = $this->request->getPost('metode_pembayaran');

        // Validasi tanggal tidak boleh di masa lalu
        if (strtotime($tanggal) < strtotime(date('Y-m-d'))) {
            return redirect()->back()->withInput()->with('error', 'Tanggal booking tidak boleh di masa lalu.');
        }

        // Validasi overlap jadwal
        if ($this->bookingModel->isScheduleOverlap($lapanganId, $tanggal, $jamMulai, $durasi)) {
            return redirect()->back()->withInput()->with('error', 'Jadwal yang Anda pilih bentrok dengan pesanan lain! Mohon pilih jam atau lapangan lain.');
        }

        $lapangan = $this->lapanganModel->find($lapanganId);
        if (!$lapangan || $lapangan['status'] !== 'Tersedia') {
            return redirect()->back()->withInput()->with('error', 'Lapangan yang dipilih sedang tidak tersedia.');
        }

        // Kalkulasi ulang total harga di backend
        $totalHarga = $lapangan['harga_per_jam'] * $durasi;
        $kodeBooking = $this->bookingModel->generateKodeBooking();

        // Database Transaction
        $db = \Config\Database::connect();
        $db->transStart();

        $bookingData = [
            'kode_booking'    => $kodeBooking,
            'user_id'         => $userId,
            'lapangan_id'     => $lapanganId,
            'tanggal_booking' => $tanggal,
            'jam_mulai'       => $jamMulai,
            'durasi'          => $durasi,
            'total_harga'     => $totalHarga,
            'status'          => 'Pending',
            'catatan'         => $this->request->getPost('catatan'),
        ];
        $this->bookingModel->insert($bookingData);
        $bookingId = $this->bookingModel->getInsertID();

        // Upload bukti pembayaran jika diunggah
        $buktiFile = $this->request->getFile('bukti_transfer');
        $namaBukti = null;
        if ($buktiFile && $buktiFile->isValid() && !$buktiFile->hasMoved()) {
            $namaBukti = $buktiFile->getRandomName();
            $buktiFile->move(FCPATH . 'assets/images/bukti', $namaBukti);
        }

        $this->paymentModel->insert([
            'booking_id'        => $bookingId,
            'metode_pembayaran' => $metodeBayar,
            'jumlah_pembayaran' => $totalHarga,
            'status_pembayaran' => 'Menunggu Verifikasi',
            'bukti_transfer'    => $namaBukti,
            'tanggal_pembayaran'=> date('Y-m-d H:i:s'),
        ]);

        $db->transComplete();

        if ($db->transStatus() === false) {
            return redirect()->back()->withInput()->with('error', 'Terjadi kesalahan sistem saat menyimpan pemesanan.');
        }

        return redirect()->to('/customer/riwayat/detail/' . $bookingId)->with('success', 'Booking berhasil dibuat! Kode Booking Anda: ' . $kodeBooking . '. Silakan selesaikan pembayaran.');
    }

    public function customerRiwayat()
    {
        $userId = session()->get('user_id');

        $data = [
            'title'    => 'Riwayat Pemesanan Saya - SportRent',
            'bookings' => $this->bookingModel->getBookingsFull(['user_id' => $userId]),
        ];

        return view('customer/riwayat/index', $data);
    }

    public function customerDetail($id)
    {
        $userId  = session()->get('user_id');
        $booking = $this->bookingModel->getBookingDetail($id);

        if (!$booking || $booking['user_id'] != $userId) {
            return redirect()->to('/customer/riwayat')->with('error', 'Data booking tidak ditemukan atau bukan milik Anda.');
        }

        return view('customer/riwayat/detail', [
            'title'   => 'Detail Booking ' . $booking['kode_booking'],
            'booking' => $booking,
        ]);
    }

    public function customerBatalkan($id)
    {
        $userId  = session()->get('user_id');
        $booking = $this->bookingModel->find($id);

        if (!$booking || $booking['user_id'] != $userId) {
            return redirect()->to('/customer/riwayat')->with('error', 'Booking tidak valid.');
        }

        if (in_array($booking['status'], ['Selesai', 'Dibatalkan'])) {
            return redirect()->to('/customer/riwayat/detail/' . $id)->with('error', 'Booking dengan status "' . esc($booking['status']) . '" tidak dapat dibatalkan.');
        }

        $this->bookingModel->update($id, ['status' => 'Dibatalkan']);

        $payment = $this->paymentModel->where('booking_id', $id)->first();
        if ($payment) {
            $this->paymentModel->update($payment['id'], ['status_pembayaran' => 'Ditolak']);
        }

        return redirect()->back()->with('success', 'Pemesanan jadwal booking berhasil dibatalkan.');
    }
}
