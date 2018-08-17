<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use OpenEDU\Course\Interfaces\CourseServiceFacade;
use OpenEDU\Course\Interfaces\CourseServiceFacadeImpl;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->bind(CourseServiceFacade::class, CourseServiceFacadeImpl::class);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
