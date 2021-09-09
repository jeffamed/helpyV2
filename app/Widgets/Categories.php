<?php

namespace App\Widgets;

use App\Models\Department;
use Arrilot\Widgets\AbstractWidget;

class Categories extends AbstractWidget
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

        return view('widgets.categories', [
            'categories' => $categories,
        ]);
    }
}
