<?php

namespace Sokeio\Blog\Page\Blog\Catalog;

use Sokeio\Blog\Models\Catalog;
use Sokeio\Core\Attribute\AdminPageInfo;
use Sokeio\UI\Common\Button;
use Sokeio\UI\PageUI;
use Sokeio\UI\Table\Column;
use Sokeio\UI\Table\Table;
use Sokeio\UI\WithUI;

#[AdminPageInfo(
    title: 'Catalog',
    menu: true,
    menuTitle: 'Catalog',
    sort: 2,
    model: Catalog::class,
    icon: 'ti ti-library',
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
                        ->columnGroup('published', 'Published')
                        ->column(Column::make('title')->enableLink())
                        ->column('description')
                        ->column(Column::make('published_type')->columnGroup('published'))
                        ->column(Column::make('published_at')->columnGroup('published'))
                        ->column('template')
                        ->query($this->getQuery())
                        ->enableIndex()
                        ->searchbox(['title', 'description'])
                        ->columnAction([
                            Button::make()->label(__('Edit'))->className('btn btn-primary btn-sm ')
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
