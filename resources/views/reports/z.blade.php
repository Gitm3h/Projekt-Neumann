<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">
            Z-Bericht {{ \Carbon\Carbon::parse($datum)->format('d.m.Y') }}
        </h2>
    </x-slot>
    <div class="max-w-3xl mx-auto mt-8 py-6 px-4">
        <div class="flex items-end gap-3 mb-4">
            <form method="GET" action="{{ route('reports.z') }}" class="flex items-end gap-2">
            <div>
                <label class="block mb-1 text-sm">Datum</label>
                <input type="date" name="datum" value="{{ $datum }}" class="border rounded p-2">
            </div>
            <button class="px-4 py-2 bg-teal-700 hover:bg-teal-800 transition text-white rounded">Anzeigen</button>
            </form>
            <a href="{{ route('reports.z.pdf', ['datum' => $datum]) }}" target="_blank"
               class="text-teal-700 hover:underline">PDF</a>
        </div>
        <div class="bg-white p-6 rounded shadow">
            <p>Anzahl Verkäufe: <b>{{ $anzahl }}</b></p>
            <p>Tagesumsatz: <b>{{ number_format($umsatz, 2, ',', '.') }} EUR</b></p>
            <h3 class="mt-4 font-semibold">Nach Zahlart</h3>
            <ul class="list-disc ml-6">
                @foreach($nachZahlart as $art => $summe)
                    <li>{{ $art }}: {{ number_format($summe, 2, ',', '.') }} EUR</li>
                @endforeach
            </ul>
            <h3 class="mt-4 font-semibold">Niedriger Lagerbestand</h3>
            @forelse($niedrig as $a)
                <p class="text-red-600">{{ $a->name }}: {{ $a->stocks->sum('quantity') }} (Mindestbestand {{ $a->min_stock }})</p>
            @empty
                <p class="text-gray-500">Alle Artikel über Mindestbestand</p>
            @endforelse
        </div>
    </div>
</x-app-layout>

