<?php

namespace App\Providers;


use Illuminate\Support\ServiceProvider;
use App\Repositories\TranslationRepositoryInterface;
use App\Repositories\EloquentTranslationRepository;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(TranslationRepositoryInterface::class, EloquentTranslationRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
