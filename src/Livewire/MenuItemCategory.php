<?php

namespace Sokeio\Blog\Livewire;

use Sokeio\Blog\Models\Catalog;
use Sokeio\Components\FormMenu;
use Sokeio\Components\UI;
use Sokeio\Menu\MenuItemBuilder;

class MenuItemCategory extends FormMenu
{
    public static function renderItem(MenuItemBuilder $item)
    {
        echo  viewScope('sokeio::menu.item.link', [
            'item' => $item,
            'link' => Catalog::find($item->getValueBlogData())?->getSeoCanonicalUrl()
        ])->render();
    }
    public static function getMenuName(): string
    {
        return __('Catagory');
    }
    public static function getMenuType(): string
    {
        return 'MenuItemCategory';
    }
    public function searchCatagory($text)
    {
        $this->skipRender();
        return Catalog::query()->where('name', 'like', '%' . $text . '%')->limit(20)->get(['id', 'name']);
    }
    protected function MenuUI()
    {
        return [
            UI::selectWithSearch('data')->label(__('Catagory'))->required()
                ->searchFn('searchCatagory')->dataSource(function () {
                    return $this->SearchCatagory('');
                }),
        ];
    }
}
