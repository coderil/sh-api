<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LocationsEnumController;

Route::prefix('psgc')->group(function() {
    Route::get('regions', [LocationsEnumController::class, 'indexRegions']);
    Route::get('regions/{region}/provinces', [LocationsEnumController::class, 'indexProvinces'])
        ->scopeBindings();
    Route::get('provinces/{province}/cities', [LocationsEnumController::class, 'indexCities'])
        ->scopeBindings();
    Route::get('cities/{city}/barangays', [LocationsEnumController::class, 'indexBarangays'])
        ->scopeBindings();
});