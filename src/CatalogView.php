<?php

namespace Sokeio\Blog;

use Sokeio\Page\WithSlugRender;

// #[PageInfo(
//     route:'site.catalog',
//     url: 'catalog/{slug?}',
//     model: \Sokeio\Blog\Models\Catalog::class
// )]
class CatalogView extends \Sokeio\Page
{
    use WithSlugRender;
    protected $slugView = 'sokeio-blog::pages.catalog.view';
}
