<?php

namespace  App\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Validator;

trait ApiResponder
{
    private function successResponse($data, $status)
    {
        return response()->json(['message' => $data, 'status' => $status], $status);
    }

    protected function errorResponse($message, $status)
    {
        return response()->json(['error' => $message, 'status' => $status], $status);
    }

    protected function showAll(Collection $collection, $status = 200)
    {
        if ($collection->isEmpty()) {
            return $this->successResponse($collection, $status);
        }

        //Temp!
        return response()->json(['message' => $collection, 'status' => $status]);
        $transformer = $collection->first()->transformer;

        $collection = $this->sortData($collection);
        $collection = $this->paginate($collection);
        $collection = $this->transformData($collection, $transformer);
        $collection = $this->cacheResponse($collection);

        return $this->successResponse($collection, $status);
    }

    protected function showOne(Model $instance, $status = 200)
    {
        $transformer = $instance->transformer;
        $instance = $this->transformData($instance, $transformer);

        return $this->successResponse($instance, $status);
    }

    protected function showMessage($message, $status = 200)
    {
        return $this->successResponse($message, $status);
    }

    protected function sortData(Collection $collection)
    {
        if(request()->has('sort_by')) {
            $attribute = request()->sort_by;

            $collection = $collection->sortBy($attribute);
        }

        return $collection;
    }

    protected function paginate(Collection $collection)
    {
        $rules = [
            'per_page' => 'integer|min:2|max:50',
        ];

        Validator::validate(request()->all(), $rules);

        $page = LengthAwarePaginator::resolveCurrentPage();

        $perPage = 15;
        if (request()->has('per_page')) {
            $perPage = (int)request()->per_page;
        }

        $results = $collection->slice(($page - 1) * $perPage, $perPage);

        $paginated = new LengthAwarePaginator($results, $collection->count(), $perPage, $page, [
            'path' => LengthAwarePaginator::resolveCurrentPage()
        ]);

        $paginated->appends(request()->all());

        return $paginated;
    }

    protected function transformData($data, $transformer)
    {
        $transformation = fractal($data, new $transformer);
        return $transformation->toArray();
    }

    protected function cacheResponse($data)
    {
        $url = request()->url();
        $queryParams = request()->query();

        ksort($queryParams);

        $queryString = http_build_query($queryParams);

        $fullUrl = "{$url}?{$queryString}";

        return Cache::remember($fullUrl, 30, function() use($data) {
            return $data;
        });
    }
}
