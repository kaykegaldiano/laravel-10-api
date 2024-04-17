<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Http\Resources\ProductResource;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Http\Response;

class ProductController extends Controller
{
    public function index(): ResourceCollection
    {
        return ProductResource::collection(Product::all());
    }

    public function store(StoreProductRequest $request): Response|ResponseFactory
    {
        if ($request->method() !== 'POST') {
            return response(['error' => 'Method not allowed'], 405);
        }

        if ($request->isJson()) {
            Product::create([
               'name' => $request->name,
               'available_quantity' => $request->available_quantity,
               'price' => $request->price,
            ]);

            return response(['message' => 'Product created with success!'], 201);
        }

        return response(['error' => 'Content-type must be application/json'], 406);
    }

    public function show(Product $product): ProductResource
    {
        return new ProductResource($product);
    }

    public function update(UpdateProductRequest $request, Product $product): Response|ResponseFactory
    {
        if ($request->isJson()) {
            $product->update([
                'name' => $request->name,
                'available_quantity' => $request->available_quantity ?: $product->available_quantity,
                'price' => $request->price ?: $product->price,
            ]);

            return response(['message' => 'Product updated with success!'], 201);
        }

        return response(['error' => 'Content-type must be application/json'], 406);
    }

    public function destroy(Product $product): Response|ResponseFactory
    {
        $product->delete();
        return response(['message' => 'Product deleted with success!'], 201);
    }
}
