<?php

namespace Sokeio\Blog\Livewire\Catalog;

use Sokeio\Blog\Models\Catalog;
use Sokeio\Components\Table;
use Sokeio\Components\UI;

class CatalogTable extends Table
{
    protected function getModel()
    {
        return Catalog::class;
    }
    public function getTitle()
    {
        return __('Catalog');
    }
    protected function getRoute()
    {
        return 'admin.catalog';
    }
  
    public function getColumns()
    {
        return [
            UI::text('name')->label(__('Name'))->fieldValue(function ($item) {
                return  "<a href='" . $item->getSeoCanonicalUrl() . "' title='{$item->name}' target='_blank'>{$item->name}</a>";
            }),
            UI::text('status')->label(__('Status'))->NoSort(),
            UI::text('created_at')->label(__('Created At')),
            UI::text('updated_at')->label(__('Updated At')),
        ];
    }
}
