<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Verkäufe
        </h2>
    </x-slot>
    <div class="max-w-7xl mx-auto py-6 px-4">
        <a href="{{ route('articles.create') }}"
           class="inline-block mb-4 px-4 py-2 bg-teal-700 hover:bg-teal-800 transition text-white rounded">
            + Neuer Verkauf
        </a>

        <table class="w-full bg-white rounded shadow">
            <thead><tr class="text-left border-b">
                <th class="p-3">Datum</th>
                <th class="p-3">Artikel</th>
                <th class="p-3">Menge</th>
                <th class="p-3">Zahlart</th>
                <th class="p-3">Summe</th>
            </tr>
            </thead>
            <tbody>
            @forelse ($sales as $sale)
                <tr class="border-b">
                    <td class="p-3">{{ $sale->date }}</td>
                    <td class="p-3">{{ $sale->items->first()?->article?->name }}</td>
                    <td class="p-3">{{ $sale->items->sum('quantity') }}</td>
                    <td class="p-3">{{ $sale->payment_method }}</td>
                    <td class="p-3">({{ $sale->total }} EUR)</td>
                </tr>
            @empty

                <tr>
                    <td colspan="5" class="p-3 text-gray-500">Noch keine Verkäufe.</td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>
</x-app-layout>
