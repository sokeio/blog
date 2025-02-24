<?php

namespace Sokeio\Blog\Page\Blog\Tag;

use Sokeio\Blog\Models\Tag;
use Sokeio\Core\Attribute\AdminPageInfo;
use Sokeio\Page\Enums\PublishedType;
use Sokeio\Theme;
use Sokeio\UI\Common\Button;
use Sokeio\UI\Common\Div;
use Sokeio\UI\Field\Input;
use Sokeio\UI\Field\MediaFile;
use Sokeio\UI\Field\Select;
use Sokeio\UI\Field\SwitchField;
use Sokeio\UI\Field\Textarea;
use Sokeio\UI\PageUI;
use Sokeio\UI\WithEditUI;

#[AdminPageInfo(title: 'Tag', model: Tag::class)]
class Edit extends \Sokeio\Page
{
    use WithEditUI;
    protected function setupUI()
    {
        return [
            PageUI::make([
                Input::make('title')->label(__('Title')),
                MediaFile::make('image')->label(__('Image')),
                Select::make('template')->label(__('Template'))->dataSource(Theme::getTemplateOptions())
                    ->valueDefault('')
                    ->when(function (Select $field) {
                        return $field->checkDataSource();
                    }),
                Select::make('published_type')->dataSourceWithEnum(PublishedType::class)->label(__('Published'))->valueDefault(PublishedType::PUBLISHED->value),
                Textarea::make('description')->label(__('Description')),
            ])
                ->prefix('formData')
                ->afterUI([
                    Div::make([
                        Button::make()->label(__('Cancel'))->className('btn btn-warning me-2')->modalClose(),
                        Button::make()->label(__('Save'))->wireClick('saveData'),
                    ])
                        ->className('px-2 pt-2 d-flex justify-content-end')
                ])
                ->icon('ti ti-users')
        ];
    }
}
