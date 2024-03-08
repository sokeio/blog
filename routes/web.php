<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use Sokeio\Blog\Livewire\CatalogPageView;
use Sokeio\Blog\Livewire\PostPageView;
use Sokeio\Blog\Livewire\TagPageView;

permalinkRoute('post_permalink', 'post/{post}', PostPageView::class, 'post.slug');
permalinkRoute('catalog_permalink', 'catalog/{catalog}', CatalogPageView::class, 'catalog.slug');
permalinkRoute('tag_permalink', 'tag/{tag}', TagPageView::class, 'tag.slug');
