<?php

namespace Sokeio\Blog;

use Sokeio\Blog\Models\Tag;
use Sokeio\Page\Models\Slug;
use Sokeio\Theme;

// #[PageInfo(
//     route:'site.tag',
//     url: 'tag/{slug?}',
// )]
class TagView extends \Sokeio\Page
{
    public $slug;

    public function render()
    {
        $item = null;
        if ($this->slug) {
            $item =  Slug::findSluggableBySlug($this->slug, Tag::class);

            Theme::title($item?->title);
            Theme::description($item?->description);
        }
        if (!$item) {
            return abort(404);
        }
        return Theme::view('sokeio-blog::pages.tag.view', [
            'item' => $item
        ], [], false, $item->template);
    }
}
