<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // 1. Seed Users (Admin & Customer Contoh)
        $users = [
            [
                'id'         => 1,
                'nama'       => 'Administrator SportRent',
                'email'      => 'admin@sportrent.test',
                'password'   => password_hash('Admin123!', PASSWORD_BCRYPT),
                'no_hp'      => '081234567890',
                'role'       => 'admin',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'id'         => 2,
                'nama'       => 'Budi Santoso',
                'email'      => 'customer@sportrent.test',
                'password'   => password_hash('Customer123!', PASSWORD_BCRYPT),
                'no_hp'      => '082198765432',
                'role'       => 'customer',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'id'         => 3,
                'nama'       => 'Iqbal Galih Santoso',
                'email'      => 'iqbal@sportrent.test',
                'password'   => password_hash('Iqbal123!', PASSWORD_BCRYPT),
                'no_hp'      => '089876543210',
                'role'       => 'customer',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
        ];

        $this->db->table('users')->ignore(true)->insertBatch($users);

        // 2. Seed Lapangan (Minimal 3 lapangan sesuai ketentuan)
        $lapangan = [
            [
                'id'            => 1,
                'nama_lapangan' => 'Lapangan A - Sintetis Pro',
                'jenis_lantai'  => 'Rumput Sintetis',
                'harga_per_jam' => 100000,
                'deskripsi'     => 'Lapangan rumput sintetis standar FIFA monofilament dengan pencahayaan LED terang dan jaring pengaman lengkap.',
                'status'        => 'Tersedia',
                'gambar'        => 'lapangan-sintetis.jpg',
                'created_at'    => date('Y-m-d H:i:s'),
                'updated_at'    => date('Y-m-d H:i:s'),
            ],
            [
                'id'            => 2,
                'nama_lapangan' => 'Lapangan B - Vinyl Tournament',
                'jenis_lantai'  => 'Vinyl',
                'harga_per_jam' => 120000,
                'deskripsi'     => 'Lantai vinyl shock absorption berkualitas tinggi untuk kelincahan dan kenyamanan pergerakan kaki pemain.',
                'status'        => 'Tersedia',
                'gambar'        => 'lapangan-vinyl.jpg',
                'created_at'    => date('Y-m-d H:i:s'),
                'updated_at'    => date('Y-m-d H:i:s'),
            ],
            [
                'id'            => 3,
                'nama_lapangan' => 'Lapangan C - Interlock Premier',
                'jenis_lantai'  => 'Interlock',
                'harga_per_jam' => 150000,
                'deskripsi'     => 'Lapangan modular interlock berstandar kejuaraan nasional dengan grip maksimal dan sirkulasi udara sejuk.',
                'status'        => 'Tersedia',
                'gambar'        => 'lapangan-interlock.jpg',
                'created_at'    => date('Y-m-d H:i:s'),
                'updated_at'    => date('Y-m-d H:i:s'),
            ],
        ];

        $this->db->table('lapangan')->ignore(true)->insertBatch($lapangan);

        // 3. Seed Sample Bookings
        $today = date('Y-m-d');
        $tomorrow = date('Y-m-d', strtotime('+1 day'));

        $bookings = [
            [
                'id'              => 1,
                'kode_booking'    => 'BK-202611-0001',
                'user_id'         => 2,
                'lapangan_id'     => 1,
                'tanggal_booking' => $today,
                'jam_mulai'       => '16:00:00',
                'durasi'          => 2,
                'total_harga'     => 200000,
                'status'          => 'Dikonfirmasi',
                'catatan'         => 'Latihan tim rutin',
                'created_at'      => date('Y-m-d H:i:s'),
                'updated_at'      => date('Y-m-d H:i:s'),
            ],
            [
                'id'              => 2,
                'kode_booking'    => 'BK-202611-0002',
                'user_id'         => 3,
                'lapangan_id'     => 2,
                'tanggal_booking' => $tomorrow,
                'jam_mulai'       => '19:00:00',
                'durasi'          => 1,
                'total_harga'     => 120000,
                'status'          => 'Pending',
                'catatan'         => 'Fun match mingguan',
                'created_at'      => date('Y-m-d H:i:s'),
                'updated_at'      => date('Y-m-d H:i:s'),
            ],
        ];

        $this->db->table('bookings')->ignore(true)->insertBatch($bookings);

        // 4. Seed Payments
        $payments = [
            [
                'id'                 => 1,
                'booking_id'         => 1,
                'metode_pembayaran'  => 'Transfer Bank BCA',
                'jumlah_pembayaran'  => 200000,
                'status_pembayaran'  => 'Dibayar',
                'bukti_transfer'     => 'sample-transfer.jpg',
                'tanggal_pembayaran' => date('Y-m-d H:i:s'),
                'created_at'         => date('Y-m-d H:i:s'),
                'updated_at'         => date('Y-m-d H:i:s'),
            ],
            [
                'id'                 => 2,
                'booking_id'         => 2,
                'metode_pembayaran'  => 'QRIS',
                'jumlah_pembayaran'  => 120000,
                'status_pembayaran'  => 'Menunggu Verifikasi',
                'bukti_transfer'     => 'sample-qris.jpg',
                'tanggal_pembayaran' => date('Y-m-d H:i:s'),
                'created_at'         => date('Y-m-d H:i:s'),
                'updated_at'         => date('Y-m-d H:i:s'),
            ],
        ];

        $this->db->table('payments')->ignore(true)->insertBatch($payments);
    }
}
