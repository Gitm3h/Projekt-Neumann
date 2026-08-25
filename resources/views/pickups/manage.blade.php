<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">Abholungen verwalten</h2>
    </x-slot>
    <div class="max-w-7xl mx-auto py-6 px-4">
        <table class="w-full bg-white rounded shadow">
            <thead>
            <tr class="text-left border-b">
                <th class="p-3">Nr.</th>
                <th class="p-3">Datum</th>
                <th class="p-3">Artikel</th>
                <th class="p-3">Status</th>
                <th class="p-3">Spediteur</th>
                <th class="p-3">Aktion</th>
            </tr>
            </thead>
            <tbody>
            @forelse ($pickups as $pickup)
                <tr class="border-b align-top">
                    <td class="p-3">{{ $pickup->id }}</td>
                    <td class="p-3">{{ \Carbon\Carbon::parse($pickup->date)->format('d.m.Y') }}</td>
                    <td class="p-3">
                        @foreach ($pickup->items as $item)
                            <div>{{ $item->article?->name }} &times; {{ $item->quantity }}</div>
                        @endforeach
                    </td>
                    <td class="p-3">{{ $pickup->status }}</td>
                    <td class="p-3">{{ $pickup->spediteur?->name ?? '-' }}</td>
                    <td class="p-3">
                        <a href="{{ route('pickups.edit', $pickup) }}" class="text-teal-700 hover:text-teal-800">Bearbeiten</a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="p-3 text-gray-500">Keine Abholungen.</td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>
</x-app-layout>
