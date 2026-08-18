<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800">Lagerplätze</h2>
    </x-slot>

    <div class="max-w-7xl mx-auto py-6 px-4">
        <!-- Create Button -->
        <a href="{{ route('storage-locations.create') }}"
           class="inline-block mb-4 px-4 py-2 bg-teal-700 hover:bg-teal-800 transition text-white rounded">
            + Neuer Lagerplatz
        </a>

        <!-- Data Table -->
        <table class="w-full bg-white rounded shadow">
            <thead>
            <tr class="text-left border-b">
                <th class="p-3">Name</th>
                <th class="p-3">Belegung</th>
                <th class="p-3">Aktion</th>
            </tr>
            </thead>
            <tbody>
            @forelse ($locations as $location)
                <tr class="border-b">
                    <td class="p-3">
                        <a href="{{ route('storage-locations.show', $location) }}"
                           class="text-teal-700 hover:underline">{{ $location->name }}</a>

                    </td>

                    <!-- Stock Count Column -->
                    <td class="p-3">{{ $location->stocks_count }} Artikel</td>

                    <!-- Actions Column -->
                    <td class="p-3">
                        <!-- Edit Link -->
                        <a href="{{ route('storage-locations.edit', $location) }}"
                           class="text-teal-700 hover:text-teal-800">
                            Bearbeiten
                        </a>

                        <!-- Delete Modal -->
                        <button type="button" x-data
                                @click="$dispatch('open-modal', 'delete-location-{{ $location->id }}')"
                                class="text-red-600 hover:text-red-700 ml-2">Löschen</button>

                        <x-modal name="delete-location-{{ $location->id }}" :show="false" maxWidth="md">
                            <div class="p-6">
                                <h2 class="text-lg font-semibold text-gray-800">Lagerplatz löschen?</h2>
                                <p class="mt-2 text-sm text-gray-600">
                                    "{{ $location->name }}" wird dauerhaft gelöscht. Das lässt sich nicht rückgangig machen.
                                </p>
                                <div class="mt-6 flex justify-end gap-2">
                                    <button type="button" x-on:click="$dispatch('close')"
                                            class="px-4 py-2 bg-gray-200 hover:bg-gray-300 rounded">Abbrechen</button>
                                    <form action="{{ route('storage-locations.destroy', $location) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded">Löschen</button>
                                    </form>
                                </div>
                            </div>
                        </x-modal>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="3" class="p-3 text-gray-500">Noch keine Lagerplätze.</td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>
</x-app-layout>
