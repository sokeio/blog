<?php

namespace Sokeio\Blog\Shortcodes;

use Sokeio\Blog\Models\Catalog;
use Sokeio\Blog\Models\Post;
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
            UI::text('title')->label(__('Title'))->NoSort(),
            UI::text('keywords')->label(__('Keywords(comma separated)'))->NoSort(),
            UI::select('catalogId')->label(__('Catalog'))->dataSource(function () {
                return [
                    ['id' => '', 'name' => __('All')],
                    ...Catalog::all()->map(function ($item) {
                        return [
                            'id' => $item->id,
                            'name' => $item->name
                        ];
                    })
                ];
            }),
            UI::text('classItem')->label(__('Class Item'))
                ->NoSort()->valueDefault('col-lg-4 col-md-6 col-sm-12 col-xs-12'),
            UI::number('limit')->label(__('Limit'))->NoSort(),
            UI::checkBox('isLoadMore')->label(__('Use Load More'))->NoSort(),
            UI::checkBox('isContainer')->label(__('Use Container'))->NoSort(),
        ];
    }
    public $title;
    public $orderby;
    public $limit;
    public $isContainer;
    public $isLoadMore;
    public $keywords;
    public $catalogId;
    public $classItem;
    protected function getQuery()
    {
        $query = Post::query();
        switch ($this->orderby) {
            case 'view_count':
                $query->with('views', function ($query) {
                    $query->orderBy('count', 'desc');
                });
                break;
            case 'newest':
                $query->orderBy('created_at', 'desc');
                break;
            default:
                break;
        }
        if (!$this->isLoadMore) {
            if ($this->limit) {
                $query->limit($this->limit);
            } else {
                $query->limit(12);
            }
        }
        if ($this->catalogId) {
            $query->where('catalogId', $this->catalogId);
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
        if ($this->isLoadMore) {
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
        return view('blog::shortcodes.post');
    }
}
