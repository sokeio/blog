<?php

namespace Sokeio\Blog\Livewire\Post;

use Sokeio\Components\Form;
use Sokeio\Components\UI;
use Sokeio\Breadcrumb;
use Sokeio\Blog\Models\Catalog;
use Sokeio\Blog\Models\Post;
use Sokeio\Blog\Models\Tag;
use Sokeio\Components\Common\Div;

class PostForm extends Form
{
    public $categoryIds = [];
    public $tagIds = '';
    public function getTitle()
    {
        return __('Post');
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
        return Post::class;
    }
    protected function loadDataAfter($post)
    {
        $this->categoryIds = $post->catalogs()->get()->map(function ($item) {
            return $item->id;
        })->toArray();
        $this->tagIds = json_encode($post->tags()->get()->map(function ($item) {
            return [
                'value' => $item->title,
                'id' => $item->id
            ];
        })->toArray());
    }
    protected function saveAfter($post)
    {

        $tagIds = collect(json_decode($this->tagIds, true))->map(function ($item) {
            if (isset($item['id'])) {
                return $item['id'];
            }

            $tag = Tag::create([
                'title' => is_string($item) ? $item : $item['value'],
                'author_id' => auth()->user()->id
            ]);
            $tag->save();
            return $tag->id;
        });

        $post->tags()->sync(
            collect($tagIds)
                ->filter(function ($item) {
                    return $item > 0;
                })
                ->toArray()
        );

        $post->catalogs()->sync(
            collect($this->categoryIds)
                ->filter(function ($item) {
                    return $item > 0;
                })
                ->toArray()
        );
    }

    public function TagSearch($keyword)
    {
        $this->skipRender();
        return Tag::where('name', 'like', '%' . $keyword . '%')->get()->map(function ($item) {
            return ['value' => $item->name, 'id' => $item->id];
        });
    }
    protected function footerUI()
    {
        return null;
    }
    public function formUI()
    {
        return UI::container([
            UI::prex(
                'data',
                [
                    UI::hidden('author_id')->valueDefault(auth()->user()->id),
                    UI::row([
                        UI::column8([
                            UI::text('title')->label(__('Title'))->required(),
                            UI::text('slug')->label(__('Slug')),
                            UI::tinymce('content')->label(__('Blog'))->required(),
                            UI::textarea('description')->label(__('Description')),
                            UI::textarea('custom_js')->label(__('Custom Js')),
                            UI::textarea('custom_css')->label(__('Custom CSS')),
                        ]),
                        UI::column4([
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
                            UI::datePicker('published_at')->label(__('Published At')),
                            UI::image('image')->label(__('Image')),
                            UI::checkBoxMutil('categoryIds')->prex('')->label(__('Category'))->dataSource(function () {
                                return Catalog::query()->where('status', 'published')->get();
                            })->noSave(),
                            UI::tagify('tagIds')->prex('')->label(__('Tags'))->fieldOption(function () {
                                return [
                                    'whitelistAction' => 'TagSearch',
                                    'searchKeys' => ["title"]
                                ];
                            })->noSave(),
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
                            UI::select('view_layout')->label(__('View Layout'))->dataSource(function () {
                                return applyFilters('POST_VIEW_LAYOUT', [
                                    [
                                        'id' => 'default',
                                        'title' => __('Default')
                                    ],
                                    [
                                        'id' => 'right',
                                        'title' => __('Right')
                                    ],
                                    [
                                        'id' => 'left',
                                        'title' => __('Left')
                                    ],
                                ]);
                            })->valueDefault('default'),
                            UI::button(__('Save article'))->wireClick('doSave()')->className('w-100 mb-2'),
                        ]),
                    ]),
                ]
            )
        ])
            ->className('p-3');
    }
}
