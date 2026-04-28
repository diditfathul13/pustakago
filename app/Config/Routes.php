<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// Variabel Filter
$authFilter = ['filter' => 'auth'];

// Variabel Role
$admin   = ['filter' => 'role:admin'];
$user    = ['filter' => 'role:user'];
$allRole = ['filter' => 'role:admin,user'];

// --- LOGIN & AUTH ---
$routes->get('/login', 'Auth::login');
$routes->post('login/login_aksi', 'Login::login_aksi');
$routes->post('/proses-login', 'Auth::prosesLogin');
$routes->get('/logout', 'Auth::logout');
$routes->get('login/logout', 'Auth::logout');
$routes->get('/backup', 'Backup::index');

// --- HALAMAN UTAMA ---
$routes->get('/', 'Home::index', $authFilter);
$routes->get('/dashboard', 'Home::index', $authFilter);

// --- USERS ---
$routes->get('/users', 'Users::index'); 
$routes->get('/users/create', 'Users::create');
$routes->post('users/store', 'Users::store');
$routes->get('/users/edit/(:num)', 'Users::edit/$1'); 
$routes->post('/users/update/(:num)', 'Users::update/$1', $allRole); 
$routes->get('/users/delete/(:num)', 'Users::delete/$1', $allRole); 
$routes->get('users/detail/(:num)', 'Users::detail/$1', $allRole); 
$routes->get('users/print', 'Users::print', $allRole); 
$routes->get('users/wa/(:num)', 'Users::wa/$1', $allRole); 

// --- BUKU ---
$routes->get('buku', 'Buku::index');
$routes->get('buku/katalog', 'Buku::katalog');
$routes->get('buku/create', 'Buku::create');
$routes->get('buku/print', 'Buku::print');
$routes->get('buku/delete/(:num)', 'Buku::delete/$1');
$routes->post('buku/store', 'Buku::store');
$routes->get('buku/detail/(:num)', 'Buku::detail/$1');
$routes->get('buku/edit/(:num)', 'Buku::edit/$1');
$routes->post('buku/update/(:num)', 'Buku::update/$1');

// --- PEMINJAMAN (ADMIN) ---
$routes->get('peminjaman', 'Peminjaman::index');
$routes->get('peminjaman/approve/(:num)', 'Peminjaman::approve/$1'); // BARU: Agar tombol Setujui jalan
$routes->get('peminjaman/reject/(:num)', 'Peminjaman::reject/$1');   // BARU: Agar tombol Tolak jalan
$routes->get('peminjaman/konfirmasi_kembali/(:num)', 'Peminjaman::konfirmasi_kembali/$1');
$routes->get('peminjaman/hapus/(:num)', 'Peminjaman::hapus/$1');

// --- PEMINJAMAN (USER) ---
$routes->get('peminjaman/ajukan/(:num)', 'Peminjaman::ajukan/$1');
$routes->get('peminjaman/riwayat', 'Peminjaman::riwayat');
$routes->get('peminjaman/kembalikan/(:num)', 'Peminjaman::kembalikan/$1');
// Tambahkan ini di Config/Routes.php
$routes->get('riwayat', 'Peminjaman::riwayat');
$routes->post('peminjaman/approve/(:num)', 'Peminjaman::approve/$1');
// Route untuk proses bayar denda via DANA
$routes->post('peminjaman/bayar_dana/(:num)', 'Peminjaman::bayar_dana/$1');

// Tambahkan juga route untuk verifikasi admin (supaya tidak error 404 nanti)
$routes->get('peminjaman/verifikasi_bayar/(:num)', 'Peminjaman::verifikasi_bayar/$1');
//RESTORE
$routes->get('/restore', 'Restore::index');
$routes->post('/restore/auth', 'Restore::auth');
$routes->get('/restore/form', 'Restore::form');
$routes->post('/restore/process', 'Restore::process');
// Jika kamu ingin mengarahkan ke Controller User fungsi profile
$routes->get('profile', 'Users::profile');
//Tagihdenda
$routes->post('peminjaman/tagih_denda/(:num)', 'Peminjaman::tagih_denda/$1');