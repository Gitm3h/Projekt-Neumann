<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Meine Reservierungen
        </h2>
    </x-slot>
    <div class="max-w-7xl mx-auto py-6 px-4 space-y-4">
        <a href="{{ route('portal.index') }}"
           class="text-teal-700 hover:underline text-sm">&larr; Zurück zum Portal</a>

        @if(session('status'))
            <p class="text-teal-700">{{ session('status') }}</p>
        @endif

        @if ($reservations->isEmpty())
            <p class="text-gray-500">Sie haben noch keine Reservierungen</p>
        @else
            @foreach ($reservations as $r)
                <div class="bg-white rounded shadow px-4 space-y-3">
                    <div class="flex justify-between border-b pb-2">
                        <span class="text-sm text-gray-500">
                            {{ \Carbon\Carbon::parse($r->date)->format('d.m.Y') }}
                        </span>
                        <span class="text-sm font-semibold">{{ $r->status }}</span>
                    </div>

                    <table class="w-full">
                        @foreach ($r->items as $item)
                            <tr class="border-b">
                                <td class="py-2">{{ $item->article->name }}</td>
                                <td class="p-2 w-72 text-right">
                                    @if ($r->status === 'reserviert')
                                        <form action="{{ route('portal.items.update', $item) }}"
                                        method="POST" class="flex gap-2 justify-end">
                                            @csrf
                                            @method('PATCH')
                                            <input type="number" name="quantity" min="1" value="{{ $item->quantity }}"
                                            class="w-20 border rounded p-1">
                                            <button class="px-3 py-1 bg-teal-700 text-white rounded text-sm">Menge speichern</button>
                                        </form>
                                    @else
                                    <span class="text-gray-600">Menge: {{ $item->quantity }}</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </table>

                    @if ($r->status === 'reserviert')
                        <form action="{{ route('portal.reservations.cancel', $r) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <button class="text-red-600 hover:underline text-sm">Reservierung stornieren</button>
                        </form>
                    @endif
                </div>
            @endforeach
        @endif
    </div>
</x-app-layout>
