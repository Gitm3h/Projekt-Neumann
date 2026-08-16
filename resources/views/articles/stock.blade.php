<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Bestand
        </h2>
    </x-slot>
    <div class="max-w-7xl mx-auto py-6 px-4">
        <table class="w-full bg-white rounded shadow">
            <thead><tr class="text-left border-b">
                <th class="p-3">Artikel</th>
                <th class="p-3">Art</th>
                <th class="p-3">Preis</th>
                <th class="p-3">Mindestbestand</th>
                <th class="p-3">Bestand</th>
            </tr>
            </thead>
            <tbody>
            @forelse ($articles as $article)
                @php $stock = $article->stocks->sum('quantity');
                @endphp
                <tr class="border-b">
                    <td class="p-3">{{ $article->name }}</td>
                    <td class="p-3">{{ $article->type }}</td>
                    <td class="p-3">{{ number_format($article->price, 2, '.', ',') }} EUR</td>
                    <td class="p-3 {{ $stock < $article->min_stock ? 'text-red-600 font-semibold' : '' }}">{{ $stock }}</td>
                    <td class="p-3">{{ $article->min_stock }}</td>
                </tr>
            @empty
                <tr><td colspan="5" class="p-3 text-gray-500">Keine Artikel</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
</x-app-layout>
