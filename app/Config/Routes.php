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
//Route Login Google
$routes->get('auth/googleLogin', 'Auth::googleLogin');
$routes->get('auth/googleCallback', 'Auth::googleCallback');
$routes->get('auth/registerGoogle', 'Auth::registerGoogle');
$routes->post('auth/registerGoogleProcess', 'Auth::registerGoogleProcess');
//Route Reset Password
$routes->get('/forgot', 'Auth::forgot');
$routes->post('/auth/forgotProcess', 'Auth::forgotProcess');
$routes->get('/auth/reset-password/(:any)', 'Auth::resetPassword/$1');
$routes->post('/auth/resetProcess', 'Auth::resetProcess');
//Route Dashboard
$routes->group('', ['filter' => 'auth'], function($routes) {
    $routes->get('/auth/dashboard', 'Auth::dashboard');
    $routes->get('/tagihan', 'Tagihan::index');
});
//Account Seting
$routes->get('/account/setting', 'Account::setting', ['filter' => 'auth']);
$routes->get('/account/setting_account', 'Account::settingAccount', ['filter' => 'auth']);
$routes->post('/account/update-username', 'Account::updateUsername', ['filter' => 'auth']);
$routes->post('/account/update-email', 'Account::updateEmail', ['filter' => 'auth']);
$routes->post('/account/check-old-password', 'Account::checkOldPassword', ['filter' => 'auth']);
$routes->post('/account/update-password', 'Account::updatePassword', ['filter' => 'auth']);
//Route Aktifitas Login
$routes->get('account/login-activity', 'LoginActifityController::index');
//Account Setting App
$routes->get('/account_app', 'SettingAccountApp::index');
$routes->get('/account_app/edit/(:num)', 'SettingAccountApp::edit/$1');
$routes->post('/account_app/update/(:num)', 'SettingAccountApp::update/$1');
$routes->get('/account_app/delete/(:num)', 'SettingAccountApp::delete/$1');
//Route CRUD Tagihan Air
$routes->get('/tagihan/create', 'Tagihan::create');
$routes->post('/tagihan/store', 'Tagihan::store');
$routes->get('/tagihan/edit/(:num)', 'Tagihan::edit/$1');
$routes->post('/tagihan/update/(:num)', 'Tagihan::update/$1');
$routes->post('tagihan/delete/(:num)', 'Tagihan::delete/$1');
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
//Controller Api
//send data ke aplikasi
$routes->post('Tagihan/kirimMultiUser', 'Tagihan::kirimMultiUser');
$routes->post('TagihanApi/simpanRiwayat', 'TagihanApi::simpanKeRiwayat');
//Route card android
$routes->get('TagihanApi/cardData', 'Api\TagihanApi::cardData');
//Daftar Tagihan Aplikasi
$routes->get('tagihanapi', 'Api\TagihanApi::index');
//route kirim aplikasi
$routes->post('TagihanApi/kirim', 'Api\TagihanApi::kirim');
$routes->post('update-tagihan', 'Tagihan::update');
$routes->put('tagihanapi/(:num)', 'Api\TagihanApi::update/$1');
$routes->resource('tagihanapi', ['controller' => 'Api\TagihanApi']);
// Notifikasi API
$routes->group('api', ['namespace' => 'App\Controllers\Api'], function($routes) {
    $routes->get('notifikasi', 'Notifikasi::index');
    $routes->get('notifikasi/(:num)/(:num)', 'Notifikasi::filterByMonthYear/$1/$2'); // contoh: /api/notifikasi/07/2025
    $routes->delete('notifikasi/(:num)', 'Notifikasi::delete/$1');
});