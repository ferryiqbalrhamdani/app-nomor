<?php

use App\Http\Controllers\LogoutController;
use App\Livewire;
use Illuminate\Support\Facades\Route;



Route::get('/dashboard', Livewire\Dashboard::class);
Route::get('/login', Livewire\Auth\Login::class)->name('login');
Route::get('/lupa-password', Livewire\Auth\LupaPassword::class);


Route::middleware(['auth'])->group(function () {
    Route::get('/ubah-password', Livewire\Auth\UbahPassword::class);
    Route::get('/logout', [LogoutController::class, 'logout']);

    Route::get('/nomor-surat/hari-ini', Livewire\NomorSurat\HariIni::class);
    Route::get('/nomor-surat/kastem', Livewire\NomorSurat\Kastem::class);
    Route::get('/nomor-surat/kastem-admin', Livewire\NomorSurat\KastemAdmin::class);

    Route::get('/surat-jalan', Livewire\SuratJalan::class);
    Route::get('/my-profile', Livewire\MyProfile::class);
    Route::get('/data-master/data-role', Livewire\DataMaster\DataRole::class);
    Route::get('/data-master/data-pt', Livewire\DataMaster\DataPt::class);
    Route::get('/data-master/data-users', Livewire\DataMaster\DataUsers::class);
    Route::get('/data-master/nomor-surat', Livewire\DataMaster\NomorSurat::class);

    Route::get('/', function () {
        return redirect('/dashboard');
    });
});
