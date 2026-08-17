<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Meine Reservierungen
        </h2>
    </x-slot>
    <div class="max-w-7xl mx-auto py-6 px-4 space-y-4">
        <a href="{{ route('portal.index') }}"
           class="text-teal-700 hover:underline text-sm">&larr;
            Zurück zum Portal
        </a>

        @if ($reservations->isEmpty())
            <p class="text-gray-500">Sie haben noch keine Reservierungen</p>
        @else
        <table class="w-full bg-white rounded shadow">
            <thead><tr class="text-left border-b">
                <th class="p-3">Artikel</th>
                <th class="p-3">Menge</th>
                <th class="p-3">Status</th>
                <th class="p-3">Datum</th>
            </tr>
            </thead>
            <tbody>

            @foreach ($reservations as $r)
                <tr class="border-b">
                    <td class="p-3">{{ $r->article->name }}</td>
                    <td class="p-3">{{ $r->quantity }}</td>
                    <td class="p-3">{{ $r->status }}</td>
                    <td class="p-3">{{ \Carbon\Carbon::parse($r->date)->format('d.m.Y') }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
        @endif
    </div>
</x-app-layout>


