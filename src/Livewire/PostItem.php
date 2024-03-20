<?php

namespace Sokeio\Blog\Livewire;

use Sokeio\Blog\Models\Post;
use Sokeio\Component;

class PostItem extends Component
{
    public Post $post;
    public function render()
    {
        return viewScope('blog::post-item-view');
    }
}
