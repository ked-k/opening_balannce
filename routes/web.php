<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Livewire\Finance\FmsCurrenciesComponent;
use App\Http\Livewire\Finance\FmsProjectsComponent;
use App\Http\Livewire\Finance\FmsTransactionsComponent;
use App\Http\Livewire\Finance\FmsTrxCategoriesComponent;
use App\Http\Livewire\Finance\FmsViewProjectComponent;
use App\Http\Livewire\Management\AdminDashboard;
use App\Http\Livewire\UserManagement\UserProfileComponent;
use Illuminate\Support\Facades\Route;
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

Route::get('/', [AuthenticatedSessionController::class, 'create'])->middleware('guest')->name('login');
Route::get('user/account', UserProfileComponent::class)->name('user.account')->middleware('auth');

Route::get('lang/{locale}', function ($locale) {
    if (array_key_exists($locale, config('languages'))) {
        Session::put('locale', $locale);
    }

    return redirect()->back();
})->name('lang');

Route::group(['middleware' => ['auth', 'suspended_user']], function () {

    // Route::get('/home', function () {
    //     return view('home');
    //   })->middleware(['auth', 'verified'])->name('home');
    Route::get('dashboard', AdminDashboard::class)->name('home');
    Route::get('transactions/{type}', FmsTransactionsComponent::class)->name('transactions');
    Route::get('transactions/{id}/details', FmsViewProjectComponent::class)->name('project_transactions');
    Route::get('projects', FmsProjectsComponent::class)->name('projects');

    Route::group(['prefix' => 'admin'], function () {
        //User Management
        Route::get('/manage', function () {
            return view('admin.dashboard');
        })->middleware(['auth', 'verified'])->name('admin-dashboard');
        Route::get('currencies', FmsCurrenciesComponent::class)->name('currencies');
        Route::get('categories', FmsTrxCategoriesComponent::class)->name('trx_categories');

        require __DIR__ . '/user_mgt.php';
    });

    require __DIR__ . '/inventory.php';
});

require __DIR__ . '/auth.php';
