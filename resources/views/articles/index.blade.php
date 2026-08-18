<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Artikelverwaltung
        </h2>
    </x-slot>
    <div class="max-w-7xl mx-auto py-6 px-4">
        <a href="{{ route('articles.create') }}"
           class="inline-block mb-4 px-4 py-2 bg-teal-700 hover:bg-teal-800 transition text-white rounded">
            + Neuer Artikel
        </a>

        <form method="GET" class="mb-4">
            <input name="suche" value="{{ request('suche') }}" placeholder="Bezeichnung oder Art" class="border rounded p-2">
            <button class="px-3 py-2 bg-teal-700 hover:bg-teal-800 transition text-white rounded">Suchen</button>
        </form>

        <table class="w-full bg-white rounded shadow">
            <thead><tr class="text-left border-b">
                <th class="p-3">Bezeichnung</th>
                <th class="p-3">Art</th>
                <th class="p-3">Preis</th>
                <th class="p-3">Mindestbestand</th>
                <th class="p-3">Bestand</th>
                <th class="p-3">Aktion</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($articles as $article)
                <tr class="border-b">
                    <td class="p-3"><a href="{{ route('articles.show', $article) }}" class="text-teal-700 hover:text-teal-800 hover:underline">{{ $article->name }}</a></td>
                    <td class="p-3">{{ $article->type }}</td>
                    <td class="p-3">{{ $article->price }}EUR</td>
                    <td class="p-3">{{ $article->min_stock }}</td>
                    <td class="p-3">{{ $article->stocks->sum('quantity') }}</td>
                    <td class="p-3">
                        <a href="{{ route('articles.edit', $article) }}"
                           class="text-teal-700 hover:text-teal-800">Bearbeiten
                        </a>
                        <form action="{{ route('articles.destroy', $article) }}"
                              method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="button" x-data
                            @click="$dispatch('open-modal', 'delete-article-{{ $article->id }}')"
                            class="text-red-600 hover:text-red-700 ml-2">Löschen</button>

                            <x-modal name="delete-article-{{ $article->id }}" :show="false" maxWidth="md">
                                <div class="p-6">
                                    <h2 class="text-lg font-semibold text-gray-800">Artikel löschen?</h2>
                                    <p class="mt-2 text-sm text-gray-600">
                                        "{{ $article->name }}" wird dauerhaft gelöscht. Das lässt sich nicht rückgängig machen.
                                    </p>
                                    <div class="mt-6 flex justify-end gap-2">
                                        <button type="button" x-on:click="$dispatch('close')"
                                                class="px-4 py-2 bg-gray-200 hover:bg-gray-300 rounded">Abbrechen</button>
                                        <form action="{{ route('articles.destroy', $article) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded">Löschen</button>
                                        </form>
                                    </div>
                                </div>
                            </x-modal>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="p-3 text-gray-500">Noch keine Artikel vorhanden.</td>
                </tr>
            @endforelse
        </tbody>
        </table>

        {{ $articles->links() }}
    </div>
</x-app-layout>
