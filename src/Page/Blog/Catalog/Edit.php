<?php

namespace Sokeio\Blog\Page\Blog\Catalog;

use Sokeio\Content\Models\Catalog;
use Sokeio\Core\Attribute\AdminPageInfo;
use Sokeio\Theme;
use Sokeio\UI\Common\Div;
use Sokeio\UI\Common\Button;
use Sokeio\UI\Field\Input;
use Sokeio\UI\Field\MediaFile;
use Sokeio\UI\Field\Select;
use Sokeio\UI\Field\SwitchField;
use Sokeio\UI\Field\Textarea;
use Sokeio\UI\PageUI;
use Sokeio\UI\WithEditUI;

#[AdminPageInfo(title: 'Catalog', model: Catalog::class)]
class Edit extends \Sokeio\Page
{
    use WithEditUI;
    protected function setupUI()
    {
        return [
            PageUI::make([
                Input::make('title')->label(__('Title')),
                MediaFile::make('image')->label(__('Image')),
                Textarea::make('description')->label(__('Description')),
                Select::make('template')->label(__('Template'))->dataSource(Theme::getTemplateOptions())
                ->valueDefault('none')
                    ->when(function (Select $field) {
                        return $field->checkDataSource();
                    }),
                SwitchField::make('published')->label(__('Published'))
                    ->valueDefault($this->dataId ?  null : 1)->labelTrue(__('Active'))->labelFalse(__('Unactive')),
            ])
                ->prefix('formData')
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
