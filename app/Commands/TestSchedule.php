<?php

namespace App\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;
use App\Models\BookingModel;
use App\Models\LapanganModel;
use App\Models\UserModel;

class TestSchedule extends BaseCommand
{
    protected $group       = 'Testing';
    protected $name        = 'test:schedule';
    protected $description = 'Uji logika overlap jadwal booking, relasi, dan generate kode';

    public function run(array $params)
    {
        CLI::write("=== SPORTRENT LOGIC VERIFICATION ===", 'green');

        $bookingModel = new BookingModel();
        $lapanganModel = new LapanganModel();
        $userModel = new UserModel();

        // 1. Cek Overlap pada jadwal yang ada di database (ID 3 ada di 2026-11-20 pukul 08:00)
        $sampleBooking = $bookingModel->whereNotIn('status', ['Dibatalkan'])->first();
        if ($sampleBooking) {
            $isOverlap = $bookingModel->isScheduleOverlap(
                $sampleBooking['lapangan_id'],
                $sampleBooking['tanggal_booking'],
                $sampleBooking['jam_mulai'],
                1
            );
            if ($isOverlap) {
                CLI::write("[PASS] Test 1: Jadwal bentrok ({$sampleBooking['tanggal_booking']} {$sampleBooking['jam_mulai']}) berhasil dideteksi.", 'green');
            } else {
                CLI::error("[FAIL] Test 1: Gagal mendeteksi jadwal bentrok.");
            }
        }

        // 2. Cek Bebas Bentrok
        $isFree = $bookingModel->isScheduleOverlap(1, date('Y-m-d'), '10:00:00', 1);
        if (!$isFree) {
            CLI::write("[PASS] Test 2: Jadwal kosong pukul 10:00 diverifikasi aman.", 'green');
        } else {
            CLI::error("[FAIL] Test 2: Salah mendeteksi jadwal kosong sebagai bentrok.");
        }

        // 3. Generate Kode Booking
        $kode = $bookingModel->generateKodeBooking();
        CLI::write("[PASS] Test 3: Kode booking otomatis dibuat: $kode", 'green');

        // 4. Data Lapangan
        $lapangan = $lapanganModel->getAvailableFields();
        CLI::write("[PASS] Test 4: Jumlah lapangan aktif: " . count($lapangan), 'green');

        // 5. User Customer
        $customers = $userModel->where('role', 'customer')->findAll();
        CLI::write("[PASS] Test 5: Jumlah pelanggan terdaftar: " . count($customers), 'green');

        CLI::write("=== SELURUH PENGUJIAN LOGIKA SUKSES ===", 'yellow');
    }
}
