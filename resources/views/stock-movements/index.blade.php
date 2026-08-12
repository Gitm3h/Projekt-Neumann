<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Buchungen
        </h2>
    </x-slot>
    <div class="max-w-7xl mx-auto py-6 px-4">
        <a href="{{ route('stock-movements.create') }}"
           class="inline-block mb-4 px-4 py-2 bg-teal-700 hover:bg-teal-800 transition text-white rounded">
            + Neue Buchung
        </a>

        <table class="w-full bg-white rounded shadow">
            <thead><tr class="text-left border-b">
                <th class="p-3">Datum</th>
                <th class="p-3">Artikel</th>
                <th class="p-3">Art</th>
                <th class="p-3">Menge</th>
                <th class="p-3">Von</th>
            </tr>
            </thead>
            <tbody>
            @forelse ($movements as $m)
                <tr class="border-b">
                    <td class="p-3">{{ $m->date }}</td>
                    <td class="p-3">{{ $m->article?->name }}</td>
                    <td class="p-3">{{ $m->type }}</td>
                    <td class="p-3">{{ $m->quantity }}</td>
                    <td class="p-3">{{ $m->user->name }}</td>
                </tr>
            @empty

                <tr>
                    <td colspan="5" class="p-3 text-gray-500">Noch keine Buchungen.</td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>
</x-app-layout>
