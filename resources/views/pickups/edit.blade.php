<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">Abholungen #{{ $pickup->id }} bearbeiten</h2>
    </x-slot>
    <div class="max-w-7xl mx-auto py-6 px-4">
        <div class="w-full bg-white rounded shadow">
            <div class="mb-4 text-sm text-gray-600">
                @foreach ($pickup->items as $item)
                    <div>{{ $item->article?->name }} &times; {{ $item->quantity }}</div>
                @endforeach
            </div>
            <form method="POST" action="{{ route('pickups.update', $pickup) }}" class="space-y-4">
                @csrf
                @method('PATCH')
                <div>
                    <label class="block mb-1">Zuständiger Spediteur</label>
                    <select name="spediteur_id" class="w-full border rounded p-2">
                        <option value="">-- kein Spediteur --</option>
                        @foreach ($spediteure as $s)
                            <option value="{{ $s->id }}" @selected($pickup->spediteur_id === $s->id)>{{ $s->name }}</option>
                        @endforeach
                    </select>
                </div>
                <button class="px-4 py-2 bg-teal-700 hover:bg-teal-800 transition text-white rounded">Speichern</button>
            </form>
        </div>
    </div>
</x-app-layout>

