<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Benutzerverwaltung
        </h2>
    </x-slot>
    <div class="max-w-7xl mx-auto py-6 px-4">
        @if (session('status'))
            <p class="mb-3 text-teal-700">{{ session('status') }}</p>
        @endif

        <a href="{{ route('users.create') }}"
           class="inline-block mb-4 px-4 py-2 bg-teal-700 hover:bg-teal-800 transition text-white rounded">
            + Neuer Nutzer
        </a>

        <table class="w-full bg-white rounded shadow">
            <thead><tr class="text-left border-b">
                <th class="p-3">Name</th>
                <th class="p-3">E-Mail</th>
                <th class="p-3">Rolle</th>
                <th class="p-3">Aktion</th>
                </tr>
            </thead>
            <tbody>
            @forelse ($users as $user)
                <tr class="border-b">
                    <td class="p-3">{{ $user->name }}</td>
                    <td class="p-3">{{ $user->email }}</td>
                    <td class="p-3">{{ $user->role }}</td>
                    <td class="p-3">

                        <a href="{{ route('users.edit', $user) }}"
                           class="text-teal-700 hover:text-teal-800 mr-3">
                            Bearbeiten
                        </a>

                        <button type="button" x-data
                                @click="$dispatch('open-modal', 'delete-user-{{ $user->id }}')"
                                class="text-red-600 hover:text-red-700">Löschen?</button>

                        <x-modal name="delete-user-{{ $user->id }}" :show="false" maxWidth="md">
                            <div class="p-6">
                                <h2 class="text-lg font-semibold text-gray-800">Nutzer löschen?</h2>
                                <p class="mt-2 text-sm text-gray-600">
                                    "{{ $user->name }}" wird dauerhaft gelöscht. Das lässt sich nicht rückgängig machen.
                                </p>
                                <div class="mt-6 flex justify-end gap-2">
                                    <button type="button" x-on:click="$dispatch('close')"
                                            class="px-4 py-2 bg-gray-200 hover:bg-gray-300 rounded">Abbrechen</button>
                                    <form action="{{ route('users.destroy', $user) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded">Löschen</button>
                                    </form>
                                </div>
                            </div>
                        </x-modal>

                        <form action="{{ route('users.reset', $user) }}" method="POST" class="inline">
                            @csrf
                            @method ('PATCH')
                            <button onclick="return confirm('Passwort wirklich zurücksetzen?')" class="text-amber-600 hover:text-amber-700 ml-6">
                                Passwort zurücksetzen
                            </button>
                        </form>

                    </td>
                </tr>
            @empty

                <tr>
                    <td colspan="4" class="p-3 text-gray-500">Noch keine Nutzer.</td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>
</x-app-layout>

