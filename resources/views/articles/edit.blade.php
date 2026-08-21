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

            <div>
                <label class="block mb-1">Bezeichnung</label>
                <input name="name" value="{{ $article->name }}" class="w-full border rounded p-2">
            </div>
            <div>
                <label class="block mb-1">Art / Kategorie</label>
                <select name="type" class="w-full border rounded p-2">
                    <option value="">-- Kategorie wählen --</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->name }}"
                            @selected(old('type', $article->type ?? '') === $category->name)>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block mb-1">Preis in EUR</label>
                <input name="price" value="{{ $article->price }}" class="w-full border rounded p-2">
            </div>
            <div>
                <label class="block mb-1">MwSt-Satz in %</label>
                <input name="vat_rate" value="{{ $article->vat_rate }}" class="w-full border rounded p-2">
            </div>
            <div>
                <label class="block mb-1">Mindestbestand</label>
                <input name="min_stock" value="{{ $article->min_stock }}" class="w-full border rounded p-2">
            </div>
            <div>
                <label class="block mb-1">Größe in cm</label>
                <input name="size" value="{{ $article->size }}" class="w-full border rounded p-2">
            </div>
            <div>
                <label class="block mb-1">Farbe</label>
                <input name="colour" value="{{ $article->colour }}" class="w-full border rounded p-2">
            </div>
            <div>
                <label class="block mb-1">Gewicht in kg</label>
                <input name="weight" value="{{ $article->weight }}" class="w-full border rounded p-2">
            </div>
            <div>
                <label class="block mb-1">Modelljahr</label>
                <input name="model_year" value="{{ $article->model_year }}" class="w-full border rounded p-2">
            </div>


            <button class="px-4 py-2 bg-teal-700 hover:bg-teal-800 transition text-white rounded">Speichern</button>
        </form>
        <div class="flex items-center gap-3">
            <form action="{{ route('stock-movements.store') }}" method="POST">
                @csrf
                <input type="hidden" name="article_id" value="{{ $article->id }}">
                <input type="hidden" name="type" value="Ausgang">
                <input type="hidden" name="quantity" value="1">
                <button class="px-3 py-1 bg-gray-200 rounded">-</button>
            </form>

            <span>Bestand: {{ $article->stocks->sum('quantity') }}</span>

            <form action="{{ route('stock-movements.store') }}" method="POST">
                @csrf
                <input type="hidden" name="article_id" value="{{ $article->id }}">
                <input type="hidden" name="type" value="Eingang">
                <input type="hidden" name="quantity" value="1">
                <button class="px-3 py-1 bg-gray-200 rounded">+</button>
            </form>

        </div>
    </div>
</x-app-layout>
