<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">
            Niedrigbestand
        </h2>
    </x-slot>

    <div class="max-w-3xl mx-auto py-6 px-4 bg-white p-6 rounded shadow">
        @if ($artikel->isEmpty())
            <p>Kein Artikel unter Mindestbestand.</p>
        @else
            <ul class="list-disc ml-6">
                @foreach ($artikel as $a)
                    <li class="text-red-600">
                        {{ $a->name }} — Bestand: {{ $a->stocks->sum('quantity') }} / Mindestbestand: {{ $a->min_stock }}
                    </li>
                @endforeach
            </ul>
        @endif
    </div>
</x-app-layout>
