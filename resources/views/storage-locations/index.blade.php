<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800">Lagerplätze</h2>
    </x-slot>

    <div class="max-w-7xl mx-auto py-6 px-4">
        <table class="w-full bg-white rounded shadow">
            <thead>
                <tr class="text-left border-b">
                    <th class="p-3">Bezeichnung</th>
                </tr>
            </thead>
            <tbody>
            @foreach($locations as $location)
                <tr class="border-b">
                    <td class="p-3">{{ $location->name }}</td>
                </tr>

            @endforeach
            </tbody>
        </table>
    </div>
</x-app-layout>
