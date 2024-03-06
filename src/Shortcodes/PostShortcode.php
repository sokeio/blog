<?php

namespace Sokeio\Blog\Shortcodes;

use Sokeio\Blog\Models\Catalog;
use Sokeio\Shortcode\WithShortcode;
use Sokeio\Component;
use Sokeio\Components\UI;
use Sokeio\Concerns\WithLoadMore;

class PostShortcode extends Component
{
    use WithShortcode;
    use WithLoadMore {
        loadMore as loadMoreTrait;
    }
    public static function getTitle()
    {
        return __('blog::shortcode.post');
    }
    public static function getKey()
    {
        return 'blog::post';
    }
    public static function getParamUI()
    {
        return [
            UI::Text('title')->Label(__('Title'))->NoSort(),
            UI::Text('keywords')->Label(__('Keywords(comma separated)'))->NoSort(),
            UI::Select('catalog_id')->Label(__('Catalog'))->DataSource(function () {
                return Catalog::all()->map(function ($item) {
                    return [
                        'id' => $item->id,
                        'name' => $item->name
                    ];
                });
            }),
            UI::Number('limit')->Label(__('Limit'))->NoSort(),
            UI::Checkbox('is_load_more')->Label(__('Use Load More'))->NoSort(),
            UI::Checkbox('is_container')->Label(__('Use Container'))->NoSort(),
        ];
    }
    public $title;
    public $order_by;
    public $limit;
    public $is_container;
    public $is_load_more;
    public $keywords;
    public $catalog_id;
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
        if ($this->catalog_id) {
            $query->where('catalog_id', $this->catalog_id);
        }
        if ($this->keywords) {
            $arrKeywords = explode(',', $this->keywords);
            $query->where(function ($query) use ($arrKeywords) {
                foreach ($arrKeywords as $key) {
                    $query->orWhere('name', 'like', '%' . $key . '%');
                    $query->orWhere('description', 'like', '%' . $key . '%');
                }
            });
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
