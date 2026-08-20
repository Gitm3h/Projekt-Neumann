<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800">Dashboard</h2>
    </x-slot>

    @php $role = auth()->user()->role;
    @endphp

    <div class="max-w-7xl mx-auto py-6 px-4 space-y-6">
        <div>
            <p class="text-xl font-bold text-gray-800">Willkommen zurück, <span class="text-teal-700"> {{ auth()->user()->name }}</span></p>
            <p class="text-sm text-gray-600 mt-1">Heute ist der {{ now()->format('d.m.Y') }}</p>
        </div>

        @if ($role === 'kassenkraft')
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                <a href="{{ route('sales.create') }}"
                   class="bg-white p-6 rounded-xl shadow border-2 border-transparent hover:border-teal-500 hover:shadow-md transition">
                    <div class="text-teal-700 font-semibold">Kasse</div>
                    <div class="text-gray-500 text-sm">Neuen Verkauf starten</div>
                </a>
                <a href="{{ route('articles.stock') }}"
                   class="bg-white p-6 rounded-xl shadow border-2 border-transparent hover:border-teal-500 hover:shadow-md transition">
                    <div class="text-teal-700 font-semibold">Bestand</div>
                    <div class="text-gray-500 text-sm">Artikel und Bestand ansehen</div>
                </a>
                <a href="{{ route('reservations.index') }}"
                   class="bg-white p-6 rounded-xl shadow border-2 border-transparent hover:border-teal-500 hover:shadow-md transition">
                    <div class="text-teal-700 font-semibold">Reservierungen</div>
                    <div class="text-gray-500 text-sm">Reservierungen verwalten</div>
                </a>
                <a href="{{ route('reports.z') }}"
                   class="bg-white p-6 rounded-xl shadow border-2 border-transparent hover:border-teal-500 hover:shadow-md transition">
                    <div class="text-teal-700 font-semibold">Z-Bericht</div>
                    <div class="text-gray-500 text-sm">Tagesabschluss ansehen</div>
                </a>
            </div>
        @endif

        @if ($role === 'lagermitarbeiter')
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                <a href="{{ route('articles.index') }}"
                   class="bg-white p-6 rounded-xl shadow border-2 border-transparent hover:border-teal-500 hover:shadow-md transition">
                    <div class="text-teal-700 font-semibold">Artikel</div>
                    <div class="text-gray-500 text-sm">Artikel verwalten</div>
                </a>
                <a href="{{ route('storage-locations.index') }}"
                   class="bg-white p-6 rounded-xl shadow border-2 border-transparent hover:border-teal-500 hover:shadow-md transition">
                    <div class="text-teal-700 font-semibold">Lagerplatz</div>
                    <div class="text-gray-500 text-sm">Lagerplätze verwalten</div>
                </a>
                <a href="{{ route('stock-movements.index') }}"
                   class="bg-white p-6 rounded-xl shadow border-2 border-transparent hover:border-teal-500 hover:shadow-md transition">
                    <div class="text-teal-700 font-semibold">Buchungen</div>
                    <div class="text-gray-500 text-sm">Warenein- und -ausgänge buchen</div>
                </a>
                <a href="{{ route('stock.index') }}"
                   class="bg-white p-6 rounded-xl shadow border-2 border-transparent hover:border-teal-500 hover:shadow-md transition">
                    <div class="text-teal-700 font-semibold">Bestand</div>
                    <div class="text-gray-500 text-sm">Artikel und Bestand einsehen</div>
                </a>
                <a href="{{ route('reports.low-stock') }}"
                   class="bg-white p-6 rounded-xl shadow border-2 border-transparent hover:border-teal-500 hover:shadow-md transition">
                    <div class="text-red-600 font-semibold">{{ $lowStock ?? 0 }} Artikel</div>
                    <div class="text-gray-500 text-sm">unter Mindestbestand</div>
                </a>
            </div>
        @endif

        @if ($role === 'spediteur')
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                <a href="{{ route('stock.index') }}"
                   class="bg-white p-6 rounded-xl shadow border-2 border-transparent hover:border-teal-500 hover:shadow-md transition">
                    <div class="text-teal-700 font-semibold">Bestand</div>
                    <div class="text-gray-500 text-sm">Artikel und Bestand einsehen</div>
                </a>
                <a href="{{ route('stock-movements.deliveries') }}"
                   class="bg-white p-6 rounded-xl shadow border-2 border-transparent hover:border-teal-500 hover:shadow-md transition">
                    <div class="text-teal-700 font-semibold">Lieferungen</div>
                    <div class="text-gray-500 text-sm">Warenein- und -ausgänge anmelden</div>
                </a>
                <a href="{{ route('stock-movements.index') }}"
                   class="bg-white p-6 rounded-xl shadow border-2 border-transparent hover:border-teal-500 hover:shadow-md transition">
                    <div class="text-teal-700 font-semibold">Buchungen</div>
                    <div class="text-gray-500 text-sm">Buchungen ansehen</div>
                </a>
                <a href="{{ route('reports.low-stock') }}"
                   class="bg-white p-6 rounded-xl shadow border-2 border-transparent hover:border-teal-500 hover:shadow-md transition">
                    <div class="text-teal-700 font-semibold">{{ $lowStock ?? 0 }} Artikel</div>
                    <div class="text-gray-500 text-sm">unter Mindestbestand</div>
                </a>
            </div>
        @endif

        @if ($role === 'administrator')
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                <a href="{{ route('customers.index') }}"
                   class="bg-white p-6 rounded-xl shadow border-2 border-transparent hover:border-teal-500 hover:shadow-md transition">
                    <div class="text-teal-700 font-semibold">Kunden</div>
                    <div class="text-gray-500 text-sm">Kunden verwalten</div>
                </a>
                <a href="{{ route('users.index') }}"
                   class="bg-white p-6 rounded-xl shadow border-2 border-transparent hover:border-teal-500 hover:shadow-md transition">
                    <div class="text-teal-700 font-semibold">Benutzer</div>
                    <div class="text-gray-500 text-sm">Benutzer verwalten</div>
                </a>
                <a href="{{ route('articles.index') }}"
                   class="bg-white p-6 rounded-xl shadow border-2 border-transparent hover:border-teal-500 hover:shadow-md transition">
                    <div class="text-teal-700 font-semibold">Artikel</div>
                    <div class="text-gray-500 text-sm">Artikel verwalten</div>
                </a>
                <a href="{{ route('storage-locations.index') }}"
                   class="bg-white p-6 rounded-xl shadow border-2 border-transparent hover:border-teal-500 hover:shadow-md transition">
                    <div class="text-teal-700 font-semibold">Lagerplatz</div>
                    <div class="text-gray-500 text-sm">Lagerplätze verwalten</div>
                </a>
                <a href="{{ route('stock-movements.index') }}"
                   class="bg-white p-6 rounded-xl shadow border-2 border-transparent hover:border-teal-500 hover:shadow-md transition">
                    <div class="text-teal-700 font-semibold">Buchungen</div>
                    <div class="text-gray-500 text-sm">Warenein- und -ausgänge buchen</div>
                </a>
                <a href="{{ route('sales.index') }}"
                   class="bg-white p-6 rounded-xl shadow border-2 border-transparent hover:border-teal-500 hover:shadow-md transition">
                    <div class="text-teal-700 font-semibold">Kasse</div>
                    <div class="text-gray-500 text-sm">Verkäufe ansehen</div>
                </a>
                <a href="{{ route('reservations.index') }}"
                   class="bg-white p-6 rounded-xl shadow border-2 border-transparent hover:border-teal-500 hover:shadow-md transition">
                    <div class="text-teal-700 font-semibold">Reservierungen</div>
                    <div class="text-gray-500 text-sm">Reservierungen verwalten</div>
                </a>
                <a href="{{ route('reports.z') }}"
                   class="bg-white p-6 rounded-xl shadow border-2 border-transparent hover:border-teal-500 hover:shadow-md transition">
                    <div class="text-teal-700 font-semibold">Z-Bericht</div>
                    <div class="text-gray-500 text-sm">Tagesabschluss ansehen</div>
                </a>
            </div>
        @endif
    </div>
</x-app-layout>

