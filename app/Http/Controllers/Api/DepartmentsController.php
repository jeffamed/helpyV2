<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\Request;

class DepartmentsController extends Controller
{
    use ApiResponseTrait;

    public function index()
    {
        $departments = Department::all(['id','title','description']);
        return $this->showAll($departments);

    }
}
