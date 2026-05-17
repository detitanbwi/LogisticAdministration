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

        \Carbon\Carbon::macro('parseIndonesian', function ($dateString) {
            $map = [
                'Januari' => 'January',
                'Februari' => 'February',
                'Maret' => 'March',
                'April' => 'April',
                'Mei' => 'May',
                'Juni' => 'June',
                'Juli' => 'July',
                'Agustus' => 'August',
                'September' => 'September',
                'Oktober' => 'October',
                'November' => 'November',
                'Desember' => 'December',
                'Agu' => 'Aug',
                'Okt' => 'Oct',
                'Des' => 'Dec',
            ];
            $str = str_ireplace(array_keys($map), array_values($map), $dateString);
            return \Carbon\Carbon::parse($str);
        });
    }
}
