<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Ware zur Abholung vormerken
        </h2>
    </x-slot>
    <div class="max-w-7xl mx-auto py-6 px-4">
        @if ($errors->any())
            <div class="mb-4 text-red-600">{{ $errors->first() }}</div>
        @endif
        <form  method="POST" action="{{ route('pickups.store') }}" x-data="{ i: 1 }">
            @csrf
            <div id="positions" class="space-y-2">
                <div class="position flex gap-2">
                    <select name="items[0][article_id]" class="border rounded p-2 flex-1">
                        <option value="">-- Artikel --</option>
                        @foreach ($articles as $a)
                            <option value="{{ $a->id }}">{{ $a->name }} (Bestand: {{ $a->stocks->sum('quantity') }})</option>
                        @endforeach
                    </select>
                    <input type="number" name="items[0][quantity]" min="1" value="1" class="border rounded p-2 w-24">
                </div>
            </div>
            <button type="button" class="mt-2 text-teal-700"
                    @click="const c = document.querySelector('.position').cloneNode(true);
                    c.querySelectorAll('select, input').forEach(f => f.name = f.name.replace(/\[\d+\]/, '[' + i + ']'));
                    c.querySelector('select').selectedIndex = 0;
                    c.querySelector('input').value = 1;
                    document.getElementById('positions').appendChild(c); i++;">
                + Position
            </button>

            <div class="mt-4">
                <button class="px-4 py-2 bg-teal-700 hover:bg-teal-800 transition text-white rounded">Zur Abholung vormerken.</button>
            </div>
        </form>
    </div>

</x-app-layout>

