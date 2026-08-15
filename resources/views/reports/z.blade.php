<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">
            Z-Bericht {{ now()->format('d.m.Y') }}
        </h2>
    </x-slot>
    <div class="max-w-3xl mx-auto mt-8 py-6 px-4 bg-white p-6 rounded shadow">
        <p>Anzahl Verkäufe: <b>{{ $anzahl }}</b></p>
        <p>Tagesumsatz: <b>{{ number_format($umsatz, 2, ',', '.') }} EUR</b></p>

        <h3 class="mt-4 font-semibold">Nach Zahlart</h3>
        <ul class="list-disc ml-6">
            @foreach($nachZahlart as $art => $summe)
                <li>{{ $art }}: {{ number_format($summe, 2, ',', '.') }} EUR</li>
            @endforeach
        </ul>
    </div>
</x-app-layout>
