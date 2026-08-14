<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size:12px; }
        h1 {color:#0f766e; margin:0; }
        table {width:100%; border-collapse:collapse; margin-top:16px; }
        th, td { border-bottom:1px solid #ddd; padding:6px 8px; }
        th { background:#0f766e; color:#fff; text-align:left; }
        .right {text-align:right; }
        .total { font-weight:bold; }
    </style>
</head>

<body>
    <h1>Spedition Neumann</h1>
    <p>Rechnung Nr. {{ $sale->invoice->invoice_number ?? $sale->id }}<br>
        Datum: {{ \Carbon\Carbon::parse($sale->date)->format('d.m.Y') }}
    </p>

    @if ($sale->customer)
        <p>
            {{ $sale->customer->name }}<br>
            {{ $sale->customer->street }} {{ $sale->customer->house_number }}<br>
            {{ $sale->customer->postal_code }} {{ $sale->customer->city }}
            @if ($sale->customer->vat_id)<br>USt-IdNr.: {{ $sale->customer->vat_id }}
            @endif
            <p>
    @endif

    <table>
        <tr>
            <th>Artikel</th><th class="right">Menge</th>
            <th class="right">Einzelpreis</th><th class="right">Summe</th>
        </tr>

        @php
            $netSum = 0;
            $vatSum = 0;
        @endphp

        @foreach ($sale->items as $item)
            @php
                $sum = $item->unit_price * $item->quantity;
                $vat = $sum * $item->vat_rate / 100;
                $netSum += $sum;
                $vatSum += $vat;
            @endphp
            <tr>
                <td>{{ $item->article->name }}</td>
                <td class="right">{{ $item->quantity }}</td>
                <td class="right">{{ number_format($item->unit_price, 2, ',', '.') }} EUR</td>
                <td class="right">{{ number_format($sum, 2, ',', '.') }} EUR</td>
            </tr>
        @endforeach

        <tr>
            <td colspan="3" class="right">Netto</td>
            <td class="right">{{ number_format($netSum, 2, ',', '.') }} EUR</td>
        </tr>
        <tr>
            <td colspan="3" class="right">zzgl. MwSt</td>
            <td class="right">{{ number_format($vatSum, 2, ',', '.') }} EUR</td>
        </tr>
        <tr>
            <td colspan="3" class="right total">Brutto (Gesamt)</td>
            <td class="right total">{{ number_format($netSum + $vatSum, 2, ',', '.') }} EUR</td>
        </tr>
    </table>

    @if ($sale->invoice && $sale->invoice->due_date)
        <p>Zahlbar bis {{ \Carbon\Carbon::parse($sale->invoice->due_date)->format('d.m.Y') }}
            ({{ $sale->invoice->payment_term_days }} Tage nach Erhalt.)
        </p>
    @endif

</body>
</html>
