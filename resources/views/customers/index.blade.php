<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Kundenverwaltung
        </h2>
    </x-slot>
    <div class="max-w-7xl mx-auto py-6 px-4">
        @if (session('status'))
            <p class="mb-3 text-teal-700">{{ session('status') }}</p>
        @endif
        <a href="{{ route('customers.create') }}"
           class="inline-block mb-4 px-4 py-2 bg-teal-700 hover:bg-teal-800 transition text-white rounded">
            + Neuer Kunde
        </a>

        <table class="w-full bg-white rounded shadow">
            <thead><tr class="text-left border-b">
                <th class="p-3">Name</th>
                <th class="p-3">Art</th>
                <th class="p-3">Ort</th>
                <th class="p-3">Aktion</th>
            </tr></thead>
            <tbody>
                @forelse ($customers as $customer)
                    <tr class="border-b">
                        <td class="p-3">{{ $customer->name }}</td>
                        <td class="p-3">{{ $customer->type }}</td>
                        <td class="p-3">{{ $customer->city }}</td>
                        <td class="p-3">
                            <a href="{{ route('customers.edit', $customer) }}"
                               class="text-teal-700 hover:text-teal-800 mr-3">Bearbeiten</a>

                            <button type="button" x-data
                                    @click="$dispatch('open-modal', 'delete-customer-{{ $customer->id }}')"
                                    class="text-red-600 hover:text-red-700">Löschen</button>

                            <x-modal name="delete-customer-{{ $customer->id }}" :show="false" maxWidth="md">
                                <div class="p-6">
                                    <h2 class="text-lg font-semibold text-gray-800">Kunde wirklich löschen?</h2>
                                    <p class="mt-2 text-sm text-gray-600">
                                        "{{ $customer->name }}" und dessen Portal-Login werden dauerhaft gelöscht.
                                    </p>
                                    <div class="mt-6 flex justify-end gap-2">
                                        <button type="button" x-on:click="$dispatch('close')" class="px-4 py-2 bg-gray-200 hover:bg-gray-300 rounded">
                                            Abbrechen
                                        </button>
                                        <form action="{{ route('customers.destroy', $customer) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded">Löschen</button>
                                        </form>
                                    </div>
                                </div>
                            </x-modal>
                            <form action="{{ route('customers.reset', $customer) }}" method="POST" class="inline">
                                @csrf
                                @method('PATCH')
                                <button onclick="return confirm('Passwort wirklich zurücksetzen?')"
                                        class="text-amber-600 hover:text-amber-700 ml-6">Passwort zurücksetzen</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="p-3 text-gray-500">Noch keine Kunden vorhanden</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</x-app-layout>
