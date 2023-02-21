<?php

namespace App\Http\Controllers;

use App\Http\Resources\DictionaryCollection;
use App\Models\RequestHistory;
use App\traits\coincidenceDictionary;
use Illuminate\Http\Request;

class dataCoincidenceController extends Controller
{
    use coincidenceDictionary;
    public function getCoincidenceFromDictionary(Request $request): DictionaryCollection
    {
        return new DictionaryCollection($this->getAllData($request['name'],$request['percentage']));
    }

    public function getHistory(): \Illuminate\Http\JsonResponse
    {
        try {
            return response()->json(['data'=>RequestHistory::all()->toArray()],200);
        }catch (\Throwable $e){
            return response()->json(['error'=>$e->getMessage()],500);
        }

    }
}
