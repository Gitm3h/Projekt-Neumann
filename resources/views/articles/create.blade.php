<x-app-layout>
    <x-slot name="header">
        <h2 class="font semibold text-xl text-gray-800 leading tight">
            Neuer Artikel
        </h2>
    </x-slot>
    <div class="max-w-7xl mx-auto py-6 px-4">
        <form action="{{ route('articles.store') }}" method="POST"
        class="bg-white p-6 rounded shadow space-y-4">

            @csrf
            <div><input name="name" placeholder="Bezeichnung" class="w-full border rounded p-2"></div>
            <div><input name="type" placeholder="Art" class="w-full border rounded p-2"></div>
            <div><input name="price" placeholder="Preis in EUR" class="w-full border rounded p-2"></div>
            <div><input name="min_stock" placeholder="Mindestbestand" class="w-full border rounded p-2"></div>
            <button class="px-4 py-2 bg-teal-700 text white rounded">Speichern</button>
        </form>
    </div>
</x-app-layout>
