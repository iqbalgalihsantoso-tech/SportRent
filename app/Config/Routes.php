<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// ==========================================
// 1. PUBLIC ROUTES
// ==========================================
$routes->get('/', 'Home::index');
$routes->get('/lapangan', 'Home::lapangan');
$routes->get('/lapangan/detail/(:num)', 'Home::detailLapangan/$1');
$routes->get('/tentang', 'Tentang::index');

// Autentikasi
$routes->get('/login', 'Auth::login');
$routes->post('/login', 'Auth::prosesLogin');
$routes->get('/register', 'Auth::register');
$routes->post('/register', 'Auth::prosesRegister');
$routes->get('/logout', 'Auth::logout');

// ==========================================
// 2. ADMIN ROUTES (Protected by AuthFilter with 'admin' role)
// ==========================================
$routes->group('admin', ['filter' => 'auth:admin'], static function ($routes) {
    $routes->get('dashboard', 'Dashboard::adminDashboard');

    // CRUD Lapangan (UTS Required Supported Table)
    $routes->get('lapangan', 'Lapangan::index');
    $routes->get('lapangan/tambah', 'Lapangan::tambah');
    $routes->post('lapangan/simpan', 'Lapangan::simpan');
    $routes->get('lapangan/edit/(:num)', 'Lapangan::edit/$1');
    $routes->post('lapangan/update/(:num)', 'Lapangan::update/$1');
    $routes->post('lapangan/hapus/(:num)', 'Lapangan::hapus/$1');

    // CRUD Booking (UTS Required Main Table)
    $routes->get('booking', 'Booking::adminIndex');
    $routes->get('booking/tambah', 'Booking::adminTambah');
    $routes->post('booking/simpan', 'Booking::adminSimpan');
    $routes->get('booking/detail/(:num)', 'Booking::adminDetail/$1');
    $routes->get('booking/edit/(:num)', 'Booking::adminEdit/$1');
    $routes->post('booking/update/(:num)', 'Booking::adminUpdate/$1');
    $routes->post('booking/batalkan/(:num)', 'Booking::adminBatalkan/$1');
    $routes->post('booking/hapus/(:num)', 'Booking::adminHapus/$1');

    // Pembayaran & Verifikasi
    $routes->get('pembayaran', 'Pembayaran::index');
    $routes->post('pembayaran/verifikasi/(:num)', 'Pembayaran::verifikasi/$1');

    // Pelanggan & Laporan
    $routes->get('pelanggan', 'Pelanggan::index');
    $routes->get('laporan', 'Laporan::index');
});

// ==========================================
// 3. CUSTOMER ROUTES (Protected by AuthFilter with 'customer' role)
// ==========================================
$routes->group('customer', ['filter' => 'auth:customer'], static function ($routes) {
    $routes->get('dashboard', 'Dashboard::customerDashboard');

    // Booking Flow
    $routes->get('booking', 'Booking::customerForm');
    $routes->post('booking/simpan', 'Booking::customerSimpan');

    // Riwayat & Detail
    $routes->get('riwayat', 'Booking::customerRiwayat');
    $routes->get('riwayat/detail/(:num)', 'Booking::customerDetail/$1');
    $routes->post('riwayat/batalkan/(:num)', 'Booking::customerBatalkan/$1');
});
