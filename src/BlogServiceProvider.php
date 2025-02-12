<?php

namespace Sokeio\Blog;

use Illuminate\Support\ServiceProvider;
use Sokeio\Blog\Models\Catalog;
use Sokeio\Blog\Models\Post;
use Sokeio\Blog\Models\Tag;
use Sokeio\ServicePackage;
use Sokeio\Core\Concerns\WithServiceProvider;
use Sokeio\Enums\AlertType;
use Sokeio\Page\Enums\UIKey;
use Sokeio\UI\Common\Button;
use Sokeio\UI\Common\Card;
use Sokeio\UI\Field\Input;
use Sokeio\UI\Field\MediaIcon;
use Sokeio\UI\Field\Select;
use Sokeio\UI\SoUI;

class BlogServiceProvider extends ServiceProvider
{
    use WithServiceProvider;

    public function configurePackage(ServicePackage $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         */
        $package
            ->name('sokeio-blog')
            ->hasConfigFile()
            ->hasViews()
            ->hasHelpers()
            ->hasAssets()
            ->hasTranslations()
            ->runsMigrations();
    }
    public function packageRegistered()
    {
        // packageRegistered
    }

    public function packageBooted()
    {
        // packageBooted

        SoUI::registerUI(
            [
                Input::make('name')->label('Name'),
                MediaIcon::make('icon')->label('Icon'),
                Select::make('menuable_id')->remoteActionWithModel(Post::class, 'title')->label('Choose Post'),
                Button::make()->boot(function (Button $button) {
                    if ($button->getValueByKey('id')) {
                        $button->label('Update')
                            ->icon('ti ti-check')
                            ->className('btn btn-success p-2 mt-1');
                    } else {
                        $button->label(__('Add to menu'))
                            ->icon('ti ti-plus')
                            ->className('btn btn-primary p-2 mt-1');
                    }
                })
                    ->wireClick(function (Button $button) {
                        $button->resetErrorBag();
                        $fail = false;
                        // if (!($button->getValueByKey('name'))) {
                        //     $fail = true;
                        //     $button->addError('name', 'Name is required');
                        // }
                        if (!($button->getValueByKey('menuable_id'))) {
                            $fail = true;
                            $button->addError('menuable_id', 'Post is required');
                        }
                        // if (!($button->getValueByKey('icon'))) {
                        //     $fail = true;
                        //     $button->addError('icon', 'Icon is required');
                        // }
                        if ($fail) {
                            return;
                        }
                        $id = $button->getValueByKey('id');
                        $button->getWire()->updateItemMenu(
                            $id,
                            function ($menuItem) use ($button) {
                                $menuItem->name = $button->getValueByKey('name');
                                $menuItem->menuable_type = Post::class;
                                $menuItem->menuable_id = $button->getValueByKey('menuable_id');
                                $menuItem->icon = $button->getValueByKey('icon');
                                $menuItem->type = 'post';
                            }
                        );
                        $button->wireAlert(
                            $button->getValueByKey('name') . ' has been saved!',
                            'Menu',
                            AlertType::SUCCESS
                        );
                        if (!$id) {
                            $button->changeValue('name', '');
                            $button->changeValue('menuable_id', '');
                            $button->changeValue('icon', '');
                        }
                    })
                    ->when(function (Button $button) {
                        return $button->getWire()->menuId;
                    }),
                Button::make()->label('Remove')
                    ->icon('ti ti-trash')
                    ->className('btn btn-danger p-2 ms-2 mt-1')
                    ->confirm('Are you really want to remove?')
                    ->wireClick(function (Button $button) {
                        $id = $button->getValueByKey('id');
                        $button->getWire()->removeItemMenu($id);
                    })->when(function (Button $button) {
                        return $button->getValueByKey('id');
                    })
            ],
            UIKey::MENU_ITEM_TYPE->value . 'post',
            UIKey::MENU_ADD_ITEM->value,
            fn(Card $card) => $card->title('Posts')->className('mb-2')->hideBody()
                ->boot(function (Card $card) {
                    $card->groupField(null);
                    if (!$card->getValueByKey('id')) {
                        $card->groupField('posts');
                    }
                })
        );
        SoUI::registerUI(
            [
                Input::make('name')->label('Name'),
                MediaIcon::make('icon')->label('Icon'),
                Select::make('menuable_id')->remoteActionWithModel(Catalog::class, 'title')
                    ->label('Choose Catalog'),
                Button::make()
                    ->boot(function (Button $button) {
                        if ($button->getValueByKey('id')) {
                            $button->label('Update')
                                ->icon('ti ti-check')
                                ->className('btn btn-success p-2 mt-1');
                        } else {
                            $button->label(__('Add to menu'))
                                ->icon('ti ti-plus')
                                ->className('btn btn-primary p-2 mt-1');
                        }
                    })

                    ->wireClick(function (Button $button) {
                        $button->resetErrorBag();
                        $fail = false;
                        // if (!($button->getValueByKey('name'))) {
                        //     $fail = true;
                        //     $button->addError('name', 'Name is required');
                        // }
                        if (!($button->getValueByKey('menuable_id'))) {
                            $fail = true;
                            $button->addError('menuable_id', 'Catalog is required');
                        }
                        // if (!($button->getValueByKey('icon'))) {
                        //     $fail = true;
                        //     $button->addError('icon', 'Icon is required');
                        // }
                        if ($fail) {
                            return;
                        }
                        $id = $button->getValueByKey('id');
                        $button->getWire()->updateItemMenu(
                            $id,
                            function ($menuItem) use ($button) {
                                $menuItem->name = $button->getValueByKey('name');
                                $menuItem->menuable_type = Catalog::class;
                                $menuItem->menuable_id = $button->getValueByKey('menuable_id');
                                $menuItem->icon = $button->getValueByKey('icon');
                                $menuItem->type = 'catalog';
                            }
                        );
                        $button->wireAlert(
                            $button->getValueByKey('name') . ' has been saved!',
                            'Menu',
                            AlertType::SUCCESS
                        );
                        if (!$id) {
                            $button->changeValue('name', '');
                            $button->changeValue('menuable_id', '');
                            $button->changeValue('icon', '');
                        }
                    })
                    ->when(function (Button $button) {
                        return $button->getWire()->menuId;
                    }),
                Button::make()->label('Remove')
                    ->icon('ti ti-trash')
                    ->className('btn btn-danger p-2 ms-2 mt-1')
                    ->confirm('Are you really want to remove?')
                    ->wireClick(function (Button $button) {
                        $id = $button->getValueByKey('id');
                        $button->getWire()->removeItemMenu($id);
                    })->when(function (Button $button) {
                        return $button->getValueByKey('id');
                    })
            ],
            UIKey::MENU_ITEM_TYPE->value . 'catalog',
            UIKey::MENU_ADD_ITEM->value,
            fn(Card $card) => $card->title('Catalogs')->className('mb-2')->hideBody()
                ->boot(function (Card $card) {
                    $card->groupField(null);
                    if (!$card->getValueByKey('id')) {
                        $card->groupField('catalogs');
                    }
                })
        );
        SoUI::registerUI(
            [
                Input::make('name')->label('Name'),
                MediaIcon::make('icon')->label('Icon'),
                Select::make('menuable_id')->remoteActionWithModel(Tag::class, 'title')->label('Choose Tag'),
                Button::make()->boot(function (Button $button) {
                    if ($button->getValueByKey('id')) {
                        $button->label('Update')
                            ->icon('ti ti-check')
                            ->className('btn btn-success p-2 mt-1');
                    } else {
                        $button->label(__('Add to menu'))
                            ->icon('ti ti-plus')
                            ->className('btn btn-primary p-2 mt-1');
                    }
                })
                    ->wireClick(function (Button $button) {
                        $button->resetErrorBag();
                        $fail = false;
                        // if (!($button->getValueByKey('name'))) {
                        //     $fail = true;
                        //     $button->addError('name', 'Name is required');
                        // }
                        if (!($button->getValueByKey('menuable_id'))) {
                            $fail = true;
                            $button->addError('menuable_id', 'Tag is required');
                        }
                        // if (!($button->getValueByKey('icon'))) {
                        //     $fail = true;
                        //     $button->addError('icon', 'Icon is required');
                        // }
                        if ($fail) {
                            return;
                        }
                        $id = $button->getValueByKey('id');
                        $button->getWire()->updateItemMenu(
                            $id,
                            function ($menuItem) use ($button) {
                                $menuItem->name = $button->getValueByKey('name');
                                $menuItem->menuable_type = Tag::class;
                                $menuItem->menuable_id = $button->getValueByKey('menuable_id');
                                $menuItem->icon = $button->getValueByKey('icon');
                                $menuItem->type = 'tag';
                            }
                        );
                        $button->wireAlert(
                            $button->getValueByKey('name') . ' has been saved!',
                            'Menu',
                            AlertType::SUCCESS
                        );
                        if (!$id) {
                            $button->changeValue('name', '');
                            $button->changeValue('menuable_id', '');
                            $button->changeValue('icon', '');
                        }
                    })
                    ->when(function (Button $button) {
                        return $button->getWire()->menuId;
                    }),
                Button::make()->label('Remove')
                    ->icon('ti ti-trash')
                    ->className('btn btn-danger p-2 ms-2 mt-1')
                    ->confirm('Are you really want to remove?')
                    ->wireClick(function (Button $button) {
                        $id = $button->getValueByKey('id');
                        $button->getWire()->removeItemMenu($id);
                    })->when(function (Button $button) {
                        return $button->getValueByKey('id');
                    })
            ],
            UIKey::MENU_ITEM_TYPE->value . 'tag',
            UIKey::MENU_ADD_ITEM->value,
            fn(Card $card) => $card->title('Tags')->className('mb-2')->hideBody()
                ->boot(function (Card $card) {
                    $card->groupField(null);
                    if (!$card->getValueByKey('id')) {
                        $card->groupField('tags');
                    }
                })
        );
    }
}
