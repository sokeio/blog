<?php

namespace Sokeio\Blog\Livewire\Post;

use Sokeio\Blog\Models\Catalog;
use Sokeio\Blog\Models\Post;
use Sokeio\Components\Table;
use Sokeio\Components\UI;

class PostTable extends Table
{

    protected function getModel()
    {
        return Post::class;
    }
    public function getTitle()
    {
        return __('Post');
    }
    protected function searchUI()
    {
        return [
            UI::row([
                UI::column4([
                    UI::select('catalogs.id')->label(__('Category'))->dataSource(function () {
                        return [
                            [
                                'id' => '',
                                'title' => __('All')
                            ],
                            ...Catalog::query()->where('status', 'published')->get(['id', 'title'])->toArray()
                        ];
                    }),
                ])
            ])

        ];
    }
    protected function getRoute()
    {
        return 'admin.post';
    }
    protected function getButtons()
    {
        return applyFilters('CMS_POST_BUTTONS', [
            UI::buttonCreate(__('Create'))->modalRoute($this->getRoute() . '.add')->modalTitle(__('Create Data'))->modalFullscreen(),
            UI::button(__('Create With Builder'))->Link(function () {
                if (!postWithBuilder()) {
                    return '#';
                }
                return route('admin.post.create-builder');
            })->when(function () {
                return postWithBuilder();
            }),
        ]);
    }
    protected function getTableActions()
    {
        return applyFilters('CMS_POST_TABLE_ACTIONS', [
            UI::buttonEdit(__('Edit'))->modalRoute($this->getRoute() . '.edit', function ($row) {
                return [
                    'dataId' => $row->id
                ];
            })->modalTitle(__('Edit Data'))->modalFullscreen(),
            UI::button(__('Edit With Builder'))->Link(function ($item) {
                if (!postWithBuilder()) {
                    return '#';
                }
                return route('admin.post.edit-builder', ['dataId' => $item->getDataItem()->id]);
            })->when(function () {
                return postWithBuilder();
            }),
            UI::buttonRemove(__('Remove'))->confirm(__('Do you want to delete this record?'), 'Confirm')->wireClick(function ($item) {
                return 'doRemove(' . $item->getDataItem()->id . ')';
            })
        ]);
    }
    protected function getQuery()
    {

        return Post::query()->with('catalogs');
    }
    public function getColumns()
    {
        return [
            UI::text('name')->label(__('Title'))->fieldValue(function ($item) {
                return  "<a href='" . $item->getSeoCanonicalUrl() . "' title='{$item->name}' target='_blank'>{$item->name}</a>";
            }),
            UI::text('catalogs')->label(__('Category'))->NoSort()->fieldValue(function ($item) {
                if (!$item->catalogs || count($item->catalogs) == 0) {
                    return __('None');
                }
                return $item->catalogs->pluck('name')->implode(', ');
            }),
            UI::text('status')->label(__('Status'))->NoSort(),
            UI::text('created_at')->label(__('Created At')),
            UI::text('updated_at')->label(__('Updated At')),
        ];
    }
}
