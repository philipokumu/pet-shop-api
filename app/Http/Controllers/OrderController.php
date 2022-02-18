<?php

namespace App\Http\Controllers;

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
        $payment = Payment::where('uuid',$request->payment_uuid)->first();
        $order_status = OrderStatus::where('uuid',$request->order_status_uuid)->first();
        $requested_products = collect($request->products);

        // Fetch requested products details from db
        $db_products_based_on_uuid = Product::whereIn('uuid',$requested_products->pluck('product_uuid'))->get();

        // Compute total price per requested product
        $with_pricing_product_array = $requested_products->map(function ($product) use ($db_products_based_on_uuid){
            $product['price'] = $db_products_based_on_uuid->where('uuid', $product['product_uuid'])->first()->price;
            $product['total_price'] = $product['quantity'] * $product['price'];
            return $product;
        });

        // Get total amount payable
        $amount = $with_pricing_product_array->reduce(function ($carry, $product) {
            return $carry + $product['total_price'];
        }, 0);

        // Business logic | service
        $order = Order::create([
            'payment_id'=> $payment->id,
            'order_status_id'=> $order_status->id,
            'address' => $request->address,
            'amount' => $amount,
            'user_id' => auth()->id(),
            'products' => json_encode($request->products),
            'delivery_fee' => 200 // for testing logic purposes
        ]);
        
        return new OrderResource($order);
    }

}
