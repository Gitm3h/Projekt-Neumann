<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800">Dashboard</h2>
    </x-slot>

    <div class="max-w-7xl mx-auto py-6 px-4 space-y-6">
        <p class="text-lg">Willkommen zurück, {{ auth()->user()->name }}!</p>

        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
            <a href="{{ route('articles.index') }}"
               class="bg-white p-6 rounded shadow hover:shadow-md transition">
                <div class="text-teal-700 font-semibold">Artikel</div>
                <div class="text-gray-500 text-sm">Artikel verwalten</div>
            </a>

            <a href="{{ route('stock.index') }}"
               class="bg-white p-6 rounded shadow hover:shadow-md transition">
                <div class="text-teal-700 font-semibold">Lager</div>
                <div class="text-gray-500 text-sm">Bestände ansehen</div>
            </a>

            <a href="{{ route('stock.index') }}"
               class="bg-white p-6 rounded shadow hover:shadow-md transition">
                <div class="text-red-600 font-semibold">{{ $lowStock ?? 0 }} Artikel</div>
                <div class="text-gray-500 text-sm">unter Mindestbestand</div>
            </a>
        </div>
    </div>
</x-app-layout>
