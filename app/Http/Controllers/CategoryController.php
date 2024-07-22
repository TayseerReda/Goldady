<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
       
        return Category::all();
    }

    public function store(CategoryRequest $request)
    {
        Category::create($request->validated());
        return response()->json(['message'=>'Category created successfully','Categories'=>Category::all()]);
    }
    // public function store(Request $request)
    // {
    //     // return 'ok';
    //     $category=$request->validate([
    //         'Name'=>'string|unique:categories,Name'
    //     ]);
    //     Category::create($category);
    //     return response()->json(['message'=>'Category created successfully','Categories'=>Category::all()]);
    // }

    public function show(Category $category)
    {
       return $category;
    }

    public function update(CategoryRequest $request, Category $category)
    {

        $category->update($request->validated());
        return response()->json(['message' => 'Category updated successfully']); 

    }

    public function destroy(Category $category)
    {
       $category->delete(); 
       return ['message'=>'Category deleted successfully'];

    }
}
