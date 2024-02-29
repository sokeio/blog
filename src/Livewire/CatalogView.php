<?php

namespace Sokeio\Content\Livewire;

use Sokeio\Content\Models\Catalog;
use Sokeio\Component;

class CatalogView extends Component
{
    public Catalog $catalog;
    public function render()
    {
        return view_scope('content::catalog-view', ['catalog' => $this->catalog]);
    }
}
