<?php

namespace App\Providers;

use App\Models\Text;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class TextServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('texts', function ($app) {
            return new Text();
        });
        $loader = \Illuminate\Foundation\AliasLoader::getInstance();
        $loader->alias('Setting', Setting::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        if (!\App::runningInConsole() && count(Schema::getColumnListing('texts'))) {
            $texts = Text::all();
            foreach ($texts as $key => $setting)
            {
                Config::set('texts.'.$setting->key, $setting->value);
            }
        }
    }
}
