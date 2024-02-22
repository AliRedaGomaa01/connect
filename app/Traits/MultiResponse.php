<?php 

namespace App\Traits;

trait MultiResponse {
    public function multiResponse($apiResponse , $bladeResponse = null){
        return request()->is('api/*') ? $apiResponse : $bladeResponse;
    }
}