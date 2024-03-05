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
            UI::Text('name')->Label(__('Name'))->FieldValue(function ($item) {
                return  "<a href='" . $item->getSeoCanonicalUrl() . "' title='{$item->name}' target='_blank'>{$item->name}</a>";
            }),
            UI::Text('status')->Label(__('Status'))->NoSort(),
            UI::Text('created_at')->Label(__('Created At')),
            UI::Text('updated_at')->Label(__('Updated At')),
        ];
    }
}
