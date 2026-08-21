<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Neuer Artikel
        </h2>
    </x-slot>
    <div class="max-w-7xl mx-auto py-6 px-4">
        <form action="{{ route('articles.store') }}" method="POST"
        class="bg-white p-6 rounded shadow space-y-4">

            @csrf

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
                <input name="name" value="{{ old('name') }}" class="w-full border rounded p-2">
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
                <input name="price" value="{{ old('price') }}" class="w-full border rounded p-2">
            </div>
            <div>
                <label class="block mb-1">MwSt-Satz in %</label>
                <input name="vat_rate" value="{{ old('vat_rate') }}" class="w-full border rounded p-2">
            </div>
            <div>
                <label class="block mb-1">Mindestbestand</label>
                <input name="min_stock" value="{{ old('min_stock') }}" class="w-full border rounded p-2">
            </div>
            <div>
                <label class="block mb-1">Größe in cm</label>
                <input name="size" value="{{ old('size') }}" class="w-full border rounded p-2">
            </div>
            <div>
                <label class="block mb-1">Farbe</label>
                <input name="colour" value="{{ old('colour') }}" class="w-full border rounded p-2">
            </div>
            <div>
                <label class="block mb-1">Gewicht in kg</label>
                <input name="weight" value="{{ old('weight') }}" class="w-full border rounded p-2">
            </div>
            <div>
                <label class="block mb-1">Modelljahr</label>
                <input name="model_year" value="{{ old('model_year') }}" class="w-full border rounded p-2">
            </div>


            <button class="px-4 py-2 bg-teal-700 hover:bg-teal-800 transition text-white rounded">Speichern</button>
        </form>
    </div>
</x-app-layout>
