<?php

namespace Sokeio\Blog\Models;

use Illuminate\Database\Eloquent\Model;
use Sokeio\Comment\Concerns\Commentable;
use Sokeio\Concerns\WithSlug;
use Sokeio\Seo\HasSEO;

class Post extends Model
{
    use WithSlug, HasSEO, Commentable;
    public function getSeoCanonicalUrl()
    {
        return route('post.slug', ['post' => $this->slug]);
    }
    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'slug',
        'description',
        'content',
        'image',
        'views',
        'status',
        'author_id',
        'published_at',
        'lock_password',
        'app_before',
        'app_after',
        'layout',
        'data',
        'js',
        'css',
        'custom_js',
        'custom_css',
        'updated_at',
        'created_at'
    ];
    public function catalogs()
    {
        return $this->belongsToMany(Catalog::class, 'post_categories', 'post_id', 'category_id');
    }
    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'post_tags', 'post_id', 'tag_id');
    }
}
