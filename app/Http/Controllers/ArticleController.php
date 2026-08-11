<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    public function index()
    {
        $articles = Article::all();
        return view('articles.index', ['articles' => $articles]);
    }

    public function create()
    {
        return view('articles.create');
    }

    public function store(Request $request)
    {
     $data = $request->validate([
         'name' => 'required',
         'type' => 'required',
         'size' => 'nullable',
         'colour' => 'nullable',
         'weight' => 'nullable |numeric',
         'model_year' => 'nullable |integer',
         'price' => 'required | numeric',
         'min_stock' => 'required | integer',
     ],
         [
            'required' => 'Das Feld :attribute ist erforderlich.',
            'numeric' => 'Das Feld :attribute muss eine Zahl sein',
            'integer' => 'Das Feld :attribute muss eine ganze Zahl sein',
         ],
         [
            'name' => 'Bezeichnung',
             'type' => 'Art',
             'price' => 'Preis',
             'min_stock' => 'Min-Stock',
         ]
     );
     Article::create($data);
     return redirect()->route('articles.index');
    }

    public function edit(Article $article)
    {
        return view('articles.edit', ['article' => $article]);
    }

    public function update(Request $request, Article $article)
    {
        $data = $request->validate([
            'name' => 'required',
            'type' => 'required',
            'size' => 'nullable',
            'colour' => 'nullable',
            'weight' => 'nullable |numeric',
            'model_year' => 'nullable |integer',
            'price' => 'required | numeric',
            'min_stock' => 'required | integer',
        ],
        [
            'required' => 'Das Feld :attribute ist erforderlich.',
            'numeric' => 'Das Feld :attribute muss eine Zahl sein',
            'integer' => 'Das Feld :attribute muss eine ganze Zahl sein',
         ],
         [
             'name' => 'Bezeichnung',
             'type' => 'Art',
             'price' => 'Preis',
             'min_stock' => 'Min-Stock',
             ]
        );
        $article->update($data);
        return redirect()->route('articles.index');
    }

    public function destroy(Article $article)
    {
        $article->delete();
        return redirect()->route('articles.index');
    }
}
