<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Benutzerverwaltung
        </h2>
    </x-slot>
    <div class="max-w-7xl mx-auto py-6 px-4">
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
                        <form action="{{ route('users.destroy', $user) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button onclick="return confirm('Nutzer wirklich löschen?')" class="text-red-600 hover:text-red-700">
                                Löschen
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

