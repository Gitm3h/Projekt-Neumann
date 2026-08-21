<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        return view('categories.index', ['categories' => Category::orderBy('name')->get()]);
    }

    public function create()
    {
        return view('categories.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'unique:categories,name']]);
        Category::create($data);
        return redirect()->route('categories.index')->with('success', 'Kategorie gespeichert.');
    }

    public function show(string $id)
    {
        //
    }

    public function edit(Category $category)
    {
        return view('categories.edit', ['category' => $category]);
    }


    public function update(Request $request, Category $category)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'unique:categories,name,'.$category->id]
        ]);
        $category->update($data);
        return redirect()->route('categories.index')->with('success', 'Kategorie aktualisiert.');
    }

    public function destroy(Category $category)
    {
        $category->delete();
        return redirect()->route('categories.index')->with('success', 'Kategorie gelöscht.');
    }
}
