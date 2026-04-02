<?php

use App\dto;
use Illuminate\Support\Facades\Route;
use App\Test;
Route::get('/', function () {
    //return view('welcome');
});

Route::get("/test", function () {
    return $data=collect(Test::$data)->map(function($product) {
        return 
            new dto($product);
        
    });

});