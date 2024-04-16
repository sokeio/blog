<?php

namespace Sokeio\Blog\Livewire\Tag;

use Sokeio\Components\Form;
use Sokeio\Components\UI;
use Sokeio\Breadcrumb;
use Sokeio\Blog\Models\Tag;

class TagForm extends Form
{
    public function getTitle()
    {
        return __('Tag');
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
        return Tag::class;
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
                            UI::text('name')->label(__('Title'))->required(),
                            UI::text('slug')->label(__('Slug')),
                            UI::image('image')->label(__('Image')),
                            UI::row([
                                UI::select('status')->label(__('Status'))->dataSource(function () {
                                    return [
                                        [
                                            'id' => 'draft',
                                            'name' => __('Draft')
                                        ],
                                        [
                                            'id' => 'published',
                                            'name' => __('Published')
                                        ]
                                    ];
                                })->valueDefault('published')->col6(),

                                UI::select('layout')->label(__('Layout'))->dataSource(function () {
                                    return [
                                        [
                                            'id' => 'default',
                                            'name' => __('Default')
                                        ],
                                        [
                                            'id' => 'none',
                                            'name' => __('None')
                                        ],
                                    ];
                                })->col6(),
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
