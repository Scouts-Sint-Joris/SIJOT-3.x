<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Authencation routes.
use Illuminate\Support\Facades\Mail;

Auth::routes();

Route::get('/sparkpost', function () {
    Mail::send('auth.passwords.email', [], function ($message) {
        $message
            ->from('contact@st-joris-turnhout.be', 'tim joosten')
      ->to('topairy@gmail.com', 'Receiver Name')
      ->subject('From SparkPost with ❤');
  });
});

// Misc. routes
Route::get('/', 'HomeController@index')->name('home');
Route::get('/home', 'HomeController@backend')->name('backend');

// Lease routes.
Route::get('/verhuur', 'LeaseController@index')->name('lease');
Route::get('/verhuur/aanvragen', 'LeaseController@leaseRequest')->name('lease.request');
Route::post('/verhuur/aanvragen', 'LeaseController@store')->name('lease.store');
Route::get('/verhuur/bereikbaarheid', 'LeaseController@domainAccess')->name('lease.access');
Route::get('/verhuur/beheer', 'LeaseController@backend')->name('lease.backend');
Route::get('/verhuur/status/{status}/{id}', 'LeaseController@status')->name('lease.status');
Route::get('/verhuur/verwijder/{id}', 'LeaseController@delete')->name('lease.delete');
Route::get('/verhuur/exporteer', 'LeaseController@export')->name('lease.export');

// ACL routes
Route::get('/gebruikers', 'UsersController@index')->name('users.index');
Route::get('/gebruikers/info/{id}', 'UsersController@getById')->name('users.getId');
Route::post('/gebruikers/blokkeer', 'UsersController@block')->name('users.block');

