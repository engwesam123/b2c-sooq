<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Support\Facades\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // return all catigories with pagination
        $categories = Category::all();
        foreach($categories as $category) {
           $path =   env('APP_URL').Storage::url($category->image) ;
              $category->image = $path;
        }

        $return_data = array(
            'status' => $categories ? true : false,
            'records' => $categories,
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
        // store new category\

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $category = Category::find($id)->first();
        $product =  Product::where('category_id', $id)->get();

        $path =   env('APP_URL').Storage::url($category->image) ;
        $category->image = $path;
         $return_data = array(
            'status' => $category ? true : false,
            'records' => $category,
            'products' => $product,
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
        // Update the specified resource in storage

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {


    }
}
