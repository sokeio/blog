<?php

namespace Sokeio\Blog\Page\Blog\Post;

use Sokeio\Blog\Models\Post;
use Sokeio\Core\Attribute\AdminPageInfo;
use Sokeio\UI\Common\Button;
use Sokeio\UI\PageUI;
use Sokeio\UI\Table\ButtonEditable;
use Sokeio\UI\Table\Column;
use Sokeio\UI\Table\Table;
use Sokeio\UI\WithTableEditlineUI;

#[AdminPageInfo(
    title: 'Post',
    menu: true,
    menuTitle: 'Post',
    menuTargetSort: 10,
    model: Post::class,
    icon: 'ti ti-article',
    sort: 1
)]
class Index extends \Sokeio\Page
{
    use WithTableEditlineUI;
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
                        ->searchbox(['title', 'description', 'content'])
                        ->columnAction([
                            Button::make()->label(__('Edit'))->className('btn btn-success btn-sm ')
                                ->modal(function (Button $button) {
                                    return route($this->getRouteName('edit'), [
                                        'dataId' =>
                                        $button->getParams('row')->id
                                    ]);
                                }, 'Edit ' . $this->getPageConfig()->getTitle(), 'xl', 'ti ti-pencil'),
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
                                    'xxl',
                                    'ti ti-plus'
                                )
                        ])
                ]
            )
        ];
    }
}
