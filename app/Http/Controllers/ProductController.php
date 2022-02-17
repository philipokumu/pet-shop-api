<?php

namespace App\Http\Controllers;

use App\Http\Resources\Product as ProductResource;
use App\Http\Resources\ProductCollection;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::paginate(10);
        return new ProductCollection($products);
    }

    public function show($uuid)
    {
        $product = Product::where('uuid',$uuid)->first();

        return new ProductResource($product);
    }
}
