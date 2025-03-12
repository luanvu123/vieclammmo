<?php

namespace App\Providers;

use App\Models\Category;
use App\Models\Complaint;
use App\Models\Customer;
use App\Models\Info;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Support;
use App\Models\UidEmail;
use App\Models\UidFacebook;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
         view()->composer('*', function ($view) {
            $layout_customer = Customer::count();
            $layout_order = Order::count();
           $layout_order_detail = OrderDetail::count();
            $layout_support = Support::count();
            $layout_complaint = Complaint::count();
            $layout_categories = Category::where('status', 'active')->get()->groupBy('type');
            $layout_info = Info::first();
            $view->with(compact(
                'layout_customer',
                'layout_order',
                'layout_order_detail',
                'layout_support',
                'layout_complaint',
                'layout_categories',
                'layout_info'
            ));
        });

    }
}
