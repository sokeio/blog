<?php

namespace Sokeio\Blog\Shortcodes;

use Sokeio\Blog\Models\Catalog;
use Sokeio\Shortcode\WithShortcode;
use Sokeio\Component;
use Sokeio\Components\UI;
use Sokeio\Concerns\WithLoadMore;

class CatalogShortcode extends Component
{
    use WithShortcode;
    use WithLoadMore {
        loadMore as loadMoreTrait;
    }
    public static function getShortcodeName()
    {
        return __('blog::shortcode.catalog');
    }
    public static function getShortcodeKey()
    {
        return 'blog::catalog';
    }
    public static function getShortcodeParamUI()
    {
        return [
            UI::Text('title')->Label(__('Title'))->NoSort(),
            UI::Number('limit')->Label(__('Limit'))->NoSort(),
            UI::Checkbox('is_load_more')->Label(__('Use Load More'))->NoSort(),
            UI::Checkbox('is_container')->Label(__('Use Container'))->NoSort(),
        ];
    }
    public static function EnableContent()
    {
        return false;
    }
    
    public $title;
    public $order_by;
    public $limit;
    public $is_container;
    public $is_load_more;
    public $keywords;
    protected function getQuery()
    {
        $query = Catalog::query();
        switch ($this->order_by) {
            case 'view_count':
                $query->with('views', function ($query) {
                    $query->orderBy('count', 'desc');
                });
                break;
            case 'newest':
                $query->orderBy('created_at', 'desc');
                break;
        }
        if (!$this->is_load_more) {
            if ($this->limit) {
                $query->limit($this->limit);
            } else {
                $query->limit(12);
            }
        }
        if ($this->keywords) {
            $arrKeywords = explode(',', $this->keywords);
            foreach ($arrKeywords as $key) {
                $query->orWhere('name', 'like', '%' . $key . '%');
                $query->orWhere('description', 'like', '%' . $key . '%');
            }
        }
        return $query;
    }

    public function loadMore()
    {
        if ($this->is_load_more) {
            $this->loadMoreTrait();
            return;
        }
        $query = $this->getQuery();
        $this->dataItems = $query->get();
    }
    public function mount()
    {
        $this->loadMore();
    }
    public function render()
    {
        return view('blog::shortcodes.catalog');
    }
}
