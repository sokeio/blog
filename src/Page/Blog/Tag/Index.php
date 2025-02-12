<?php

namespace Sokeio\Blog\Page\Blog\Tag;

use Sokeio\Blog\Models\Tag;
use Sokeio\Core\Attribute\AdminPageInfo;
use Sokeio\UI\Common\Button;
use Sokeio\UI\PageUI;
use Sokeio\UI\Table\Column;
use Sokeio\UI\Table\Table;
use Sokeio\UI\WithUI;

#[AdminPageInfo(
    title: 'Tag',
    menu: true,
    menuTitle: 'Tag',
    model: Tag::class,
    icon: 'ti ti-tag',
    sort: 3
)]
class Index extends \Sokeio\Page
{
    use WithUI;
    protected function setupUI()
    {
        return [
            PageUI::make(
                [
                    Table::make()
                        ->column(Column::make('title')->enableLink())
                        ->column('description')
                        ->column('published')
                        ->column('created_at')
                        ->column('template')
                        ->query($this->getQuery())
                        ->enableIndex()
                        ->searchbox(['title', 'description'])
                        ->columnAction([
                            Button::make()->label(__('Edit'))->className('btn ms-1 btn-primary btn-sm ')
                                ->modal(function (Button $button) {
                                    return route($this->getRouteName('edit'), [
                                        'dataId' =>
                                        $button->getParams('row')->id
                                    ]);
                                }),
                            Button::make()->label(__('Delete'))
                                ->wireClick(function ($params) {
                                    ($this->getModel())::find($params)->delete();
                                }, 'table_delete', function (Button $button) {
                                    return $button->getParams('row')->id;
                                })->className('btn btn-danger ms-1 btn-sm')
                                ->confirm(__('Are you sure?')),
                        ])->rightUI([
                            Button::make()
                                ->label(__('Add ' . $this->getPageConfig()->getTitle()))
                                ->icon('ti ti-plus')
                                ->modalRoute(
                                    $this->getRouteName('edit'),
                                    __('Add ' . $this->getPageConfig()->getTitle()),
                                    'lg',
                                    'ti ti-plus'
                                )
                        ])
                ]
            )
        ];
    }
}
