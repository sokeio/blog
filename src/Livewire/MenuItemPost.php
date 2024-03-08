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
        echo  view_scope('sokeio::menu.item.link', ['item' => $item, 'link' => Post::find($item->getValueBlogData())?->getSeoCanonicalUrl()])->render();
    }
    public static function getMenuName()
    {
        return __('Post');
    }
    public static function getMenuType()
    {
        return 'MenuItemPost';
    }
    public function SearchPosts($text)
    {
        $this->skipRender();
        return Post::query()->where('name', 'like', '%' . $text . '%')->limit(20)->get(['id', 'name']);
    }
    protected function MenuUI()
    {
        return [
            UI::selectWithSearch('data')->label(__('Post'))->required()->searchFn('SearchPosts')->dataSource(function () {
                return $this->SearchPosts('');
            }),
        ];
    }
}
