<?php

namespace Sokeio\Blog\Livewire;

use Sokeio\Blog\Models\Catalog;
use Sokeio\Component;

class CatalogView extends Component
{
    public Catalog $catalog;
    public function render()
    {
        return view_scope('blog::catalog-view', ['catalog' => $this->catalog]);
    }
}
