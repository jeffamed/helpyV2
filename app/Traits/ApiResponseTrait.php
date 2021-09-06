<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

trait ApiResponseTrait 
{
    private function successReponse($data, $code){
        return response()->json($data,$code);
    }

    protected function errorResponse($data, $code){
        return response()->json(['error' => $data], $code);
    }

    protected function showAll(Collection $collection, $code = 200){
        return $this->successReponse(["data" => $collection], $code);
    }

    protected function ShowOne(Model $instance, $code = 200){
        return $this->successReponse(['data' => $instance], $code);
    }
}