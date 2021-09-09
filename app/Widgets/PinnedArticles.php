<?php

namespace App\Widgets;

use App\Models\KnowledgeBase;
use Arrilot\Widgets\AbstractWidget;

class PinnedArticles extends AbstractWidget
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
        $posts = KnowledgeBase::where('pinned', KnowledgeBase::PINNED)->where('status',KnowledgeBase::PUBLISHED)->latest()->limit(12)->get();

        return view('widgets.pinned_articles', [
            'posts' => $posts,
        ]);
    }
}
