<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Livewire\Management\Admin\AnomalychartComponent;
use App\Http\Livewire\Management\Admin\MainbarComponent;
use App\Http\Livewire\Management\Admin\StatuschartComponent;
use App\Http\Livewire\Management\AdminDashboard;
use App\Http\Livewire\Management\AuditDetailComponent;
use App\Http\Livewire\Management\AuditsComponent;
use App\Http\Livewire\Management\ClusteredKeysComponent;
use App\Http\Livewire\Management\DistrictsComponent;
use App\Http\Livewire\Management\FeederComponent;
use App\Http\Livewire\Management\IssuedMetersComponent;
use App\Http\Livewire\Management\KeyRequestsComponent;
use App\Http\Livewire\Management\ManangeKeysComponent;
use App\Http\Livewire\Management\MetersComponent;
use App\Http\Livewire\Management\OfficialAuditsComponent;
use App\Http\Livewire\Management\Report\UserReportComponent;
use App\Http\Livewire\Management\ZonesComponent;
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

Route::group(['middleware' => ['auth',  'suspended_user']], function () {
    
    // Route::get('/home', function () {
    //     return view('home');
    //   })->middleware(['auth', 'verified'])->name('home');
    Route::get('dashboard', AdminDashboard::class)->name('home');
    Route::get('keys/requests', KeyRequestsComponent::class)->name('keyRequests');
    Route::get('keys/non_amr', ManangeKeysComponent::class)->name('nonAmrKeys');
    Route::get('keys/clustered', ClusteredKeysComponent::class)->name('clusteredBoxKeys');
    
     
    Route::group(['prefix' => 'admin'], function () {
        //User Management
        Route::get('/manage', function () {
            return view('admin.dashboard');
          })->middleware(['auth', 'verified'])->name('admin-dashboard');
          Route::get('feeders', FeederComponent::class)->name('feeders');
          Route::get('meter_types', MetersComponent::class)->name('meterTypes');
          Route::get('districts', DistrictsComponent::class)->name('districts');
          Route::get('audits', AuditsComponent::class)->name('audits');
          Route::get('zones', ZonesComponent::class)->name('zones');
          Route::get('audit/{id}/preview', AuditDetailComponent::class)->name('preview.audit')->middleware('signed');
          Route::get('official/audits', OfficialAuditsComponent::class)->name('official.audit');
          Route::get('official/issued', IssuedMetersComponent::class)->name('official.issued');
          Route::get('audits/reports', UserReportComponent::class)->name('admin.reports');
        require __DIR__.'/user_mgt.php';
    });

    


    require __DIR__.'/inventory.php';
});

require __DIR__.'/auth.php';
