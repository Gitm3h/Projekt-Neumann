<!DOCTYPE html>
    <html>
        <head>
            <meta charset="utf-8">
            <style>
                body { font-family: DejaVu Sans, sans-serif; font-size: 12px; color: #1f2937; }
                .brand { font-size: 20px; font-weight: bold; color: #0f766e; }
                .sub { font-size: 10px; color: #6b7280; }
                h2 { color: #0f766e; font-size: 16px; margin: 18px 0 6px; }
                table { width: 100%; border-collapse: collapse; margin-top: 8px; }
                th, td { border-bottom: 1px solid #ddd; padding: 6px 8px; text-align: left; }
                th { background: #0f766e; color: #fff; }
                .right { text-align: right; }
            </style>
        </head>
            <body>
                    <div class="brand">Speition Neumann GmbH</div>
                    <div class="sub">Hafenstraße 48 . 20457 Hamburg</div>

                <h2>Z-Bericht (Tagesabschluss)</h2>

                    <p>Datum: <b>{{ \Carbon\Carbon::parse($datum)->format('d.m.Y') }}</b></p>
                    <p>Anzahl Verkäufe: <b>{{ $anzahl }}</b></p>
                    <p>Tagesumsatz: <b>{{ number_format($umsatz, 2, ',', '.') }} EUR</b></p>

                <h2>Nach Zahlart</h2>

                    <table>
                        <tr><th>Zahlart</th><th class="right">Summe</th></tr>
                        @foreach($nachZahlart as $art => $summe)
                            <tr><td>{{ $art }}</td><td class="right">{{ number_format($summe, 2, ',', '.') }} EUR</td></tr>
                        @endforeach
                    </table>

                <h2>Niedriger Lagerbestand</h2>

                    <table>
                        <tr><th>Artikel</th><th class="right">Bestand</th><th class="right">Mindestbestand</th></tr>
                        @forelse($niedrig as $a)
                            <tr>
                                <td>{{ $a->name }}</td>
                                <td class="right">{{ $a->stocks->sum('quantity') }}</td>
                                <td class="right">{{ $a->min_stock }}</td>
                            </tr>
                        @empty
                            <tr><td colspan="3">Alle Artikel über Mindestbestand</td> </tr>
                        @endforelse
                    </table>

                <p style="margin-top:30px;" class="sub">Erstellt am {{ now()->format('d.m.Y H:i') }} Uhr</p>

            </body>
    </html>
