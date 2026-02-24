<?php

namespace App\Providers;

use Illuminate\Support\Facades\Blade;
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
        // Back Components
        Blade::component('back.components.ui.alert', 'back.alert');
        Blade::component('back.components.form.text-input', 'back.text-input');
        Blade::component('back.components.form.checkbox', 'back.checkbox');
        Blade::component('back.components.ui.button', 'back.button');
        Blade::component('back.components.ui.datatable', 'back.datatable');
        Blade::component('back.components.form.select2', 'back.select2');
        Blade::component('back.components.form.radio', 'back.radio');
        Blade::component('back.components.form.wysiwyg', 'back.wysiwyg');
        Blade::component('back.components.form.textarea', 'back.textarea');
    }
}
