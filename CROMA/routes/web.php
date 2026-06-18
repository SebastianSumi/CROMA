<?php

use App\Livewire\CatalogShowcase;
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome')->name('home');

Route::get('/catalogo', CatalogShowcase::class)->name('catalogo.publico');
Route::get('/trabajos-anteriores', \App\Livewire\TrabajoAnteriorMain::class)->name('trabajos.index');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::view('dashboard', 'dashboard')->name('dashboard');

    // Módulo de Administración del Catálogo (CRUD de Productos)
    Route::get('/productos', \App\Livewire\ProductMain::class)->name('productos.index');

    // Rutas de los Módulos de Producción existentes
    Route::get('/servicios', \App\Livewire\ListarServiciosMain::class);
    Route::get('/impresion', \App\Livewire\ImpresionMain::class);
    Route::get('/offset', \App\Livewire\OffsetMain::class);
    Route::get('/diseno', \App\Livewire\DisenoGraficoMain::class);
    Route::get('/audiovisual', \App\Livewire\AudiovisualMain::class);
    Route::get('/lanyard', \App\Livewire\LanyardCintaMain::class);
    Route::get('/fotocheck', \App\Livewire\FotocheckPvcMain::class);
});

require __DIR__.'/settings.php';
