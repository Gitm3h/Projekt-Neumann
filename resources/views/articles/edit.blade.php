<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Artikel bearbeiten
        </h2>
    </x-slot>
    <div class="max-w-7xl mx-auto py-6 px-4">
        <form action="{{ route('articles.update', $article) }}" method="POST"
              class="bg-white p-6 rounded shadow space-y-4">

            @csrf @method('PUT')
            @if ($errors->any())
                <div class="mb-4 rounded bg-red-100 p-3 text-red-700">
                    <ul class="list-disc pl-5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <div><input name="name" placeholder="Bezeichnung" value="{{ $article->name }}" class="w-full border rounded p-2"></div>
            <div><input name="type" placeholder="Art" value="{{ $article->type }}" class="w-full border rounded p-2"></div>
            <div><input name="price" placeholder="Preis in EUR" value="{{ $article->price }}" class="w-full border rounded p-2"></div>
            <div><input name="min_stock" placeholder="Mindestbestand" value="{{ $article->min_stock }}" class="w-full border rounded p-2"></div>
            <div><input name="size" placeholder="Größe" value="{{ $article->size }}" class="w-full border rounded p-2"></div>
            <div><input name="colour" placeholder="Farbe" value="{{ $article->colour }}" class="w-full border rounded p-2"></div>
            <div><input name="weight" placeholder="Gewicht" value="{{ $article->weight }}" class="w-full border rounded p-2"></div>
            <div><input name="model_year" placeholder="Modelljahr" value="{{ $article->model_year }}" class="w-full border rounded p-2"></div>

            <button class="px-4 py-2 bg-teal-700 hover:bg-teal-800 transition text-white rounded">Speichern</button>
        </form>
    </div>
</x-app-layout>
