<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Nota Pengeluaran</title>

    <style>
        table td {
            /* font-family: Arial, Helvetica, sans-serif; */
            font-size: 14px;
        }
        .data td,
        .data th {
            border: 1px solid;
            padding: 5px;
        }
        .data {
            border-collapse: collapse;
        }
        .text-center {
            text-align: center;
        }
        .text-right {
            text-align: right;
        }
    </style>
</head>
<body>
    <table width="100%">
        <tr>
            <td rowspan="4" width="60%">
                <img src="{{ public_path('images/sekarsa.jpg') }}" alt="{{ $setting->path_logo }}" width="120">
                <br>
                {{ $setting->address }}
                <br>
                <br>
            </td>
            <td>Tanggal</td>
            <td>: {{ tanggal_indonesia(date('Y-m-d')) }}</td>
        </tr>
        <tr>
            <td>Kode Pembelian</td>
            <td>: {{ $pembelian->code ?? 'Umum' }}</td>
        </tr>
    </table>

    <h3 class="text-center">BUKTI PEMBELIAN <br> {{ Str::upper($pembelian->supplier->name) }}</h3>
    <table class="data" width="100%">
        <thead>            
            <tr>
                <th>No</th>
                <th>Kode</th>
                <th>Uraian</th>
                <th>Satuan</th>
                <th>Jumlah</th>
                <th>Harga Satuan</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($detail as $item)
                <tr>
                    <td class="text-center">{{ $loop->iteration }}</td>
                    <td>{{ $item->code }}</td>
                    <td>{{ $item->persediaan->name_persediaan }}</td>
                    <td class="text-center">{{ $item->persediaan->satuan }}</td>
                    <td class="text-center">{{ format_uang($item->jumlah) }}</td>
                    <td class="text-right">Rp{{ format_uang($item->harga_beli) }}</td>
                    <td class="text-right">Rp{{ format_uang($item->subtotal) }}</td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td colspan="6" class="text-right"><b>Total Harga</b></td>
                <td class="text-right"><b>Rp{{ format_uang($pembelian->total_harga) }}</b></td>
            </tr>
            @if (($pembelian->diskon) > 0)
                <tr>
                    <td colspan="6" class="text-right"><b>Diskon</b></td>
                    <td class="text-right"><b>{{ format_uang($pembelian->diskon) }}%</b></td>
                </tr>                              
            @endif
            <tr>
                <td colspan="6" class="text-right"><b>Total Bayar</b></td>
                <td class="text-right"><b>Rp{{ format_uang($pembelian->bayar) }}</b></td>
            </tr>
        </tfoot>
    </table> <br><br>

    <table width="100%">
        <tr>
            <td class="text-center" width="50%">
                <b>Chief Financial Officier</b>
                <br>
                <br>
                <br>
                Wan M Johan Ramadhan
            </td>
            <td class="text-center" width="50%">
                <b>Chief Logistic</b>
                <br>
                <br>
                <br>
                Ceca Junio Damara
            </td>
        </tr>
        <tr>
            <td class="text-center" colspan="3">
                Mengetahui, <br><b>Chie Executive Officier</b>
                <br>
                <br>
                <br>
                Rahmat Saputra
            </td>           
        </tr>
    </table>
</body>
</html>