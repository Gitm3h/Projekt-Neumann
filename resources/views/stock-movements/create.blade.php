<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Buchung (Ein-/Ausgang)
        </h2>
    </x-slot>
    <div class="max-w-7xl mx-auto py-6 px-4">
        <form action="{{ route('stock-movements.store') }}" method="POST"
              class="bg-white p-6 rounded shadow space-y-4">

            @csrf

            @error('quantity')
                <p class="text-red-600 text-sm">{{ $message }}</p>
            @enderror

            <div>
                <label class="block mb-1">Artikel</label>
                <select name='article_id' class="w-full border rounded p-2">
                    @foreach ($articles as $article)
                        <option value="{{ $article->id }}">{{ $article->name }}</option>
                    @endforeach
                </select>
            </div>
            <label Class="block mb-1">Art</label>
            <select name="type" class="w-full border rounded p-2">
                <option value="Eingang">Eingang (+)</option>
                <option value="Ausgang">Ausgang (-)</option>
            </select>
            <div>
                <label class="block mb-1">Menge</label>
                <input name='quantity' type="number" min="1" value="1" class="w-full border rounded p-2">
            </div>
            <button class="px-4 py-2 bg-teal-700 hover:bg-teal-800 transition text-white rounded">Buchen</button>

        </form>
    </div>
</x-app-layout>
