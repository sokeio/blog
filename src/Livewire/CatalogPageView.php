<?php

namespace Sokeio\Blog\Livewire;

use Sokeio\Blog\Models\Catalog;
use Sokeio\Component;

class CatalogPageView extends Component
{
    public Catalog $catalog;
    public function render()
    {
        return viewScope('blog::catalog-page-view', ['catalog' => $this->catalog]);
    }
}
