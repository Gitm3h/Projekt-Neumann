<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">Lieferungen</h2>
    </x-slot>

    <div class="max-w-5xl mx-auto mt-8 py-6 px-4 bg-white py-6 rounded shadow">
        <table class="w-full">
                <thead><tr class="text-left border-b">
                    <th class="p-3">Artikel</th>
                    <th class="p-3">Menge</th>
                    <th class="p-3">Datum</th>
                    <th class="p-3">Erfasst von</th>
                </tr></thead>

            <tbody>
                @forelse($lieferungen as $l)
                    <tr class="border-b">
                        <td class="p-3"> {{ $l->article->name }} </td>
                        <td class="p-3"> {{ $l->quantity }} </td>
                        <td class="p-3"> {{ $l->date }} </td>
                        <td class="p-3"> {{ $l->user->name }} </td>
                    </tr>

                @empty

                    <tr><td colspan="4" class="p-3 text-gray-500">Keine Lieferungen erfasst.</td></tr>

                @endforelse
            </tbody>
        </table>
    </div>
</x-app-layout>
