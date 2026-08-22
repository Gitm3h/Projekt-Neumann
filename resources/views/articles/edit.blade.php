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
        <div class="mt-6 bg-white p-6 rounded shadow"
             x-data="{ current: {{ $article->stocks->sum('quantity') }}, change: 0 }">
            <label class="block mb-2 font-medium">Bestand anpassen</label>
            <div class="flex items-center gap-3">
                <button type="button" @click="if (current + change > 0) change--" class="px-3 py-1 bg-gray-200 hover:bg-gray-300 rounded text-lg">-</button>

                <span class="text-xl font-semibold w-16 text-center" x-text="current + change"></span>
                <button type="button" @click="change++" class="px-3 py-1 bg-gray-200 hover:bg-gray-300 rounded text-lg">+</button>

                <form action="{{ route('stock-movements.store') }}" method="POST" x-show="change !==0" class="ms-3">
                    @csrf
                    <input type="hidden" name="article_id" value="{{ $article->id }}">
                    <input type="hidden" name="type" :value="change > 0 ? 'Eingang' : 'Ausgang'">
                    <input type="hidden" name="quantity" :value="Math.abs(change)">
                    <button class="px-4 py-2 bg-teal-700 hover:bg-teal-800 transition text-white rounded">Speichern</button>
                </form>
            </div>
            <p class="mt-2 text-sm text-gray-500">Menge mit + und - anpassen, mit "Speichern" buchen</p>

        </div>
    </div>
</x-app-layout>
