<?php

namespace App\Widgets;

use App\Models\KnowledgeBase;
use Arrilot\Widgets\AbstractWidget;

class PopularArticles extends AbstractWidget
{
    /**
     * The configuration array.
     *
     * @var array
     */
    protected $config = [];

    /**
     * Treat this method as a controller action.
     * Return view() or other content to display.
     */
    public function run()
    {
        $posts = KnowledgeBase::orderBy('view_count', 'desc')->where('status',KnowledgeBase::PUBLISHED)->limit(10)->get();

        return view('widgets.popular_articles', [
            'posts' => $posts,
        ]);
    }
}
