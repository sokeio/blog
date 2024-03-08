<?php

namespace Sokeio\Blog;

use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;
use Sokeio\Blog\Livewire\MenuItemCategory;
use Sokeio\Blog\Livewire\MenuItemPost;
use Sokeio\Blog\Shortcodes\ShortcodesServerProvider;
use Sokeio\Laravel\ServicePackage;
use Sokeio\Concerns\WithServiceProvider;
use Sokeio\Facades\Menu;
use Sokeio\Facades\MenuRender;
use Sokeio\Facades\Platform;
use Sokeio\Menu\MenuBuilder;

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
            ->name('blog')
            ->hasConfigFile()
            ->hasViews()
            ->hasHelpers()
            ->hasAssets()
            ->hasTranslations()
            ->runsMigrations();
    }
    private function bootGate()
    {
        $this->app->register(ShortcodesServerProvider::class);
        if (!$this->app->runningInConsole()) {
            add_filter(PLATFORM_PERMISSION_CUSTOME, function ($prev) {
                return [
                    ...$prev
                ];
            });
        }
    }
    public function packageBooted()
    {
        $this->bootGate();
        Platform::ready(function () {
            MenuRender::RegisterType(MenuItemPost::class);
            MenuRender::RegisterType(MenuItemCategory::class);
            if (sokeioIsAdmin()) {
                if (postWithBuilder()) {
                    Livewire::component('blog::post-builder', PostBuilder::class);
                }
                Menu::Register(function () {
                    menuAdmin()
                        ->subMenu('Posts', '<svg xmlns="http://www.w3.org/2000/svg"
                         class="icon icon-tabler icon-tabler-file-text" width="24"
                          height="24" viewBox="0 0 24 24" stroke-width="2"
                           stroke="currentColor" fill="none"
                            stroke-linecap="round" stroke-linejoin="round">
                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                <path d="M14 3v4a1 1 0 0 0 1 1h4"></path>
                <path d="M17 21h-10a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v11a2 2 0 0 1 -2 2z"></path>
                <path d="M9 9l1 0"></path>
                <path d="M9 13l6 0"></path>
                <path d="M9 17l6 0"></path>
             </svg>', function (MenuBuilder $menu) {
                            $menu->setTargetId('cms_post_menu');
                            $menu->route(['name' => 'admin.post', 'params' => []], 'Posts', '', [], 'admin.post');
                            $menu->route(
                                ['name' => 'admin.catalog', 'params' => []],
                                'Catalogs',
                                '',
                                [],
                                'admin.catalog'
                            );
                            $menu->route(['name' => 'admin.tag', 'params' => []], 'Tags', '', [], 'admin.tag');
                        });
                });
            }
        });
    }
}
