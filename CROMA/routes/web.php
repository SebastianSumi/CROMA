<?php

use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome')->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::view('dashboard', 'dashboard')->name('dashboard');

    // Rutas del Catálogo y Módulos de Producción
    Route::get('/servicios', \App\Livewire\ListarServiciosMain::class);
    Route::get('/impresion', \App\Livewire\ImpresionMain::class);
    Route::get('/offset', \App\Livewire\OffsetMain::class);
    Route::get('/diseno', \App\Livewire\DisenoGraficoMain::class);
    Route::get('/audiovisual', \App\Livewire\AudiovisualMain::class);
    Route::get('/lanyard', \App\Livewire\LanyardCintaMain::class);
    Route::get('/fotocheck', \App\Livewire\FotocheckPvcMain::class);
});

require __DIR__.'/settings.php';
