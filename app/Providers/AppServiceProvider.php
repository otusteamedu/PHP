<?php

namespace App\Providers;

use App\Contracts\EmailValidatorContract;
use App\EmailValidators\MxValidator;
use App\EmailValidators\SyntaxValidator;
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
        $this->app->tag([SyntaxValidator::class, MxValidator::class], 'emailsValidators');
    }
}
