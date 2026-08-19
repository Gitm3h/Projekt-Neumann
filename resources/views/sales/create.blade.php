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
            <div id="positionen" class="space-y-3">
                <div class="position flex items-center gap-3">
                    <select name="items[0][article_id]" class="article flex-1 border rounded p-3 text-base">
                        <option value="" data-price="0">-- Artikel wählen --</option>
                        @foreach ($articles as $article)
                            <option value="{{ $article->id }}" data-price="{{ $article->price }}">{{ $article->name }} ({{ number_format($article->price, 2, ',','.') }} EUR)</option>
                        @endforeach
                    </select>
                    <input name="items[0][quantity]" type="number" min="1" value="1" class="quantity w-20 border rounded p-3 text-base">
                    <span class="line-total w-28 text-right font-medium">0,00 EUR</span>
                    <button type="button" class="remove text-red-600 hover:text-red-700 text-2xl leading-none px-2">&times;</button>
                </div>
            </div>

            <button type="button" id="addRow" class="px-4 py-3 text-base bg-teal-500 hover:bg-teal-600 transition text-white rounded">+ Artikel</button>
            <div class="text-right text-lg font-semibold border-t pt-3">
                Gesamt : <span id="grandTotal">0,00 EUR</span>
            </div>

            <div>
                <label class="block mb-1">Zahlart</label>
                <select name="payment_method" class="w-full border rounded p-3 text-base">
                    <option value="Bar">Bar</option>
                    <option value="Karte">Karte</option>
                    <option value="Rechnung">Rechnung</option>
                </select>
            </div>

            <div>
                <label class="block mb-1">Kunde (Pflicht bei Zahlart Rechnung)</label>
                <select name="customer_id" class="w-full border rounded p-3 text-base">
                    <option value="">Barverkauf</option>
                    @foreach ($customers as $customer)
                        <option value="{{ $customer->id }}">{{ $customer->name }} ({{ $customer->type }})</option>
                    @endforeach
                </select>

                @error('customer_id')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror

            </div>

            @error('items')
            <p class="text-red-600 text-sm mb-2">{{ $message }}</p>
            @enderror

            <button class="px-6 py-3 text-lg bg-teal-700 hover:bg-teal-800 transition text-white rounded">Verkauf buchen</button>
        </form>
    </div>

    <script>
        const container = document.getElementById('positionen')
        let index = 1;

        function formatEUR(n) {
            return n.toFixed(2).replace('.', ',') + ' EUR';
        }

        function recalc() {
            let grand = 0;
            container.querySelectorAll('.position').forEach(function(row) {
                const opt = row.querySelector('.article').selectedOptions[0];
                const price = opt ? parseFloat(opt.dataset.price || 0) : 0;
                const qty = parseInt(row.querySelector('.quantity').value || 0);
                const line = price * qty;
                grand +=line;
                row.querySelector('.line-total').textContent = formatEUR(line);
            });
            document.getElementById('grandTotal').textContent = formatEUR(grand);
        }
        document.getElementById('addRow').addEventListener('click', function () {
            const clone = container.querySelector('.position').cloneNode(true);
            clone.querySelectorAll('select, input').forEach(function (feld) {
                feld.name = feld.name.replace(/\[\d+\]/, '[' + index + ']');
                if (feld.tagName === 'SELECT') feld.selectedIndex = 0;
                if (feld.tagName === 'INPUT') feld.value = 1;
            });
            container.appendChild(clone);
            index++;
            recalc();
        });

        container.addEventListener('input', recalc);
        container.addEventListener('change', recalc);

        container.addEventListener('click', function (e){
            if (!e.target.classList.contains('remove')) return;
            const rows = container.querySelectorAll('.position');
            if (rows.length > 1) {
                e.target.closest('.position').remove();
            } else {
                const row = e.target.closest('.position');
                row.querySelector('.article').selectedIndex = 0;
                row.querySelector('.quantity').value = 1;
            }
            recalc();
        });

        recalc();

    </script>
</x-app-layout>
