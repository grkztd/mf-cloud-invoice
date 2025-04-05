<?php

declare(strict_types=1);

use Grkztd\MfCloud\Laravel\Controllers\MoneyForwardController;

Route::group(['prefix' => 'mf', 'as' => 'mf.'], function() {
    Route::get('/quotations', [MoneyForwardController::class, 'quotations'])->name('quotations');
    Route::get('/billings', [MoneyForwardController::class, 'billings'])->name('billings');
    Route::get('/partners', [MoneyForwardController::class, 'partners'])->name('partners');

    Route::get('/{kind}/download', [MoneyForwardController::class, 'download'])->name('download');
});
