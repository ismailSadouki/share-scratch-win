<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Request as FacadesRequest;
use Illuminate\Support\Facades\Session;

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




Auth::routes();

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
// Route::get('/myOffers', [App\Http\Controllers\OfferController::class, 'myOffers'])->name('myoffers');
Route::get('/offer/create', [App\Http\Controllers\OfferController::class, 'create'])->name('offer.create')->middleware('auth');
Route::post('/offer/store', [App\Http\Controllers\OfferController::class, 'store'])->name('offer.store')->middleware('auth');
Route::get('/offer/show/{slug}', [App\Http\Controllers\OfferController::class, 'show']);
Route::get('/offer/show/{slug}/{reference_code}', [App\Http\Controllers\OfferController::class, 'show']);

Route::post('/offer/success', [App\Http\Controllers\ParticipantController::class, 'offerSuccess'])->name('offer.success');
Route::post('/offer/phone/{id}', [App\Http\Controllers\ParticipantController::class, 'savePhone'])->name('save.phone');
Route::get('/offer/download/{img}', [App\Http\Controllers\ParticipantController::class, 'downloadImg'])->name('download.img');

// My Offer
Route::get('/myoffer', [App\Http\Controllers\OfferController::class, 'myOffers'])->name('myoffers')->middleware('auth');
Route::get('/myoffer/{id}', [App\Http\Controllers\OfferController::class, 'showMyOffer'])->name('show.myoffers')->middleware('auth');


// Check Participant status
Route::get('/check/status/{id}', [App\Http\Controllers\ParticipantController::class, 'checkStatus'])->name('check.status');





