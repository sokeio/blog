<?php

namespace Sokeio\Blog;

use Illuminate\Support\ServiceProvider;
use Sokeio\ServicePackage;
use Sokeio\Core\Concerns\WithServiceProvider;

class BlogServiceProvider extends ServiceProvider
{
    use WithServiceProvider;

    public function configurePackage(ServicePackage $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         */
        $package
            ->name('sokeio-blog')
            ->hasConfigFile()
            ->hasViews()
            ->hasHelpers()
            ->hasAssets()
            ->hasTranslations()
            ->runsMigrations();
    }
    public function packageRegistered()
    {
        // packageRegistered
    }
    
    public function packageBooted()
    {
        // packageBooted
    }
}
