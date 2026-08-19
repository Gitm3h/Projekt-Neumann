<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">
            Niedrigbestand
        </h2>
    </x-slot>

    <div class="max-w-3xl mx-auto py-6 px-4 ">
        @if ($artikel->isEmpty())
            <div class="bg-white p-6 rounded shadow p-6 text-gray-600">
            <p>Kein Artikel unter Mindestbestand.</p></div>
        @else
            <div class="bg-white rounded shadow overflow-hidden">
                <table class="w-full table-fixed">
                    <thead>
                        <tr class="bg-teal-700 text-white">
                            <th class="p-3 font-semibold text-left">Artikel</th>
                            <th class="p-3 font-semibold w-32 text-right">Bestand</th>
                            <th class="p-3 text-right font-semibold w-40">Mindestbestand</th>
                            <th class="p-3  text-right font-semibold w-28">Fehlmenge</th>
                        </tr>
                    </thead>
                    <tbody>

                        @foreach ($artikel as $a)
                            @php $bestand = $a->stocks->sum('quantity');
                            @endphp
                            <tr class="border-b border-gray-100">
                                <td class="p-3 truncate">{{ $a->name }}</td>
                                <td class="p-3 text-right font-bold text-red-600">{{ $bestand }}</td>
                                <td class="p-3 text-right">{{ $a->min_stock }}</td>
                                <td class="p-3 text-right text-gray-600">{{ max($a->min_stock - $bestand, 0) }}</td>
                            </tr>
                      @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</x-app-layout>
