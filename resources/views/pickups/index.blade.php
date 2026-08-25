<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">Abholungen</h2>
    </x-slot>
    <div class="max-w-7xl mx-auto py-6 px-4">
        @forelse ($pickups as $pickup)
            <div class="bg-white rounded shadow p-4">
                <div class="text-sm text-gray-500">Abholung #{{ $pickup->id }} vom {{ $pickup->date }}</div>
                <form method="POST" action="{{ route('pickups.confirm', $pickup) }}" class="mt-3">
                    @csrf
                    @method('PATCH')
                    <table class="w-full bg-white rounded shadow">
                        <thead>
                        <tr class="text-left border-b">
                            <th class="p-2">Artikel</th>
                            <th class="p-3">Angemeldet</th>
                            <th class="p-3">Entnommen</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($pickup->items as $item)
                            <tr class="border-b">
                                <td class="p-2">{{ $item->article?->name }}</td>
                                <td class="p-2">{{ $item->quantity }}</td>
                                <td class="p-2">
                                    <input type="number" name="taken[{{ $item->id }}]" min="0" max="{{ $item->quantity }}" value="{{ $item->quantity }}"
                                           class="border rounded p-1 w-24"></td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <button class="mt-3 px-4 py-2 bg-teal-700 hover:bg-teal-800 text-white rounded">Abholung bestätigen.</button>
                </form>
            </div>
        @empty
            <p class="text-gray-500">Keine offenen Abholungen.</p>
        @endforelse
    </div>
</x-app-layout>


