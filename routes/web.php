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

use Sokeio\Blog\Livewire\CatalogView;
use Sokeio\Blog\Livewire\PostView;
use Sokeio\Blog\Livewire\TagView;

permalink_route('post_permalink', 'post/{post}', PostView::class, 'post.slug');
permalink_route('catalog_permalink', 'catalog/{catalog}', CatalogView::class, 'catalog.slug');
permalink_route('tag_permalink', 'tag/{tag}', TagView::class, 'tag.slug');
