<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Auth\Events\Validated;
use Illuminate\Http\Request;
use App\Http\Resources\CategoryResource;

class CategoryController extends Controller
{

    public function index()
    {
        $categories = Category::included()
            ->filter() // Javi con este filtramos
            ->sort() // Javi aca lo ordenamos desc o asc
            ->getOrPaginate(); // Javi paginacion
        // ->get(); // Javi con el get se cre la coleccion
        // return $categories;
        return CategoryResource::collection($categories);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255',
            'slug' => 'required|max:255|unique:categories',
        ]);
        $category = Category::create($request->all());
        /*   return $category; */
        return  CategoryResource::make($category);
    }

    public function show($id)
    {
        $category = Category::included()->findOrfail($id);
        return  CategoryResource::make($category);
    }

    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => 'required|max:255',
            'slug' => 'required|max:255|unique:categories,slug,' . $category->id,
        ]);
        $category->update($request->all());
        /* return $category; */
        return  CategoryResource::make($category);
    }

    public function destroy(Category $category)
    {
        $category->delete();
        /*       return $category; */
        return  CategoryResource::make($category);
    }
}
