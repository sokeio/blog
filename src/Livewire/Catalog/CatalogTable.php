<?php

namespace Sokeio\Content\Livewire\Catalog;

use Sokeio\Content\Models\Catalog;
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
            UI::Text('name')->Label(__('Name')),
            UI::Text('slug')->Label(__('Slug')),
            UI::Text('status')->Label(__('Status'))->NoSort(),
            UI::Text('created_at')->Label(__('Created At')),
            UI::Text('updated_at')->Label(__('Updated At')),
        ];
    }
}
