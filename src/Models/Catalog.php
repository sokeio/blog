<?php

namespace Sokeio\Blog\Models;

use Sokeio\Model;
use Sokeio\Concerns\WithSlug;
use Sokeio\Seo\HasSEO;

class Catalog extends Model
{
    use WithSlug, HasSEO;

    public function getSeoCanonicalUrl()
    {
        return route('catalog.slug', ['catalog' => $this->slug]);
    }
    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'title',
        'description',
        'image',
        'views',
        'status',
        'author_id',
        'icon',
        'order',
        'is_featured',
        'is_default',
        'layout',
        'data',
        'js',
        'css',
        'custom_js',
        'custom_css',
        'updated_at',
        'created_at'
    ];
    public function posts()
    {
        return $this->belongsToMany(Post::class, 'post_catalogs', 'catalog_id', 'post_id');
    }
}
