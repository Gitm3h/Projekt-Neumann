<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Kategorien
        </h2>
    </x-slot>
    <div class="max-w-7xl mx-auto py-6 px-4">
        @if (session('success'))
            <p class="mb-3 text-teal-700">{{ session('success') }}</p>
        @endif

        <a href="{{ route('categories.create') }}"
           class="inline-block mb-4 px-4 py-2 bg-teal-700 hover:bg-teal-800 transition text-white rounded">
            + Neue Kategorie
        </a>

        <form method="GET" class="mb-4">
            <input name="suche" value="{{ request('suche') }}" placeholder="Bezeichnung oder Art" class="border rounded p-2">
            <button class="px-3 py-2 bg-teal-700 hover:bg-teal-800 transition text-white rounded">Suchen</button>
        </form>

        <table class="w-full bg-white rounded shadow">
            <thead><tr class="text-left border-b">
                <th class="p-3">Name</th>
                <th class="p-3">Aktion</th>
            </tr>
            </thead>
            <tbody>
            @forelse ($categories as $category)
                <tr class="border-b">
                    <td class="p-3">{{ $category->name }}</td>
                    <td class="p-3"><a href="{{ route('categories.edit', $category) }}" class="text-teal-700 hover:text-teal-800 mr-3">Bearbeiten</a>
                        <form action="{{ route('categories.destroy', $category) }}"
                              method="POST" class="inline" onsubmit="return confirm('Kategorie löschen?')">

                            @csrf
                            @method('DELETE')
                            <button class="text-red-600 hover:text-red-700">Löschen</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="2" class="p-3 text-gray-500">Noch keine Kategorien vorhanden.</td>
                </tr>
            @endforelse
            </tbody>
        </table>

    </div>
</x-app-layout>
