<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
//Route Api
$routes->post('AuthUsers/register', 'Api\AuthUsers::registerPhone');
$routes->post('AuthUsers/login', 'Api\AuthUsers::loginPhone');
//Route Login, Register, Dashboard
$routes->get('/', 'Auth::login');
$routes->get('/login', 'Auth::login');
$routes->post('/login', 'Auth::loginProcess');
$routes->get('/register', 'Auth::register');
$routes->post('/register', 'Auth::registerProcess');
$routes->get('/logout', 'Auth::logout');
$routes->group('', ['filter' => 'auth'], function($routes) {
    $routes->get('/auth/dashboard', 'Auth::dashboard');
    $routes->get('/tagihan', 'Tagihan::index');
});
//Account Seting
$routes->post('/account/update-username', 'Account::updateUsername', ['filter' => 'auth']);
$routes->get('/account/setting', 'Account::setting', ['filter' => 'auth']);
$routes->post('/account/update-email', 'Account::updateEmail', ['filter' => 'auth']);
$routes->post('/account/check-old-password', 'Account::checkOldPassword', ['filter' => 'auth']);
$routes->post('/account/update-password', 'Account::updatePassword', ['filter' => 'auth']);
//Route CRUD Tagihan Air
$routes->get('/tagihan/create', 'Tagihan::create');
$routes->post('/tagihan/store', 'Tagihan::store');
$routes->get('/tagihan/edit/(:num)', 'Tagihan::edit/$1');
$routes->post('/tagihan/update/(:num)', 'Tagihan::update/$1');
$routes->get('tagihan/delete/(:num)', 'Tagihan::delete/$1');
//Route Filter Data Tagihan lunas dan Belum Lunas
$routes->get('/tagihan/lunas', 'Tagihan::lunas');
$routes->get('/tagihan/belum-lunas', 'Tagihan::belumLunas');
//route riwayat tagihan
$routes->get('/tagihan/simpan-semua', 'Tagihan::simpanSemua');
$routes->get('/riwayat-tagihan', 'Tagihan::riwayat');
$routes->get('riwayat', 'Riwayat::index');
$routes->post('riwayat/kembalikan', 'Riwayat::kembalikan');
$routes->post('riwayat/hapus', 'Riwayat::hapus');
$routes->get('riwayat/filter', 'Riwayat::filter');
//export data
$routes->get('riwayat/export/(:any)', 'Riwayat::export/$1');
//send data ke aplikasi
$routes->get('tagihan/kirim_tagihan/(:num)', 'Tagihan::kirim_tagihan/$1');
$routes->get('tagihan/kirim_tagihan/(:num)', 'Tagihan::kirim_tagihan/$1');
$routes->get('TagihanApi/summary', 'TagihanApi::getSummary');
