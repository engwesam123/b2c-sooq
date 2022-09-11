<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\Store;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
         $products = Product::all();
         return view('dashboard.products.products', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user = Auth::user();
        $categories = Category::all();
        $stores = Store::all();

        return view('dashboard.products.add-product', compact('categories', 'stores'));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $request->merge([
            'slug' => Str::slug($request->post('product_name'))
        ]);
        $data = $request->except('product_image');

        $request->validate([
            'product_name' => 'required|string|max:255',
            'slug' => 'required|unique:products',
            'product_description' => 'required|string|max:255',
            'category_id' => 'required|integer|exists:categories,id',
            'store_id' => 'required|integer|exists:stores,id',
            'status' => 'required|in:published,unpublished,scheduled',
            'base_price' => 'required|numeric',
            'sku' => 'required|numeric|max:255',
            'Quantity' => 'required|numeric',
         ]);


           if ($request->hasFile('image')) {
            $file = $request->file('image');
             $newString = str_replace(' ', '_', $file->getClientOriginalName());
             $name = time().$newString;
             $path =  $file->storeAs('uploads/products', $name,  'public');
            $data['product_image'] = $path;
         }


         Product::create($data);
        return redirect()->route('products.index')->with('success', 'تم إضافة المنتج بنجاح');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        $user = Auth::user();
        $categories = Category::all();
        $stores = Store::all()->where('id', $user->store_id);
        return view('dashboard.products.edit-product', compact('product', 'categories', 'stores'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {

        $oldImage = $product->product_image;
        $data = $request->except('product_image');
         //Update the specified category in storage
        $request->merge([
            'slug' => Str::slug($request->post('product_name'))
        ]);

        $request->validate([
            'product_name' => 'required|string|max:255',
            'slug' => 'required|unique:products',
            'product_description' => 'required|string|max:255',
            'category_id' => 'required|integer|exists:categories,id',
            'store_id' => 'required|integer|exists:stores,id',
            'status' => 'required|in:published,unpublished,scheduled',
            'base_price' => 'required|numeric',
            'sku' => 'required|numeric|max:255',
            'Quantity' => 'required|numeric',
        ]);

            if($request->hasFile('image')) {
            Storage::disk('public')->delete($oldImage);
            $file = $request->file('image');
            $newString = str_replace(' ', '_', $file->getClientOriginalName());
            $name = time().$newString;
            $path =  $file->storeAs('uploads/products', $name,  'public');
            $data['product_image'] = $path;
        }

        $product->update($data);

        return redirect()->route('products.index')->with('success', 'تم تعديل المنتج بنجاح');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        $product->delete();
        if ($product->product_image) {
            Storage::disk('public')->delete($product->product_image);
        }

        return redirect()->route('products.index')->with('success', 'تم حذف المنتج بنجاح');
    }
}
