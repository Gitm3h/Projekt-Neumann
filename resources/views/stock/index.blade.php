<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800">Bestandsübersicht</h2>
    </x-slot>

    <div class="max-w-7xl mx-auto py-6 px-4">
        <table class="w-full bg-white rounded shadow">
            <thead>
               <tr class="text-left border-b">
                   <th class="p-3">Artikel</th>
                   <th class="p-3">Lagerplatz</th>
                   <th class="p-3">Menge</th>
               </tr>
            </thead>
            <tbody>
            @foreach ($stocks as $stock)
                <tr class="border-b">
                    <td class="p-3">{{ $stock->article->name }}</td>
                    <td class="p-3">{{ $stock->storageLocation->name }}</td>
                    <td class="p-3 @if ($stock->quantity < $stock->article->min_stock) text-red-600 font-bold @endif">
                        {{ $stock->quantity }}
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>

    </div>
</x-app-layout>
