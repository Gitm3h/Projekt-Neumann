<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">
            Artikel: {{ $article->name }}
        </h2>
    </x-slot>
    <div class="max-w-3xl mx-auto py-6 px-4">
        <div class="bg-white p-6 rounded shadow space-y-2">
            <p><strong>Bezeichnung:</strong> {{ $article->name }}</p>
            <p><strong>Art:</strong> {{ $article->type }}</p>
            <p><strong>Preis in EUR:</strong> {{ $article->price }}</p>
            <p><strong>Mindestbestand:</strong> {{ $article->min_stock }}</p>
            <p><strong>Größe:</strong> {{ $article->size }}</p>
            <p><strong>Farbe:</strong> {{ $article->colour }}</p>
            <p><strong>Gewicht:</strong> {{ $article->weight }}</p>
            <p><strong>Modelljahr:</strong> {{ $article->model_year }}</p>
            <a href="{{ route('articles.index') }}" class="inline-block px-4 py-2 bg-teal-700 hover:bg-teal-800 transition text-white rounded">
                Zurück zur Übersicht</a>
        </div>
    </div>
</x-app-layout>
