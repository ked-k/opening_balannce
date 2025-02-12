<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        if (Auth::user()) { // Check is user logged in
            View::share('facilityInfo', User::where('id', auth()->user()->id)->first());
        } else {
            View::share('facilityInfo', []);
        }

        Blade::directive('money_format', function ($figure) {
            return "<?php echo number_format($figure,2); ?>";
        });

        Blade::directive('number_formart', function ($figure) {
            return "<?php echo number_format($figure); ?>";
        });
        Blade::directive('formatDate', function ($expression) {
            return $expression != null ? "<?php echo date('d-M-Y', strtotime($expression)); ?>" : "<?php echo 'N/A'; ?>";
        });

        Blade::directive('formatDateTime', function ($date) {
            return $date != null ? "<?php echo date('d-M-Y H:i', strtotime($date)); ?>" : "<?php echo 'N/A'; ?>";
        });
    }
}
