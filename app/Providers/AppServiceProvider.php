<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

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
        Validator::extend('older_than', function($attribute, $value, $parameters)
        {
            // $minAge = ( ! empty($parameters)) ? (int) $parameters[0] : 13;
            // return (new DateTime)->diff(new DateTime($value))->y >= $minAge;

            // or the same using Carbon:
            return Carbon::now()->diff(new Carbon($value))->y >= $parameters[0];
        });
        Validator::replacer(
            'older_than',
            function ($message, $attribute, $rule, $parameters) {
                return __('validation.olderThan', ['age' => $parameters[0]]);
            }
        );
    }
}
