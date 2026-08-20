<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">Rechnungen</h2>
    </x-slot>
    <div class="max-w-7xl mx-auto py-6 px-4">
        <table class="w-full bg-white rounded shadow">
            <thead><tr class="text-left border-b">
                <th class="p-3">Nr.</th>
                <th class="p-3">Kunde</th>
                <th class="p-3">Datum</th>
                <th class="p-3">Status</th>
                <th class="p-3">Aktion</th>
            </tr></thead>
            <tbody>
                @foreach ($invoices as $inv)
                    <tr class="border-b">
                        <td class="p-3">{{ $inv->invoice_number }}</td>
                        <td class="p-3">{{ $inv->customer?->name }}</td>
                        <td class="p-3">{{ \Carbon\Carbon::parse($inv->date)->format('d.m.Y') }}</td>
                        <td class="p-3">{{ $inv->status}}</td>
                        <td class="p-3">
                            <div class="flex items-center gap-4">
                                 @if ($inv->sale)
                                     <a href="{{ route('invoices.pdf', $inv->sale) }}" target="_blank" class="text-teal-700 hover:underline">
                                         Rechnung (PDF)
                                     </a>
                                 @endif
                                 @if($inv->status === 'offen')
                                     <form action="{{ route('invoices.paid', $inv) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <button class="text-teal-700 hover:text-teal-800">als bezahlt markieren</button>
                                     </form>
                                     @endif
                                     <button type="button" x-data
                                     @click="$dispatch('open-modal', 'delete-invoice-{{ $inv->id }}')"
                                     class="text-red-600 hover:text-red-700">Löschen</button>

                                     <x-modal name="delete-invoice-{{ $inv->id }}" :show="false" maxWidth="md">
                                         <div class="p-6">
                                             <h2 class="text-lg font-semibold text-gray-800">Rechnung löschen?</h2>
                                             <p class="mt-2 text-sm text-gray-600">
                                                 Rechnung Nr. {{ $inv->invoice_number }} für "{{ $inv->customer?->name }}" wird dauerhaft gelöscht. Das lässt sich nicht rückgängig machen.
                                             </p>
                                             <div class="mt-6 flex justify-end gap-2">
                                                 <button type="button" x-on:click="$dispatch('close')"
                                                         class="px-4 py-2 bg-gray-200 hover:bg-gray-300 rounded">Abbrechen</button>
                                                 <form action="{{ route('invoices.destroy', $inv) }}" method="POST">
                                                     @csrf
                                                     @method('DELETE')
                                                     <button class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded">Löschen</button>
                                                 </form>

                                             </div>
                                         </div>
                                     </x-modal>

                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</x-app-layout>
