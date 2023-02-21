<?php

namespace App\traits;


use App\Models\dictionary;
use App\Models\RequestHistory;
use Illuminate\Http\Request;



trait coincidenceDictionary {


    public function getAllData($name, $percentage )
    {
        try {
            $serializedName = $this->serializeString($name);
            $coincidencias = dictionary::cursor()->filter(function (dictionary $register) use ($serializedName, $percentage) {
                similar_text($serializedName,$this->serializeString($register->name),$porcentaje);
                $register->percentage=round($porcentaje);
                return ($porcentaje >= $percentage - 10  && $porcentaje <= $percentage);
            })->sortByDesc('percentage');

            return $coincidencias->values()->all();
        } catch (\Throwable $e) {
            return $e;
        }

    }

    public function serializeString($string){

        $string = iconv('UTF-8', 'utf-8//TRANSLIT', $string);
        $string = strtolower($string);
        return trim($string);
    }

    Public function saveRequest(Request $request, $response = []){
        try {
            RequestHistory::create([
                'request_name' => $request->name,
                'request_percentage' => $request->percentage,
                'response_data'=>json_encode($response)
            ]);
        }catch (\Throwable $e){
            return $e;
        }
    }
}
