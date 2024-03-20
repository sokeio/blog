<?php

namespace Sokeio\Blog\Livewire;

use Sokeio\Blog\Models\Post;
use Sokeio\Component;

class PostPageView extends Component
{
    public Post $post;
    public function mount()
    {
        breadcrumb()->add(__('Home'), url(''));
        $this->post->setAssets();
    }
    public function render()
    {
        return viewScope('blog::post.' . $this->post->view_layout, ['post' => $this->post], 'blog::post.default');
    }
}
