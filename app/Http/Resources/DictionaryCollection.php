<?php

namespace App\Http\Resources;

use App\Models\RequestHistory;
use App\traits\coincidenceDictionary;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class DictionaryCollection extends ResourceCollection
{
    use coincidenceDictionary;
    public $statusCode;

    public function __construct($resource, $statusCode = 200)
    {
        parent::__construct($resource);
        $this->statusCode = $statusCode;
    }
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        try {
            $response = [
                'data' => $this->collection,
                'message' => $this->collection->count() > 1 ? 'Exitoso con Resultados' : 'Exitoso sin Resultados',
                'status' => $this->statusCode
            ];
            $this->saveRequest($request,$response);
        } catch (\Throwable $e) {
            $this->statusCode = 500;
            $response = [
                'data' =>[],
                'error' => 'Error' . $e->getMessage(),
                'status' => $this->statusCode
            ];
            $this->saveRequest($request,$response);
        }

        return $response;
    }

    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\JsonResponse|object
     */
    public function toResponse($request)
    {
        return parent::toResponse($request)->setStatusCode($this->statusCode);
    }
}
