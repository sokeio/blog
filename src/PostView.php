<?php

namespace Sokeio\Blog;

use Sokeio\Blog\Models\Post;
use Sokeio\Page\Models\Slug;
use Sokeio\Theme;

// #[PageInfo(
//     route:'site.post',
//     url: 'post/{slug}',
// )]
class PostView extends \Sokeio\Page
{
    public $slug;

    public function render()
    {
        $item = null;
        if ($this->slug) {
            $item =  Slug::findSluggableBySlug($this->slug, Post::class);
            Theme::title($item?->title);
            Theme::description($item?->description);
        }
        if (!$item) {
            return abort(404);
        }
        echo $item->template;
        return Theme::view('sokeio-blog::pages.post.view', [
            'item' => $item
        ], [], false, $item->template);
    }
}
