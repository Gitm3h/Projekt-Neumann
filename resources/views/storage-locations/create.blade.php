<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800">Neuer Lagerplatz</h2>
    </x-slot>
    <div class="max-w-3xl mx-auto py-6 px-4">
        <form action="{{ route('storage-locations.store') }}" method="POST"
              class="bg-white p-6 rounded shadow space-y-4">
            @csrf
            <div>
                <label class="block mb-1">Name</label>
                <input name="name" class="w-full border rounded p-2">
            </div>
            <button class="px-4 py-2 bg-teal-700 hover:bg-teal-800 transition
                     text-white rounded">Speichern</button>
        </form>
    </div>
</x-app-layout>
