<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $categories = Category::all();
        return view('dashboard.categories.categories', compact('categories'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all();

        return view('dashboard.categories.add-category',  compact('categories'));

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
            'slug' => Str::slug($request->post('category_name'))
        ]);
        $data = $request->except('image');


        $request->validate([
            'category_name' => 'required|unique:categories|max:255|min:3',
            'slug' => 'required|unique:categories',
            'category_description' => 'required',
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'status' => 'required|in:published,unpublished,scheduled',
            'parent_id' => 'integer|exists:categories,id'
        ]);



//         Request merge
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $newString = str_replace(' ', '_', $file->getClientOriginalName());
            $name = time().$newString;
            $path =  $file->storeAs('uploads/categories', $name,  'public');
            $data['image'] = $path;
        }

           $category = Category::create($data);

          return redirect()->route('categories.index')->with('success', 'Category Created ');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {

     }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        $categories =  Category::all();
         return view('dashboard.categories.edit-category',  compact('category', 'categories'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {
        $data = $request->except('image');
        $oldImage = $category->image;
        //Update the specified category in storage
        $request->merge([
            'slug' => Str::slug($request->post('category_name'))
        ]);

        $request->validate([
            'category_name' => 'required|max:255|min:3',
            'slug' => 'required',
            'category_description' => 'required',
            'image' => 'image',
            'status' => 'required|in:published,unpublished,scheduled',
            'parent_id' => 'integer|exists:categories,id'
        ]);

        if ($request->hasFile('image')) {
            //Delete the old image
            Storage::disk('public')->delete($oldImage);

            $file = $request->file('image');
            $newString = str_replace(' ', '_', $file->getClientOriginalName());
            $name = time().$newString;
            $path =  $file->storeAs('uploads/categories', $name,  'public');
            $data['image'] = $path;
        }

         $category->update($data);

        return redirect()->route('categories.index')->with('success', 'Category Updated ');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        //Remove the specified category from storage
        $category->delete();
        if ($category->image) {
            Storage::disk('public')->delete($category->image);
        }

        return redirect()->route('categories.index')->with('success', 'Category Deleted');

    }
}
