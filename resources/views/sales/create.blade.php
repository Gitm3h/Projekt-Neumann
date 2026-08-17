<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Neuer Verkauf
        </h2>
    </x-slot>
    <div class="max-w-7xl mx-auto py-6 px-4">
        <form action="{{ route('sales.store') }}" method="POST"
              class="bg-white p-6 rounded shadow space-y-4">

            @csrf
            <div id="positionen" class="space-y-4">
                <div class="position flex gap-2">
                    <select name="items[0][article_id]" class="flex-1 border rounded p-2">
                        <option value="">-- Artikel wählen --</option>
                        @foreach ($articles as $article)
                            <option value="{{ $article->id }}">{{ $article->name }} ({{$article->price}} EUR)</option>
                        @endforeach
                    </select>
                    <input name="items[0][quantity]" type="number" min="1" value="1" class="w-full border rounded p-2">
                </div>
            </div>

            <button type="button" id="addRow" class="px-3 py-1 bg-teal-500 hover:bg-teal-600 transition text-white rounded">+ Artikel</button>

            <div>
                <label class="block mb-1">Zahlart</label>
                <select name="payment_method" class="w-full border rounded p-2">
                    <option value="Bar">Bar</option>
                    <option value="Karte">Karte</option>
                    <option value="Rechnung">Rechnung</option>
                </select>
            </div>

            <div>
                <label class="block mb-1">Kunde (Pflicht bei Zahlart Rechnung)</label>
                <select name="customer_id" class="w-full border rounded p-2">
                    <option value="">Barverkauf</option>
                    @foreach ($customers as $customer)
                        <option value="{{ $customer->id }}">{{ $customer->name }} ({{ $customer->type }})</option>
                    @endforeach
                </select>

                @error('customer_id')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror

            </div>

            <div>
                <label class="block mb-1">Zahlungsziel in Tagen (bei Rechnung/gewerblich)</label>
                <input name="payment_term_days" type="number" min="1" value="14" class="w-full border rounded p-2.">
            </div>


            <button class="px-4 py-2 bg-teal-700 hover:bg-teal-800 transition text-white rounded">Verkauf buchen</button>

        </form>
    </div>
    <script>
        let index = 1;

        document.getElementById('addRow').addEventListener('click', function()
        {
            const container = document.getElementById('positionen');
            const clone = container.querySelector('.position').cloneNode(true);

            clone.querySelectorAll('select, input').forEach(function (feld)
            {
                feld.name = feld.name.replace('[0', '[' + index + ']');
                if (feld.tagName === 'SELECT') feld.selectedIndex = 0;
                if (feld.tagName === 'INPUT') feld.value = 1;
            });

            container.appendChild(clone);
            index++;
        });
    </script>
</x-app-layout>
