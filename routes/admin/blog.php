<?php

use Illuminate\Support\Facades\Route;
use Sokeio\Blog\Livewire\Catalog\CatalogForm;
use Sokeio\Blog\Livewire\Catalog\CatalogTable;
use Sokeio\Blog\Livewire\Post\PostForm;
use Sokeio\Blog\Livewire\Post\PostTable;
use Sokeio\Blog\Livewire\Tag\TagForm;
use Sokeio\Blog\Livewire\Tag\TagTable;
use Sokeio\Blog\PostBuilder;

Route::group(['as' => 'admin.'], function () {
    routeCrud('catalog', CatalogTable::class, CatalogForm::class);
    routeCrud('tag', TagTable::class, TagForm::class);
    routeCrud('post', PostTable::class, PostForm::class);
    if (postWithBuilder()) {
        Route::get('post/create-builder', PostBuilder::class)->name('post.create-builder');
        Route::get('post/{dataId}/edit-builder', PostBuilder::class)->name('post.edit-builder');
    }
});
