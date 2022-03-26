<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Resources\Category\CategoryCollection;

class CategoriesController extends Controller
{
    public function selection()
    {
        return response()->json(Category::all());
    }

    public function store(Request $request)
    {
        $category = Category::create([
            "name" => $request->input('name')
        ]);

        $inputs = [
            "name" => $request->input('name')
        ];

        createLog($category, $inputs, 'Created');

        return new CategoryCollection(Category::paginate(20));
    }

    public function getCategories(Request $request)
    {
        if($request->filled('search')) {
            $category = Category::where('name', 'LIKE', '%'.$request->input('search').'%')->paginate(20);
        } else {
            $category = Category::paginate(20);
        }

        return new CategoryCollection($category);
    }

    public function update(Request $request, Category $category) 
    {
        $category->update([
            "name" => $request->input('name')
        ]);

        $inputs = [
            "name" => $request->input('name')
        ];

        createLog($category, $inputs, 'Update');

        return new CategoryCollection(Category::paginate(20));
    }

    public function destroy(Category $category)
    {
        $inputs = [
            "deleted_category" => $category->name
        ];
        createLog($category, $inputs, 'Deleted');
        $category->delete();
        return new CategoryCollection(Category::paginate(20));
    }
}
