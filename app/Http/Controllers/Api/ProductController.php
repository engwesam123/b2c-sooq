<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // return all catigories with pagination
        $products = Product::all();
        foreach($products as $product) {
            // get category of this product
            $category = $product->category()->first();
            $store = $product->store()->first();

             $product->store_name = $store->store_name;
             $product->category_name = $category->category_name;
             $path =   env('APP_URL').Storage::url($product->product_image) ;
             $product->product_image = $path;

        }

        $return_data = array(
            'status' => $products ? true : false,
            'records' => $products,
        );
        return $return_data;
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
                $product = Product::find($id);
                // get product category and store
                $category = Product::find($id)->category()->first();
                $store = Product::find($id)->store()->first();
                $product->store_name = $store->store_name;
                 $path =   env('APP_URL').Storage::url($product->product_image) ;
                 $product->product_image = $path;

        $product->category_name = $category->category_name;

                 $return_data = array(
                    'status' => $product ? true : false,
                    'records' => $product,
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

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
