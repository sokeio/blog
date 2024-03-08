<?php

namespace Sokeio\Blog;

use Sokeio\Builder\FormBuilder;
use Sokeio\Blog\Models\Catalog;
use Sokeio\Blog\Models\Post;
use Sokeio\Blog\Models\Tag;
use Sokeio\Components\UI;

class PostBuilder extends FormBuilder
{
    public $categoryIds = [];
    public $tagIds = '';

    protected function getTitle()
    {
        return __('Post');
    }
    protected function footerUI()
    {
        return [];
    }
    protected function loadDataAfter($post)
    {
        $this->categoryIds = $post->catalogs()->get()->map(function ($item) {
            return $item->id;
        })->toArray();
        $this->tagIds = json_encode($post->tags()->get()->map(function ($item) {
            return [
                'value' => $item->name,
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
                'name' => is_string($item) ? $item : $item['value'],
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
    protected function getPageList()
    {
        return route('admin.post');
    }
    protected function getLinkView()
    {
        return $this->data->slug ? route('post.slug', ['post' => $this->data->slug]) : '';
    }
    public function TagSearch($keyword)
    {
        return Tag::where('name', 'like', '%' . $keyword . '%')->get()->map(function ($item) {
            return ['value' => $item->name, 'id' => $item->id];
        });
    }
    protected function formUI()
    {
        return UI::prex('data', [
            UI::row([
                UI::column12([
                    UI::hidden('content')->valueDefault('')->required()->label(__('Blog')),
                    UI::hidden('author_id')->valueDefault(function () {
                        return auth()->user()->id;
                    }),
                    UI::Div(UI::error('content')),
                    UI::text('name')->label(__('Title'))->required(),
                    UI::text('slug')->label(__('Slug')),
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
                    })->valueDefault('published'),
                    UI::image('image')->label(__('Image')),
                    UI::checkBoxMutil('categoryIds')->prex('')->label(__('Category'))->dataSource(function () {
                        return Catalog::query()->where('status', 'published')->get();
                    })->noSave(),
                    UI::tagify('tagIds')->prex('')->label(__('Tags'))->fieldOption(function () {
                        return [
                            'whitelistAction' => 'TagSearch',
                            'searchKeys' => ["name"]
                        ];
                    })->noSave(),
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
                    }),
                    UI::textarea('description')->label(__('Description')),
                    UI::textarea('custom_js')->label(__('Custom Js')),
                    UI::textarea('custom_css')->label(__('Custom CSS')),
                    UI::button(__('Save article'))->wireClick('doSave()')->className('w-100 mb-2'),
                ]),
            ])
        ]);
    }
    protected function getModel()
    {
        return Post::class;
    }
}
