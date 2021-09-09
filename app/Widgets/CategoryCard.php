<?php

namespace App\Widgets;

use App\Models\Department;
use Arrilot\Widgets\AbstractWidget;

class CategoryCard extends AbstractWidget
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
        $categories = Department::all();

        return view('widgets.category_card', [
            'categories' => $categories,
        ]);
    }
}
