<!DOCTYPE html>
    <html>
        <head>
            <meta charset="utf-8">
            <style>
                @page { margin: 40px 45px 120px 45px; }
                body { font-family: DejaVu Sans, sans-serif; font-size:12px; color: #1f3437; }
                .header { width:100% }
                .header td { vertical-align: top; width:50% }
                .brand-container { text-align: center; }
                .brand { font-size: 20px; font-weight: bold; color: #0f766e; }
                .slogan { font-size: 10px; color: #6b7280; margin-top: 3px; }
                .company-right { text-align: right; font-size: 10px; color: #374151; line-height: 1.5; }
                .sender-line { font-size: 9px; color: #6b7280; border-bottom: 1px solid #ddd; padding-bottom: 2px; margin-top: 40px; margin-bottom: 18px; }
                h2 { color:#0f766e; font-size: 15px; margin:18px 0 6px; text-transform: uppercase; letter-spacing: 1px; }
                table { width: 100%; border-collapse: collapse; margin-top: 6px; }
                th, td { border-bottom: 1px solid #ddd; padding: 6px 8px; text-align: left; }
                th { background: #0f766e; color: #fff; }
                .right { text-align: right; }
                .sub { font-size: 9px; color: #6b7280; }
                .footer { position: fixed; bottom: -90px; left: 0; right: 0; width: 100%; }
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

                <div class="footer">
                    <table class="footer-table">
                        <tr>
                            <td>
                                <strong>Spedition Neumann GmbH</strong><br>
                                Hafenstraße 48<br>
                                20457 Hamburg
                            </td>
                        </tr>
                    </table>
                </div>
            </body>
    </html>
