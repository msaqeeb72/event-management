<?php

namespace App\Providers;

use App\Domain\Repo\UserRepository;
use App\Repo\UserRepositoryImpl;
use App\Domain\Repo\EventRepository;
use App\Repo\EventRepositoryImpl;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Validator;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(UserRepository::class, function ($app) {
            return new UserRepositoryImpl();
        });
        $this->app->singleton(EventRepository::class, function ($app) {
            return new EventRepositoryImpl();
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Validator::extend('file_extension', function ($attribute, $value, $parameters, $validator) {
            $extensions = explode(',', $parameters[0]);
            $extension = strtolower($value->getClientOriginalExtension());
            return in_array($extension, $extensions);
        });
    }
}
