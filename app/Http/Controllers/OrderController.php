<?php

namespace App\Http\Controllers;

use App\Exceptions\AuthorizationErrorException;
use App\Exceptions\OrderNotFoundException;
use App\Http\Requests\OrderRequest;
use App\Http\Resources\Order as OrderResource;
use App\Models\Order;
use App\Models\OrderStatus;
use App\Models\Payment;
use App\Models\Product;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function create(OrderRequest $request)
    {
        $requested_products = collect($request->products);

        // Basic db validation
        try {
            $payment = Payment::where('uuid',$request->payment_uuid)->firstOrFail();
            $order_status = OrderStatus::where('uuid',$request->order_status_uuid)->firstOrFail();
            foreach ($request->products as $requested_product) {
                
                $product = Product::where('uuid',$requested_product['uuid'])->firstOrFail();
            }

        } catch (\Throwable $e) {
            throw new OrderNotFoundException();
        }

        // Collection of products selected from db
        $db_products_based_on_uuid = Product::whereIn('uuid',$requested_products->pluck('uuid'))->get();

        // Compute total price per requested product
        $with_pricing_product_array = $requested_products->map(function ($product) use ($db_products_based_on_uuid){
            $product['price'] = $db_products_based_on_uuid->where('uuid', $product['uuid'])->first()->price;
            $product['total_price'] = $product['quantity'] * $product['price'];
            return $product;
        });

        // Get total amount payable
        $amount = $with_pricing_product_array->reduce(function ($carry, $product) {
            return $carry + $product['total_price'];
        }, 0);
        
        // Business logic | service
        $order = $request->user()->orders()->create([
            'payment_id'=> $payment->id,
            'order_status_id'=> $order_status->id,
            'address' => json_encode($request->address),
            'amount' => $amount,
            'user_id' => auth()->id(),
            'products' => json_encode($requested_products),
            'delivery_fee' => 200 // for testing logic purposes
        ]);

        return new OrderResource($order);
    }

}
