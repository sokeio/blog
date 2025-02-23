<?php

namespace Sokeio\Blog\Models;

use Sokeio\Model;
use Sokeio\Page\Enums\PublishedType;
use Sokeio\Page\WithSluggable;

class Catalog extends Model
{
    use WithSluggable;
    public function getRouteName()
    {
        return 'site.catalog';
    }
    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'main_id',
        'locale',
        'title',
        'description',
        'image',
        'published_type',
        'published_at',
        'template',
        'custom_js',
        'custom_css',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'published_at' => 'datetime',
        'published_type' => PublishedType::class
    ];
    public function posts()
    {
        return $this->belongsToMany(Post::class, 'post_catalogs', 'catalog_id', 'post_id');
    }
}
