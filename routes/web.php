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
Auth::routes();

// Misc. routes
Route::get('/', 'HomeController@index')->name('home');
Route::get('/home', 'HomeController@backend')->name('backend');
Route::get('/disclaimer', 'DisclaimerController@index')->name('disclaimer');

// Lease routes.
Route::get('/verhuur', 'LeaseController@index')->name('lease');
Route::get('/verhuur/aanvragen', 'LeaseController@leaseRequest')->name('lease.request');
Route::post('/verhuur/aanvragen', 'LeaseController@store')->name('lease.store');
Route::get('/verhuur/bereikbaarheid', 'LeaseController@domainAccess')->name('lease.access');
Route::get('/verhuur/beheer', 'LeaseController@backend')->name('lease.backend');
Route::get('/verhuur/status/{status}/{id}', 'LeaseController@status')->name('lease.status');
Route::get('/verhuur/verwijder/{id}', 'LeaseController@delete')->name('lease.delete');
Route::get('/verhuur/exporteer', 'LeaseController@export')->name('lease.export');
Route::get('/verhuur/kalender', 'LeaseController@calendar')->name('lease.calendar');

// ACL routes
Route::get('/gebruikers', 'UsersController@index')->name('users.index');
Route::get('/gebruikers/info/{id}', 'UsersController@getById')->name('users.getId');
Route::post('/gebruikers/blokkeer', 'UsersController@block')->name('users.block');

// Account routes.
Route::get('/account', 'AccountController@index')->name('account');
Route::post('/account/info', 'AccountController@updateInfo')->name('account.info');
Route::post('/account/beveiliging', 'AccountController@updateSecurity')->name('account.security');

// Group routes
Route::get('/takken', 'GroupController@index')->name('groups.index');
Route::get('/takken/backend', 'GroupController@backend')->name('groups.backend');
Route::post('/takken/aanpassen/{id}', 'GroupController@update')->name('groups.update');
Route::get('/takken/{selector}', 'GroupController@show')->name('groups.show');

// News routes.
Route::get('/nieuws', 'NewsController@index')->name('news.index');
Route::post('/nieuws/toevoegen', 'NewsController@store')->name('news.store');
Route::get('/nieuws/show/{id}', 'NewsController@show')->name('news.show');
Route::get('/nieuws/status/{status}/{id}', 'NewsController@status')->name('news.status');
Route::get('/nieuws/json/{id}', 'NewsController@gyetById')->name('news.json');
Route::get('/nieuws/verwijder/{id}', 'NewsController@delete')->name('news.delete');

// Category routes
Route::post('/categorie/toevoegen', 'CategoryController@insert')->name('category.insert');
Route::get('/categorie/verwijderen/{id}', 'CategoryController@destroy')->name('category.delete');

// Events routes
Route::get('/events', 'EventsController@index')->name('events.index');
Route::post('/events/toevoegen', 'EventsController@store')->name('events.store');

// Activity routes
Route::get('activiteiten/backend', 'ActivityController@backend')->name('activity.backend');
Route::post('activiteiten/opslaan', 'ActivityController@store')->name('activity.store');
Route::get('activiteiten/bekijk/{id}', 'ActivityController@show')->name('activity.show');
Route::get('activiteiten/verwijder{id}', 'ActivityController@destroy')->name('activity.delete');
Route::get('activiteiten/status/{status}/{id}', 'ActivityController@status')->name('activity.status');
Route::get('activiteiten/json/{id}', 'ActivityController@getByid')->name('activity.json');
