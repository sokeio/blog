<?php

namespace Sokeio\Blog\Livewire\Catalog;

use Sokeio\Components\Form;
use Sokeio\Components\UI;
use Sokeio\Breadcrumb;
use Sokeio\Blog\Models\Catalog;

class CatalogForm extends Form
{
    public function getTitle()
    {
        return __('Catalog');
    }
    public function getBreadcrumb()
    {
        return [
            Breadcrumb::Item(__('Home'), route('admin.dashboard'))
        ];
    }
    public function getButtons()
    {
        return [];
    }
    public function getModel()
    {
        return Catalog::class;
    }


    public function formUI()
    {
        return UI::container([
            UI::prex(
                'data',
                [
                    UI::hidden('author_id')->valueDefault(auth()->user()->id),
                    UI::row([
                        UI::column12([
                            UI::text('title')->label(__('Title'))->required(),
                            UI::image('image')->label(__('Image')),
                            UI::row([
                                UI::column6([
                                    UI::select('status')->label(__('Status'))->dataSource(function () {
                                        return [
                                            [
                                                'id' => 'draft',
                                                'title' => __('Draft')
                                            ],
                                            [
                                                'id' => 'published',
                                                'title' => __('Published')
                                            ]
                                        ];
                                    })->valueDefault('published'),
                                ]),
                                UI::column6([
                                    UI::select('layout')->label(__('Layout'))->dataSource(function () {
                                        return [
                                            [
                                                'id' => 'default',
                                                'title' => __('Default')
                                            ],
                                            [
                                                'id' => 'none',
                                                'title' => __('None')
                                            ],
                                        ];
                                    }),
                                ])
                            ]),

                            UI::row([
                                UI::column6(UI::checkBox('is_featured')->label(__('Featured'))->valueDefault(0)),
                                UI::column6(UI::checkBox('is_default')->label(__('Default'))->valueDefault(0))
                            ]),
                            UI::textarea('description')->label(__('Description')),
                        ])
                    ]),
                ]
            )
        ])
            ->className('p-3');
    }
}
