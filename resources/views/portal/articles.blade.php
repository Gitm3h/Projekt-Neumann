<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Artikel reservieren
        </h2>
    </x-slot>
    <div class="max-w-7xl mx-auto py-6 px-4 space-y-4">
        <a href="{{ route('portal.index') }}"
           class="text-teal-700 hover:underline text-sm">&larr; Zurück zum Portal</a>
        @if(session('status'))
            <p class="text-teal-700">{{ session('status') }}</p>
        @endif

        @error('items')
            <p class="text-red-600">{{ $message }}</p>
        @enderror

        <form action="{{ route('portal.reserve') }}" method="POST"
              class="bg-white rounded shadow p-6 space-y-4">
            @csrf
            <table class="w-full">
                <thead><tr class="text-left border-b">
                    <th class="p-2">Artikel</th>
                    <th class="p-2">Menge</th>
                    <th class="p-2"></th>
                </tr></thead>
                <tbody id="cart-body">
                    <tr class="border-b">
                        <td class="p-2">
                            <select name="items[0][article_id]" class="border rounded p-2 w-full">
                                <option value="">-- Artikel wählen --</option>
                                @foreach($articles as $article)
                                    <option value="{{ $article->id }}">
                                        {{ $article->name }} (Bestand: {{ $article->stocks->sum('quantity') }})
                                    </option>
                                @endforeach
                            </select>
                        </td>
                        <td class="p-2">
                            <input type="number" name="items[0][quantity]" min="1" value="1" class="w-24 border rounded p-2">
                        </td>
                        <td class="p-2">
                            <button type="button" class="remove-row text-red-600">&times;</button>
                        </td>
                    </tr>
                </tbody>
            </table>
            <button type="button" id="add-row"
                    class="px-3 py-2 bg-gray-200 rounded">+ Artikel</button>
            <div>
                <button class="px-4 py-2 bg-teal-700 text-white rounded">Reservieren</button>
            </div>
        </form>
    </div>
    <script>
        let index = 1;
        const body = document.getElementById('cart-body');

        document.getElementById('add-row').addEventListener('click', function(){
            const clone = body.querySelector('tr').cloneNode(true);
            clone.querySelectorAll('[name]').forEach(function (el) {
                el.name = el.name.replace(/\[\d+\]/, '[' + index + ']');
                if (el.tagName === 'SELECT') el.selectedIndex = 0;
                if (el.type === 'number') el.value = 1;
            });
            body.appendChild(clone);
            index++;
        });

        body.addEventListener('click', function (e) {
            if (e.target.classList.contains('remove-row')) {
                if (body.querySelectorAll('tr').length > 1) e.target.closest('tr').remove();
            }
        });
    </script>
</x-app-layout>
