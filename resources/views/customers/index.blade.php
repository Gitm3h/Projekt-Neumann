<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Kundenverwaltung
        </h2>
    </x-slot>
    <div class="max-w-7xl mx-auto py-6 px-4">
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
                               class="text-teal-700 hover:text-teal-800">Bearbeiten</a>
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
