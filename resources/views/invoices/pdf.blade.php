<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        @page { margin: 40px 45px 180px 45px; }
        body { font-family: DejaVu Sans, sans-serif; font-size:12px; color: #1f3437; }
        .header { width:100% }
        .header td { vertical-align: top; width:50% }
        .brand-container { text-align: center; }
        .brand { font-size: 20px; font-weight: bold; color: #0f766e; }
        .slogan { font-size: 10px; color: #6b7280; margin-top: 3px; }
        .company-right { text-align: right; font-size: 10px; color: #374151; line-height: 1.5; }
        .sender-line { font-size: 9px; color: #6b7280; border-bottom: 1px solid #ddd; padding-bottom: 2px; margin-top: 60px; }
        .meta { width: 100% }
        .meta td { vertical-align: top; padding-top: 8px; }
        .content-start { margin-top: 70px; }
        h2 { color:#0f766e; font-size: 16px; margin:0 0 15px; text-transform: uppercase; letter-spacing: 1px; }
        table.items { width: 100%; border-collapse: collapse; }
        table.items th, table.items td { border-bottom: 1px solid #ddd; padding: 6px 8px; }
        table.items th { background: #0f766e; color: #fff; text-align: left; }
        .right { text-align: right; }
        .total { font-weight: bold; }
        .footer { position: fixed; bottom: -140px; left: 0; right: 0; width: 100%; }
        .payment-terms { font-size: 11px; margin-bottom: 20px; color: #1f3437; }
        .footer-table { border-top: 1px solid #ddd; padding-top: 8px; font-size: 9px; color: #6b7280; width: 100%; }
        .footer-table td { vertical-align: top; width: 33%; }
    </style>
</head>

<body>

    <table class="header">
        <tr>
            <td>
                <div class="brand-container">
                <div class="brand">Spedition Neumann GmbH</div>
                <div class="slogan">Effiziente Logistik. Klar. Verlässlich. Norddeutsch.</div>
                </div>
            </td>
            <td class="company-right">
                Hafenstraße 48<br>
                20457 Hamburg<br>
                Tel. 040 / 123 456<br>
                Mail info@spedition-neumann.de
            </td>
        </tr>
    </table>

    <div class="sender-line">Spedition Neumann GmbH · Hafenstraße 48 · 20457 Hamburg</div>

    <table class="meta">
        <tr>
            <td>
                @if ($sale->customer)
                    {{ $sale->customer->name }}<br>
                    {{ $sale->customer->street }} {{ $sale->customer->house_number }}<br>
                    {{ $sale->customer->postal_code }} {{ $sale->customer->city }}
                    @if ($sale->customer->vat_id)<br>USt-IdNr.: {{ $sale->customer->vat_id }}
                    @endif
                @else
                    Barverkauf
                @endif
            </td>
            <td class="right">
                Rechnungs-Nr.: {{ $sale->invoice->invoice_number ?? $sale->id }}<br>
                Datum: {{ \Carbon\Carbon::parse($sale->date)->format('d.m.Y') }}<br>
                @if ($sale->customer)Kundennr.: {{ $sale->customer->id }}
                @endif
            </td>
        </tr>
    </table>

    <div class="content-start">
    <h2>Rechnung</h2>
    <table class="items">
        <tr>
            <th>Pos.</th>
            <th>Bezeichnung</th>
            <th class="right">Menge</th>
            <th class="right">USt-Satz</th>
            <th class="right">Einzelpreis</th>
            <th class="right">Gesamt (netto)</th>
        </tr>

        @php
            $netSum = 0;
            $ustProSatz = [];
        @endphp

        @foreach ($sale->items as $item)
            @php
                $sum = $item->unit_price * $item->quantity;
                $satz = (float) $item->vat_rate;
                $ust = $sum * $satz / 100;
                $netSum += $sum;
                $ustProSatz[(string) $satz] = ($ustProSatz[(string) $satz] ?? 0) + $ust;
            @endphp
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $item->article->name }}</td>
                <td class="right">{{ $item->quantity }}</td>
                <td class="right">{{ rtrim(rtrim(number_format($satz, 2), '0'), '.') }} %</td>
                <td class="right">{{ number_format($item->unit_price, 2, ',', '.') }} EUR</td>
                <td class="right">{{ number_format($sum, 2, ',', '.') }} EUR</td>
            </tr>
        @endforeach

        <tr>
            <td colspan="5" class="right">Nettobetrag</td>
            <td class="right">{{ number_format($netSum, 2, ',', '.') }} EUR</td>
        </tr>
        @foreach ($ustProSatz as $satz => $ust)
        <tr>
            <td colspan="5" class="right">zzgl. {{ rtrim(rtrim(number_format($satz,2), '0'), '.') }} % USt</td>
            <td class="right">{{ number_format($ust, 2, ',', '.') }} EUR</td>
        </tr>
        @endforeach
        <tr>
            <td colspan="5" class="right total">Gesamtbetrag (brutto)</td>
            <td class="right total">{{ number_format($netSum + array_sum($ustProSatz), 2, ',', '.') }} EUR</td>
        </tr>

    </table>

    @if ($sale->invoice && $sale->invoice->due_date)
        <p>Zahlbar bis {{ \Carbon\Carbon::parse($sale->invoice->due_date)->format('d.m.Y') }}
            ({{ $sale->invoice->payment_term_days }} Tage nach Erhalt.)
        </p>
    @else
        <p>Betrag dankend erhalten.</p>
    @endif

    <p>Vielen Dank für Ihren Auftrag.</p>
    </div>

    <div class="footer">
        <table class="footer-table">
        <tr>
            <td>
                <strong>Spedition Neumann GmbH</strong><br>
                Hafenstraße 48<br>
                20457 Hamburg
            </td>
            <td>
                Tel. 040 / 123 456<br>
                info@spedition-neumann.de
            </td>
            <td>
                Bank: Hamburger Sparkasse<br>
                IBAN: DE12 2005 0550 1234 5678 90<br>
                BIC: HASPDEHHXXX
            </td>
        </tr>
        </table>
    </div>

</body>
</html>
