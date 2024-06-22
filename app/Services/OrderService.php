<?php

namespace App\Services;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Exception;

class OrderService
{
    public function getAllOrders($status = null)
    {
        return Order::when($status, function ($query, $status) {
            return $query->where('status', $status);
        })->orderBy('status')->get();
    }

    public function createOrder( $request)
    {
        return DB::transaction(function () use ($request) {
            $order = Order::firstOrNew([
                'user_id' => $request->user_id,
                'product_id' => $request->product_id,
            ]);

            if ($order->exists) {
                $order->quantity += $request->quantity;
            } else {
                $product = Product::find($request->product_id);
                if ($product->quantity < $request->quantity) {
                    throw new Exception('Not enough product quantity');
                }
                $product->decrement('quantity', $request->quantity);

                $order->quantity = $request->quantity;
                $order->status = 'waiting';
            }

            $order->save();

            event(new \App\Events\OrderCreated($order));

            return $order;
        });
    }

    public function updateOrder( $request, Order $order)
    {
        if (Gate::denies('update', $order)) {
            throw new Exception('Unauthorized');
        }

        return DB::transaction(function () use ($request, $order) {
            if ($order->status === 'waiting') {
                $product = Product::find($order->product_id);

                if (!$product) {
                    throw new Exception('Product not found');
                }

                $product->increment('quantity', $order->quantity);

                if ($product->quantity < $request->quantity) {
                    throw new Exception('Not enough product quantity');
                }

                $product->decrement('quantity', $request->quantity);

                $order->quantity = $request->quantity;
                $order->save();
            }

            return $order;
        });
    }

    public function deleteOrder(Order $order)
    {
        if (Gate::denies('delete', $order)) {
            throw new Exception('Unauthorized');
        }

        return DB::transaction(function () use ($order) {
            if ($order->status === 'waiting') {
                $product = Product::find($order->product_id);
                $product->increment('quantity', $order->quantity);
            }
            $order->delete();

            return true;
        });
    }
}
