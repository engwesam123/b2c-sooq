<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Store;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class StoreController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $stores = Store::all();
        return view('dashboard.stores.stores', compact('stores'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all();

        return view('dashboard.stores.add-store' , compact('categories'));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $categories_id = array();
        $categories = $request->input('category');
        $category_store = $request->except('category');


        $request->merge([
            'slug' => Str::slug($request->post('store_name'))
        ]);
        $data = $request->except('logo_image');


        $request->validate([
            'store_name' => 'required|unique:stores|max:255|min:3',
            'slug' => 'required|unique:stores',
            'store_description' => 'required',
            'status' => 'required|in:published,unpublished,scheduled',
         ]);

//         Request merge
        if ($request->hasFile('logo_image')) {

            $file = $request->file('logo_image');
            $newString = str_replace(' ', '_', $file->getClientOriginalName());
            $name = time().$newString;

            $path =  $file->storeAs('uploads/stores', $name,  'public');
            $data['logo_image'] = $path;
        }
          $store = Store::create($data);

        foreach ($categories as $category) {
            $categories_id[] = array(
                'category_id' => $category,
                'store_id' => $store->id
            );
        }
         DB::table('category_store')->insert($categories_id);

         return redirect()->route('stores.index')->with('success', 'تم إنشاء المتجر بنجاح');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Store  $store
     * @return \Illuminate\Http\Response
     */
    public function show(Store $store)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Store  $store
     * @return \Illuminate\Http\Response
     */
    public function edit(Store $store)
    {
         return view('dashboard.stores.edit-store',  compact('store'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Store  $store
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Store $store)
    {
         $data = $request->except('logo_image');
        $oldImage = $store->logo_image;
         $request->merge([
            'slug' => Str::slug($request->post('store_name'))
        ]);

        $request->validate([
            'store_name' => 'required|max:255|min:3',
            'slug' => 'required',
            'store_description' => 'required',
            'status' => 'required|in:published,unpublished,scheduled',
         ]);

         if ($request->hasFile('image')) {
            //Delete the old image
            Storage::disk('public')->delete($oldImage);

            $file = $request->file('image');
             $newString = str_replace(' ', '_', $file->getClientOriginalName());
             $name = time().$newString;            $path =  $file->storeAs('uploads/stores', $name,  'public');
            $data['logo_image'] = $path;
        }

        $store->update($data);

        return redirect()->route('stores.index')->with('success', 'تم تحديث المتجر بنجاح');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Store  $store
     * @return \Illuminate\Http\Response
     */
    public function destroy(Store $store)
    {
        $store->delete();
        if ($store->logo_image) {
            Storage::disk('public')->delete($store->logo_image);
        }

        return redirect()->route('stores.index')->with('success', 'تم حذف المتجر بنجاح');
    }
}
