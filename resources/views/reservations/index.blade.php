<x-app-layout>
    <x-slot name="header">
            <h2 class="font-semibold text-xl text-gray-800">Reservierungen</h2>
    </x-slot>


    <div class="max-w-7xl max-auto py-6 px-4">
          <table class="w-full bg-white rounded shadow">
            <thead>
                <tr class="text-left border-b">
                    <th class="p-3">Kunde</th>
                    <th class="p-3">Artikel</th>
                    <th class="p-3">Menge</th>
                    <th class="p-3">Status</th>
                    <th class="p-3">Aktio</th>
                </tr>
            </thead>
            <tbody>
              @foreach($reservations as $r)
                <tr class="border-b">
                    <td class="p-3">{{ $r->customer->name }}</td>
                    <td class="p-3">{{ $r->article->name }}</td>
                    <td class="p-3">{{ $r->quantity }}</td>
                    <td class="p-3">{{ $r->status }}</td>
                    <td class="p-3">
                        <form action="{{route('reservations.update', $r) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <select name="status" onchange="this.form.submit()"
                                    class="border rounded p-1">
                                <option value="reserviert">reserviert</option>
                                <option value="erledigt">erledigt</option>
                                <option value="storniert">storniert</option>
                            </select>
                        </form>
                    </td>
                </tr>
              @endforeach
            </tbody>
          </table>
    </div>
</x-app-layout>
