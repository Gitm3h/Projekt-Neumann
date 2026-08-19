<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    public function index(Request $request)
    {
        $query = Article::query();
        if ($request->filled('suche'))
        {
            $s = $request->input('suche');
            $query->where('name', 'LIKE', "%{$s}%") ->orWhere('type', 'LIKE', "%{$s}%");
        }
        $articles = $query->paginate(20)->withQueryString();
        return view('articles.index', ['articles' => $articles]);
    }

    public function stock()
    {
        $articles = Article::orderBy('name')->get();
        return view('articles.stock', ['articles' => $articles]);
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
         'weight' => ['nullable', 'numeric'],
         'model_year' => ['nullable', 'integer'],
         'price' => ['required', 'numeric'],
         'vat_rate' => ['required', 'numeric'],
         'min_stock' => ['required', 'integer'],
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
             'vat_rate' => 'Mehrwert-Steuer',
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
            'weight' => ['nullable', 'numeric'],
            'model_year' => ['nullable', 'integer'],
            'price' => ['required', 'numeric'],
            'vat_rate' => ['required', 'numeric'],
            'min_stock' => ['required', 'integer'],
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
             'vat_rate' => 'Mehrwert-Steuer',
             'min_stock' => 'Min-Stock',
             ]
        );
        $article->update($data);
        return redirect()->route('articles.index');
    }

    public function show(Article $article)
    {
        $article->load('stocks.storageLocation');
        return view('articles.show', ['article' => $article]);
    }

    public function destroy(Article $article)
    {
        try {
            $article->delete();
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect()->route('articles.index')->with('error', 'Artikel kann nicht gelöscht werden, da er noch in Bestellungen/Reservierungen referenziert wird.');
        }

        return redirect()->route('articles.index')->with('success', 'Artikel gelöscht');
    }
}
