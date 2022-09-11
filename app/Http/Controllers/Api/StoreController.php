<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Store;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class StoreController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // return all catigories with pagination
        $stores = Store::all();
        foreach($stores as $store) {
            $path =   env('APP_URL').Storage::url($store->logo_image) ;
            $store->image = $path;
        }

        $return_data = array(
            'status' => $stores ? true : false,
            'records' => $stores,
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
        $store   = Store::find($id)->first();
        // get all categories of this store from category_store table join with categories table where store_id = $id
        $categories = Store::find($id)->categories()->get();


        foreach($categories as $category) {
            $path =   env('APP_URL').Storage::url($category->image) ;
            $category->image = $path;
            unset($category->pivot);
        }
        $path =   env('APP_URL').Storage::url($store->logo_image) ;
        $store->logo_image = $path;
        $return_data = array(
            'status' => $store ? true : false,
            'records' => $store,
            'categories' => $categories,

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

    // get products of this store
    public function products($id)
    {
        $products = Store::find($id)->products()->get();
        foreach($products as $product) {
            $path =   env('APP_URL').Storage::url($product->image) ;
            $product->image = $path;
            unset($product->pivot);
        }
        $return_data = array(
            'status' => $products ? true : false,
            'records' => $products,

        );
        return $return_data;
    }


}
