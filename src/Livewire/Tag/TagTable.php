<?php

namespace Sokeio\Blog\Livewire\Tag;

use Sokeio\Blog\Models\Tag;
use Sokeio\Components\Table;
use Sokeio\Components\UI;

class TagTable extends Table
{
    protected function getModel()
    {
        return Tag::class;
    }
    public function getTitle()
    {
        return __('Tag Manager');
    }
    protected function getRoute()
    {
        return 'admin.tag';
    }
    public function getColumns()
    {
        return [
            UI::text('name')->label(__('Title'))->fieldValue(function ($item) {
                return  "<a href='" . $item->getSeoCanonicalUrl() . "' title='{$item->name}' target='_blank'>{$item->name}</a>";
            }),
            UI::text('status')->label(__('Status'))->NoSort(),
            UI::text('created_at')->label(__('Created At')),
            UI::text('updated_at')->label(__('Updated At')),
        ];
    }
}
