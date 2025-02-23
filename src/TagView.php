<?php

namespace Sokeio\Blog;

use Sokeio\Blog\Models\Tag;
use Sokeio\Page\Models\Slug;
use Sokeio\Page\WithSlugRender;
use Sokeio\Theme;

// #[PageInfo(
//     route:'site.tag',
//     url: 'tag/{slug?}',
//     model: \Sokeio\Blog\Models\Tag::class
// )]
class TagView extends \Sokeio\Page
{
    use WithSlugRender;
    protected $slugView = 'sokeio-blog::pages.tag.view';
}
