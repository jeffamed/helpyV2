<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\CustomField;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function dashboard()
    {
        $departments = Department::all();
        $idCustom = CustomField::where('name','Issue Type')->first();
        $idType = CustomField::where('name','Type')->first();
        $options = $idCustom->options;
        $optType = $idType->options;

        return view('dashboard.index', compact('departments','options','optType'));

    }
}
