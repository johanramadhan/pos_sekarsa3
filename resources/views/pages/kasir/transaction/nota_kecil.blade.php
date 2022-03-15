<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Nota Kecil</title>


    <?php
    $style = '
    <style>
        * {
            font-family: "consolas", sans-serif;
        }
        p {
            display: block;
            margin: 3px;
            font-size: 13pt;
        }
        table td {
            font-size: 12pt;
        }
        .text-center {
            text-align: center;
        }
        .text-right {
            text-align: right;
        }

        @media print {
            @page {
                margin: 0;
    ';
    ?>
    <?php 
    $style .= 
        ! empty($_COOKIE['innerHeight'])
            ? $_COOKIE['innerHeight'] .'mm; }'
            : '}';
    ?>
    <?php
    $style .= '
            html, body {
                width: 65mm;
            }
            .btn-print {
                display: none;
            }
        }
    </style>
    '; 
    ?>

    {!! $style !!}
</head>
<body onload="window.print()">
    <button class="btn-print" style="position: absolute; right: 1rem; top: 1rem;" onclick="window.print()">Print</button>
    <div class="text-center">
        <img src="{{ Storage::url($setting->first()->path_logo ?? 'tidak ada foto') }} " alt="{{ $setting->path_logo }}" width="150">
        <h3 style="margin-bottom: 5px;">{{ strtoupper($setting->name) }}</h3>
        <p>{{ strtoupper($setting->address) }}</p>
    </div>
    <br>
    <div>
        <p style="float: left;">{{ date('d-m-Y') }}</p>
        <p style="float: left;">{{ date('H:i') }} WIB</p>
        <p style="margin: 0;">{{ strtoupper(auth()->user()->bidang) }}</p>
    </div>
    <div class="clear-both" style="clear: both;"></div>
    <p style="margin: 0;">No: {{ $penjualan->code }}</p>
    <p style="margin: 0;">Name: {{ $penjualan->customer_name }}</p>
    <p style="margin: 0;" class="text-center m-0">===================================</p>
    
    <br>
    <table width="100%" style="border: 0;">
        @foreach ($detail as $item)
            <tr>
                <td colspan="3">{{ $item->produk->name_product }}</td>
            </tr>
            <tr>
                @if (($item->diskon) === 0)
                    <td>{{ $item->jumlah }} x {{ format_uang($item->harga_jual) }}</td>
                @else                    
                    <td>{{ $item->jumlah }} x ({{ format_uang($item->harga_jual) }} - {{ format_uang($item->diskon) }})</td>
                @endif
                <td></td>
                <td class="text-right">{{ format_uang(($item->harga_jual - ($item->harga_jual * $item->diskon / 100)) * $item->jumlah) }}</td>
            </tr>
        @endforeach
    </table>
    <p class="text-center">-------------------------</p>

    <table width="100%" style="border: 0;">
        <tr>
            <td>Total Harga:</td>
            <td class="text-right">{{ format_uang($penjualan->total_harga) }}</td>
        </tr>
        <tr>
            <td>Total Item:</td>
            <td class="text-right">{{ format_uang($penjualan->total_item) }}</td>
        </tr>
        <tr>
            @if (($penjualan->diskon) === 0)
            @else
            <td>Diskon:</td>
            <td class="text-right">-{{ format_uang($penjualan->diskon) }}</td>
            @endif
        </tr>
        <tr>
            <td>Total Bayar:</td>
            <td class="text-right">{{ format_uang($penjualan->bayar) }}</td>
        </tr>
        <tr>
            <td>Diterima:</td>
            <td class="text-right">{{ format_uang($penjualan->diterima) }}</td>
        </tr>
        <tr>
            <td>Kembali:</td>
            <td class="text-right">{{ format_uang($penjualan->diterima - $penjualan->bayar) }}</td>
        </tr>
    </table>

    <p class="text-center">===================================</p><br><br><br>
    <p class="text-center">INSTAGRAM <br>-- sekarsa_coffee --</p> <br><br>
    <p class="text-center" style="color: white">----</p> <br><br><br>

    <script>
        let body = document.body;
        let html = document.documentElement;
        let height = Math.max(
                body.scrollHeight, body.offsetHeight,
                html.clientHeight, html.scrollHeight, html.offsetHeight
            );

        document.cookie = "innerHeight=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
        document.cookie = "innerHeight="+ ((height + 50) * 0.264583);
    </script>
</body>
</html>