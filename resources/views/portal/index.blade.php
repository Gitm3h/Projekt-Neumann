<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">
            Kundenportal
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto py-6 px-4 space-y-6">

        <div class="bg-white rounded shadow p-6">
            <p class="text-lg mt-3">Willkommen zurück, {{ auth()->user()->name }}!</p>
            <p class="text sm text-gray-500">Heute ist der {{ now()->format('d.m.Y') }}</p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div class="bg-white rounded shadow p-6">
                <div class="text-teal-700 font-semibold text-2xl">{{ $anzahl ?? 0 }}</div>
                <div class="text-gray-500 text-sm">reservierte Positionen</div>
            </div>
            <div class="bg-white rounded shadow p-6">
                <div class="text-teal-700 font-semibold text-2xl">{{ number_format($wert ?? 0,2, ',', '.') }} &euro;</div>
                <div class="text-gray-500 text-sm">Warenwert der Reservierungen</div>
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <a href="{{route('portal.articles') }}" class="bg-white p-6 rounded-xl shadow border-2 border-transparent
            hover:border-teal-700 hover:shadow-md transition">
                <div class="text-teal-700 font-semibold">Artikel</div>
                <div class="text-gray-500 text-sm">Bestand ansehen und Ware reservieren</div>
            </a>
            <a href="{{ route('portal.reservations') }}" class="bg-white p-6 rounded-xl shadow border-2 border-transparent
            hover:border-teal-700 hover:shadow-md transition">
                <div class="text-teal-700 font-semibold">Reservierungen</div>
                <div class="text-gray-500 text-sm">Ihre Reservierungen und deren Status</div>
            </a>
        </div>

    </div>
</x-app-layout>
