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
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</x-app-layout>
