<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;

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
        Schema::defaultStringLength(191);

        \Illuminate\Support\Facades\View::composer('layouts.app', function ($view) {
            $service = new \App\Services\NotificationService();
            $view->with('notifications', $service->getNotifications());
            $view->with('notificationCount', $service->getCount());
        });
    }
}
