<?php

namespace Sokeio\Blog\Models;

use Sokeio\Model;
use Sokeio\Page\WithSluggable;

class Tag extends Model
{
    use WithSluggable;
    public function getRouteName()
    {
        return 'site.tag';
    }
    protected $fillable = [
        'main_id',
        'locale',
        'title',
        'description',
        'image',
        'published',
        'updated_at',
        'created_at'
    ];
    public function posts()
    {
        return $this->belongsToMany(Post::class, 'post_tags', 'tag_id', 'post_id');
    }
}
