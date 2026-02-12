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
use App\Http\Requests\Product\StoreProductRequest;
use App\Http\Requests\Product\UpdateProductRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Product::class, 'product');    
    }

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

    public function show(Product $product) {
        return $this->success('Product fetched successfully', new ProductResource($product));
    }

    public function store(StoreProductRequest $request) {
        return DB::transaction(function() use ($request) {
            $userShop = $request->user()->shop;

            $product = $userShop->products()->create([
                'name' => $request->name,
                'description' => $request->description,
                'base_price' => $request->base_price,
                'stocks' => $request->stocks,
                'category' => $request->category,
            ]);

            return $this->success('Product created successfully', new ProductResource($product), 201);
        });
    }

    public function update(UpdateProductRequest $request, Product $product) {
        return DB::transaction(function() use ($request, $product) {
            $product->update([
                'name' => $request->name,
                'description' => $request->description,
                'base_price' => $request->base_price,
                'stocks' => $request->stocks,
                'category' => $request->category,
            ]);

            return $this->success('Product updated successfully', new ProductResource($product), 201);
        });
    }

    public function destroy(Product $product) {
        $product->delete();

        return $this->success('Product deleted sucessfully', 204);
    }
}
