<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800">
            Lagerplatz: {{ $location->name }}
        </h2>
    </x-slot>
    <div class="max-w-3xl mx-auto py-6 px-4">
        <table class="w-full bg-white rounded shadow">
            <thead><tr class="text-left border-b">
                <th class="p-3">Artikel</th><th class="p-3">Menge</th>
            </tr>

            </thead>
            <tbody>
            @forelse($location->stocks as $stock)
                <tr class="border-b">
                    <td class="p-3">{{ $stock->article->name }}</td>
                    <td class="p-3">{{ $stock->article->quantity }}</td>
                </tr>
            @empty
                <tr><td colspan="2" class="p-3 text-gray-500">Nichts eingelagert.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
</x-app-layout>
