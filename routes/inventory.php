<?php

use Illuminate\Support\Facades\Route;
use App\Http\Livewire\Inventory\Dashboard\InventoryMainDashboardComponent;

Route::group(['prefix' => 'inventory'], function () {
    Route::get('dashboard', InventoryMainDashboardComponent::class)->name('inventory-dashboard');

});