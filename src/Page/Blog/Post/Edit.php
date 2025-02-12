<?php

namespace Sokeio\Blog\Page\Blog\Post;

use Carbon\Carbon;
use Sokeio\Blog\Models\Post;
use Sokeio\Core\Attribute\AdminPageInfo;
use Sokeio\Page\Enums\PublishedType;
use Sokeio\Platform;
use Sokeio\Theme;
use Sokeio\UI\Common\Div;
use Sokeio\UI\Common\Button;
use Sokeio\UI\Field\ContentEditor;
use Sokeio\UI\Field\DatePicker;
use Sokeio\UI\Field\Input;
use Sokeio\UI\Field\CodeEditor;
use Sokeio\UI\Field\Select;
use Sokeio\UI\Field\SwitchField;
use Sokeio\UI\Field\Textarea;
use Sokeio\UI\PageUI;
use Sokeio\UI\Tab\TabControl;
use Sokeio\UI\WithEditUI;

#[AdminPageInfo(title: 'Post', model: Post::class)]
class Edit extends \Sokeio\Page
{
    use WithEditUI;
    protected function afterMount($data)
    {
        data_set($this->formData, 'catalogIds', $data->catalogs()->pluck('catalog_id')->toArray());
        data_set($this->formData, 'tagIds', $data->tags()->pluck('tag_id')->toArray());
        return $data;
    }
    protected function afterSaveData($data)
    {
        $data->catalogs()->sync(data_get($this->formData, 'catalogIds'));
        $tagIds = data_get($this->formData, 'tagIds');
        // $tagIds tag1 tag2 create tag and get id
        $tagIds = collect($tagIds)->map(function ($item) {
            if (is_numeric($item)) {
                return $item;
            }
            return \Sokeio\Blog\Models\Tag::firstOrCreate([
                'title' => $item,
                'published' => 1
            ])->id;
        });

        $data->tags()->sync($tagIds->toArray());
        return $data;
    }

    protected function setupUI()
    {
        return [
            PageUI::make(
                Div::make([
                    Div::make([
                        Input::make('title')->label(__('Title')),
                        Textarea::make('description')->label(__('Description')),
                        TabControl::make()
                            ->iconSize(3)
                            ->tabItem(__('Content'), 'ti ti-file-text', [
                                ContentEditor::make('content')
                            ])
                            ->tabItem(
                                __('Custom'),
                                'ti ti-settings',
                                Div::make([
                                    CodeEditor::make('custom_js')->label(__('Custom JS')),
                                    CodeEditor::make('custom_css')->label(__('Custom CSS')),
                                ])
                            )
                    ])->col9(),
                    Div::make([
                        Select::make('published_type')->dataSourceWithEnum(PublishedType::class)->label(__('Published'))->valueDefault(PublishedType::PUBLISHED->value),
                        DatePicker::make('published_at')->label(__('Published At'))->enableTime()
                            ->valueDefault(Carbon::now()->format('Y-m-d H:i:s')),
                        Select::make('catalogIds')->skipFill()->label(__('Catalog'))->multiple()
                            ->remoteActionWithModel(
                                \Sokeio\Blog\Models\Catalog::class,
                                'title'
                            ),
                        Select::make('tagIds')->skipFill()->label(__('Tag'))->multiple()
                            ->createItem()
                            ->remoteActionWithModel(
                                \Sokeio\Blog\Models\Tag::class,
                                'title'
                            ),
                        Select::make('template')->label(__('Template'))->dataSource(Theme::getTemplateOptions())
                            ->valueDefault('')
                            ->when(function (Select $field) {
                                return $field->checkDataSource();
                            })
                    ])->col3(),
                ])->row()->className('g-1')
            )
                ->onlyModal()
                ->prefix('formData')->xxlSize()
                ->afterUI([
                    Div::make([
                        Button::make()->label(__('Cancel'))->className('btn btn-warning me-2')->modalClose(),
                        Button::make()->label(__('Save'))->wireClick('saveData')
                    ])
                        ->className('px-2 pt-2 d-flex justify-content-end')
                ])

        ];
    }
}
