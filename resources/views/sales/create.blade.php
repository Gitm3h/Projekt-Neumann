<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Neuer Verkauf
        </h2>
    </x-slot>
    <div class="max-w-7xl mx-auto py-6 px-4">
        <form action="{{ route('sales.store') }}" method="POST"
              class="bg-white p-6 rounded shadow space-y-4">

            @csrf
            <div>
                <label class="block mb-1">Artikel</label>
                <select name='article_id' class="w-full border rounded p-2">
                    @foreach ($articles as $article)
                        <option value="{{ $article->id }}">{{ $article->name }} ({{$article->price}} EUR)</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block mb-1">Menge</label>
                <input name='quantity' type="number" min="1" value="1" class="w-full border rounded p-2">
            </div>
            <div>
                <label class="block mb-1">Zahlart</label>
                <select name="payment_method" class="w-full border rounded p-2">
                    <option value="Bar">Bar</option>
                    <option value="Karte">Karte</option>
                    <option value="Rechnung">Rechnung</option>
                </select>
            </div>

            <button class="px-4 py-2 bg-teal-700 hover:bg-teal-800 transition text-white rounded">Verkauf buchen</button>

        </form>
    </div>
</x-app-layout>
