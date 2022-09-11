<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class OrderController extends Controller
{
    /**
     * Display a listing of the orders
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $orders = Order::all();
        foreach($orders as $order) {
            $user = $order->user()->first();
            $order->coustomer_name = $user->name;
        }

        return view('dashboard.orders.listing', compact('orders'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order)
    {

        // get the user who placed the order
        $user = $order->user()->first();
        $order->coustomer_name = $user->name;
        $order->coustomer_email = $user->email;
        $order->coustomer_phone = $user->phone;

         $order->delivery_date = date('Y-m-d', strtotime($order->date_added. ' + 1 days'));

        // get  the products in the order from the pivot table with category name  and store name
        $order_products = $order->products()->get();
        foreach($order_products as $order_product) {
            $order_product->product_image =  env('APP_URL').Storage::url($order_product->product_image);
            $category = $order_product->category()->first();
            $order_product->category_name = $category->category_name;
            $store = $order_product->store()->first();
            $order_product->store_name = $store->store_name;
        }


        return view('dashboard.orders.details', compact('order', 'order_products'));

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function edit(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Order $order)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function destroy(Order $order)
    {
        $order->delete();
        return redirect()->route('orders.index')->with('success', 'تم حذف الطلب بنجاح');

    }
}
