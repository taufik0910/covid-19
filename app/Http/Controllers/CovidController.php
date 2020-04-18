<?php

namespace App\Http\Controllers;

use App\Charts\CovidChart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class CovidController extends Controller
{
    //
public function chart()
{
    # code...
    $suspect =collect (http::get('https://api.kawalcorona.com/indonesia/provinsi')->json());
    //dd($suspect->flatten(1));
$suspectData =$suspect->flatten(1);
    $labels = $suspectData->pluck('Provinsi');
    $data = $suspectData->pluck('Kasus_Posi');
    $death = $suspectData->pluck('Kasus_Meni');
    $colors = $labels->map(function($item){
        return '#' . substr(md5(mt_rand()),0 ,6 );
    });

    $chart = new CovidChart;
    $chart ->labels($labels);
    $chart->dataset('data Kasus Positif Corona Di Indonesia','pie',$data, $death)->backgroundColor($colors);
    

    return view('coron',[
                'chart'=>$chart,
                ]);

}
}
