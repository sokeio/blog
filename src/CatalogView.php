<?php

namespace Sokeio\Blog;

use Sokeio\Blog\Models\Catalog;
use Sokeio\Page\Models\Slug;
use Sokeio\Theme;

// #[PageInfo(
//     route:'site.catalog',
//     url: 'catalog/{slug?}',
// )]
class CatalogView extends \Sokeio\Page
{
    public $slug;

    public function render()
    {
        $item = null;
        if ($this->slug) {
            $item =  Slug::findSluggableBySlug($this->slug, Catalog::class);

            Theme::title($item?->title);
            Theme::description($item?->description);
        }
        if (!$item) {
            return abort(404);
        }
        return Theme::view('sokeio-blog::pages.catalog.view', [
            'item' => $item
        ], [], false, $item->template);
    }
}
