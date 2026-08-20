<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">Reservierungen</h2>
    </x-slot>
    <div class="max-w-7xl mx-auto py-6 px-4">
        <table class="w-full bg-white rounded shadow">
            <thead>
            <tr class="text-left border-b">
                <th class="p-3">Kunde</th>
                <th class="p-3">Artikel</th>
                <th class="p-3">Status</th>
                <th class="p-3">Aktion</th>
            </tr>
            </thead>
            <tbody>
            @foreach($reservations as $r)
                <tr class="border-b align-top">
                    <td class="p-3">{{ $r->customer->name }}</td>
                    <td class="p-3">
                        @foreach ($r->items as $item)
                            <div>{{ $item->article->name }} &times; {{ $item->quantity }}</div>
                        @endforeach
                    </td>
                    <td class="p-3">{{ $r->status }}</td>
                    <td class="p-3">
                        <div class="flex items-center gap-4">
                            <!-- Status Dropdown -->
                            <form action="{{ route('reservations.update', $r) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <select name="status" onchange="this.form.submit()"
                                        class="w-40 border rounded px-3 py-2">
                                    <option value="reserviert" @selected($r->status === 'reserviert')>reserviert</option>
                                    <option value="abgeholt" @selected($r->status === 'abgeholt')>abgeholt</option>
                                    <option value="storniert" @selected($r->status === 'storniert')>storniert</option>
                                </select>
                            </form>

                            <!-- Delete Button - Only for abgeholt or storniert -->
                            @if($r->status === 'abgeholt' || $r->status === 'storniert')
                                <button type="button" x-data
                                        @click="$dispatch('open-modal', 'delete-reservation-{{ $r->id }}')"
                                        class="text-red-600 hover:text-red-700">
                                    Löschen
                                </button>

                                <!-- Delete Confirmation Modal -->
                                <x-modal name="delete-reservation-{{ $r->id }}" :show="false" maxWidth="md">
                                    <div class="p-6">
                                        <h2 class="text-lg font-semibold text-gray-800">Reservierung löschen?</h2>
                                        <p class="mt-2 text-sm text-gray-600">
                                            Reservierung von "{{ $r->customer->name }}" vom {{ \Carbon\Carbon::parse($r->date)->format('d.m.Y') }}
                                            wird dauerhaft gelöscht. Das lässt sich nicht rückgängig machen.
                                        </p>
                                        <div class="mt-6 flex justify-end gap-2">
                                            <button type="button" x-on:click="$dispatch('close')"
                                                    class="px-4 py-2 bg-gray-200 hover:bg-gray-300 rounded">
                                                Abbrechen
                                            </button>
                                            <form action="{{ route('reservations.destroy', $r) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded">
                                                    Löschen
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </x-modal>
                            @endif
                        </div>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</x-app-layout>
