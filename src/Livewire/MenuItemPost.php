<?php

namespace Sokeio\Blog\Livewire;

use Sokeio\Blog\Models\Post;
use Sokeio\Components\FormMenu;
use Sokeio\Components\UI;
use Sokeio\Menu\MenuItemBuilder;

class MenuItemPost extends FormMenu
{
    public static function renderItem(MenuItemBuilder $item)
    {
        echo  viewScope('sokeio::menu.item.link', [
            'item' => $item,
            'link' => Post::find($item->getValueBlogData())?->getSeoCanonicalUrl()
        ])->render();
    }
    public static function getMenuName()
    {
        return __('Post');
    }
    public static function getMenuType()
    {
        return 'MenuItemPost';
    }
    protected function MenuUI()
    {
        return [
            UI::selectWithSearch('data')->label(__('Post'))
                ->required()
                ->searchFn('SearchPosts')
                ->actionUI('SearchPosts', function ($component, $text) {
                    $component->skipRender();
                    return Post::query()->where('title', 'like', '%' . $text . '%')->limit(20)->get(['id', 'title']);
                })
                ->dataSource(function () {
                    return Post::query()->limit(20)->get(['id', 'title']);
                }),
        ];
    }
}
