<?php

namespace Sokeio\Blog;

use Sokeio\Page\WithSlugRender;

// #[PageInfo(
//     route:'site.post',
//     url: 'post/{slug}',
//     model: \Sokeio\Blog\Models\Post::class
// )]
class PostView extends \Sokeio\Page
{
    use WithSlugRender;
    protected $slugView = 'sokeio-blog::pages.post.view';
}
