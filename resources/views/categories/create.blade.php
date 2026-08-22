<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Neue Kategorie
        </h2>
    </x-slot>
    <div class="max-w-7xl mx-auto py-6 px-4">
        <form action="{{ route('categories.store') }}" method="POST"
              class="bg-white p-6 rounded shadow space-y-4">

            @csrf
            @if ($errors->any())
                <div class="mb-4 rounded bg-red-100 p-3 text-red-700">{{ $errors->first() }}</div>
            @endif

            <div>
                <label class="block mb-1">Name</label>
                <input name="name" value="{{ old('name') }}" class="w-full border rounded p-2">
            </div>

            <button class="px-4 py-2 bg-teal-700 hover:bg-teal-800 transition text-white rounded">Speichern</button>
        </form>
    </div>
</x-app-layout>


