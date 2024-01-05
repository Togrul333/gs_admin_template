<?php

namespace App\Providers;

use App\Models\Category;
use App\Models\News;
use App\Models\Slider;
use App\Models\User;
use App\Models\Writer;
use App\Models\Writing;
use Illuminate\Database\Eloquent\Relations\Relation;
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
        Relation::morphMap([
            'user' => User::class,
        ]);
    }
}
