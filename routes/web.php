<?php

use App\Http\Controllers\CatalogController;
use App\Http\Controllers\PageController;
use Illuminate\Support\Facades\Route;

Route::get('/', fn () => redirect()->route('catalog.index'));

Route::prefix('catalog')->name('catalog.')->controller(CatalogController::class)->group(function () {
    Route::get('/', 'index')->name('index');
    Route::get('/stats', 'stats')->name('stats');
    Route::get('/owner/{owner?}', 'byOwner')->name('owner');
    Route::get('/code/{code}', 'byCode')
        ->where('code', '[A-Z]{3}-[0-9]{5}')->name('code');
    Route::get('/{id}', 'show')->whereNumber('id')->name('show');
});

Route::get('/feedback', [PageController::class, 'feedbackForm'])->name('feedback.form');
Route::post('/feedback', [PageController::class, 'feedbackSend'])->name('feedback.send');

Route::get('/hello/{name?}', function (string $name = 'гость') {
    return "Привет, {$name}!";
})->where('name', '[\p{L}]+');
