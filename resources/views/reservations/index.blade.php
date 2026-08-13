<x-app-layout>
    <x-slot name="header">
        @foreach($reservations as $r)
            <table>
                <tr class="border-b">
                    <td class="p-3">{{$r->customer->name }}</td>
                    <td class="p-3">{{$r->article->name}}</td>
                    <td class="p-3">{{$r->quantity }}</td>
                    <td class="p-3">{{$r->status }}</td>
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
            </table>
        @endforeach
    </x-slot>
</x-app-layout>
