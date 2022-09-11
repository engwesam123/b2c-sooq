<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
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

        $cart =   Cart::create($request->all());

        $return_data = array(
            'status' => $cart ? true : false,
            'msg' => "Product added to cart",
        );
        return $return_data;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
         $cart_items = Cart::where('user_id', $id)->get();
         foreach($cart_items as $cart_item) {
            $product = $cart_item->product()->first();
            $cart_item->product_name = $product->product_name;
            $cart_item->product_description = $product->product_description;
            $cart_item->product_price = $product->base_price;
            $cart_item->product_image =  env('APP_URL').Storage::url($product->product_image);

         }

         $return_data = array(
            'status' => $cart_items ? true : false,
            'records' => $cart_items,
        );
        return $return_data;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }


    // delete cart item from cart table where user_id and product_id is matched
    public function deleteProduct($user_id, $product_id)
    {
        $cart_item = Cart::where('user_id', $user_id)->where('product_id', $product_id)->delete();
        $return_data = array(
            'status' => $cart_item ? true : false,
            'msg' => "Product removed from cart",
        );
        return $return_data;
    }


    public function getCartItems($user_id) {
        $cart_items = Cart::where('user_id', $user_id)->get();
        foreach($cart_items as $cart_item) {
            $product = $cart_item->product()->first();
            $cart_item->product_name = $product->product_name;
            $cart_item->product_description = $product->product_description;
            $cart_item->product_price = $product->base_price;
            $cart_item->product_image =  env('APP_URL').Storage::url($product->product_image);

        }

        $return_data = array(
            'status' => $cart_items ? true : false,
            'records' => $cart_items,
        );
        return $return_data;
    }

    // function to confirm order and sum price total for product and add order to order table and remove cart items from cart table and add products in order_product table
    public function confirmOrder(Request $request) {
        $user_id = $request->user_id;
        $cart_items = Cart::where('user_id', $user_id)->get();
        $total_price = 0;
        foreach($cart_items as $cart_item) {
            $product = $cart_item->product()->first();
            $total_price += $product->base_price;
        }
        $order = Order::create([
            'user_id' => $user_id,
            'total_price' => $total_price,
            'status' => 'pending',
            'date_added' => date('Y-m-d'),
            'user_location' => $request->location,
        ]);

        foreach($cart_items as $cart_item) {
            $product = $cart_item->product()->first();
            $order->products()->attach($product->id);
        }

        $cart_items = Cart::where('user_id', $user_id)->delete();

        $return_data = array(
            'status' => $order ? true : false,
            'msg' => "Order placed successfully",
        );
        return $return_data;
    }





}
