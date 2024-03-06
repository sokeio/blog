<?php

namespace Sokeio\Blog\Shortcodes;

use Illuminate\Support\ServiceProvider;

class ShortcodesServerProvider extends ServiceProvider
{
    public function boot()
    {
        // CatalogShortcode::Register();
        PostShortcode::Register();
    }
}
