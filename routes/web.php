<?php

use App\Livewire\Admin\Product\ProductForm;
use App\Livewire\Admin\Product\ProductList;
use App\Livewire\Admin\Product\ProductShow;
use App\Livewire\Admin\Quotes\QuoteList;
use Illuminate\Support\Facades\Route;

Route::get('/', static fn () => view('welcome'))->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', fn () => redirect()->route('admin.dashboard'))->name('dashboard');

    Route::name('admin.')->prefix('admin')->group(function () {
        Route::view('/', 'dashboard')->name('dashboard');

        Route::name('products.')->prefix('products')->group(function () {
            Route::get('/', ProductList::class)->name('index');
            Route::get('/create/{productId?}', ProductForm::class)->name('create');
            Route::get('/{productId}', ProductShow::class)->name('show');
        });

        Route::name('quotes.')->prefix('quotes')->group(function () {
            Route::get('/', QuoteList::class)->name('index');
        });
    });
});

require __DIR__.'/settings.php';
