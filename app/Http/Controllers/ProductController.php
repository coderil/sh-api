<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\Product\IndexProductRequest;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\ {
    AllowedFilter,
    QueryBuilder
};


class ProductController extends Controller
{
    public function index(IndexProductRequest $request) {

        $perPage = $request->input('perPage', 5);

        $productsQuery = QueryBuilder::for(Product::class)
                        ->allowedFilters([
                            'name',
                            AllowedFilter::callback('minPrice', function(Builder $query, $value) {
                                $query->where('base_price', '>', $value);
                            }),
                            AllowedFilter::callback('maxPrice', function(Builder $query, $value) {
                                $query->where('base_price', '<', $value);
                            }),
                            AllowedFilter::partial('locations', 'shop.location')
                        ]);

        $paginated = $productsQuery->paginate($perPage);

        if (! $paginated->count()) {
            return $this->success('No products available');
        };

        $pagination = [
            'current_page' => $paginated->currentPage(),
            'last_page' => $paginated->lastPage(),
            'per_page' => $paginated->perPage(),
            'total' => $paginated->total(),
            'prev_page_url' => $paginated->previousPageUrl(),
            'next_page_url' => $paginated->nextPageUrl(),
        ];
        
        return $this->success('Products fetched successfully', 
            [  
                'products' => ProductResource::collection($paginated),
                'pagination' => $pagination
            ]);
    }

    public function show() {

    }

    public function store() {

    }

    public function update() {

    }

    public function destroy() {

    }
}
