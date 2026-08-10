<x-app-layout>
    <x-slot name="header">
        <h2 class="font semibold text-xl text-gray-800 leading tight">
            Artikelverwaltung
        </h2>
    </x-slot>
    <div class="max-w-7xl mx-auto py-6 px-4">
        <a href="{{ route('articles.create') }}"
           class="inline-block mb-4 px-4 py-2 bg-teal-700 text-white rounded">
            + Neuer Artikel
        </a>
        <table class="w-full bg-white rounded shadow">
            <thead><tr class="text-left border-b">
                <th class="p-3">Bezeichnung</th>
                <th class="p-3">Art</th>
                <th class="p-3">Preis</th>
                <th class="p-3">Mindestbestand</th>
                <th class="p-3">Aktion</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($articles as $article)
                <tr class="border-b">
                    <td class="p-3">{{ $article->name }}</td>
                    <td class="p-3">{{ $article->type }}</td>
                    <td class="p-3">{{ $article->price }}EUR</td>
                    <td class="p-3">{{ $article->min_stock }}</td>
                    <td class="p-3">
                        <a href="{{ route('articles.edit', $article) }}"
                           class="text-teal-700">Bearbeiten
                        </a>
                        <form action="{{ route('articles.destroy', $article) }}"
                              method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button class="text-red-600 ml-2">Löschen</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
        </table>
    </div>
</x-app-layout>
