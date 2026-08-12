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
    <p>Rechnung Nr. {{ $sale->id }}<br>
        Datum: {{ \Carbon\Carbon::parse($sale->date)->format('d.m.Y') }}
    </p>

    <table>
        <tr>
            <th>Artikel</th><th class="r">Menge</th>
            <th class="r">Einzelpreis</th><th class="r">Summe</th>
        </tr>

        @foreach ($sale->items as $item)
            @php $sum = $item->unit_price * $item->quantity;
            @endphp
            <tr>
                <td>{{ $item->article->name }}</td>
                <td class="r">{{ $item->quantity }}</td>
                <td class="r">{{ number_format($item->unit_price, 2, ',', '.') }} EUR</td>
                <td class="r">{{ number_format($sum, 2, ',', '.') }} EUR</td>
            </tr>
        @endforeach

        <tr>
            <td colspan="3" class="r tot">Gesamt</td>
            <td class="r tot">{{ number_format($sale->total, 2, ',', '.') }} EUR</td>
        </tr>
    </table>

</body>
</html>
