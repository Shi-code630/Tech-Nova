<?php

namespace App\Providers;

use App\Models\Category;
use App\Models\Order;
use App\Observers\OrderObserver;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;


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
        View::composer('components.frontend-header', function ($view) {

            $parentCategories = Category::query()
                ->whereNull('parent_id')
                ->where('status', true)
                ->with([
                    'children' => function ($query) {
                        $query
                            ->where('status', true)
                            ->orderBy('name');
                    }
                ])
                ->orderBy('name')
                ->get();

            $view->with('parentCategories', $parentCategories);
        });
        Order::observe(OrderObserver::class);
    }
}
