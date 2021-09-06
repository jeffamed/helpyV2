<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\CustomField;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\Request;

class CustomFieldController extends Controller
{
    use ApiResponseTrait;

    public function index()
    {
        $customs = CustomField::with('options:id,field_id,value')
                                ->select('id','name','type','required')
                                ->where('status',1)->get();
        return $this->showAll($customs);
    }
}
