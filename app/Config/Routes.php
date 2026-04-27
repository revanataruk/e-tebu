<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Auth::index');
$routes->get('/auth', 'Auth::index');
$routes->post('/auth/proses_login', 'Auth::proses_login');
$routes->get('/logout', 'Auth::logout');
$routes->get('/dashboard', 'Dashboard::index');
$routes->get('/musimtanam', 'MusimTanam::index');
$routes->post('/musimtanam/simpan', 'MusimTanam::simpan');
$routes->get('/musimtanam/set_aktif/(:num)', 'MusimTanam::set_aktif/$1');
$routes->get('/transaksi', 'Transaksi::index');
$routes->post('/transaksi/simpan', 'Transaksi::simpan');
$routes->get('/laporan', 'Laporan::index');
$routes->get('/transaksi/ekspor', 'Transaksi::ekspor_pdf');