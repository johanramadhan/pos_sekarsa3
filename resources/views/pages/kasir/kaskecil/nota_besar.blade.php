<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Nota Kas Kecil</title>

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
            <td>Kode Kas Kecil</td>
            <td>: {{ $kaskecil->code ?? 'Umum' }}</td>
        </tr>
    </table>

    <h3 class="text-center">BUKTI MASUK KAS KECIL</h3>
    <table class="data" width="100%">
        <thead>            
            <tr>
                <th>No</th>
                <th>Uraian</th>
                <th>Jenis Uang</th>
                <th>Jumlah</th>
                <th>Satuan</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($detail as $item)
                <tr>
                    <td class="text-center">{{ $loop->iteration }}</td>
                    <td>{{ $item->uraian }}</td>
                    <td class="text-right">Rp{{ format_uang($item->jenis_uang) }}</td>
                    <td class="text-center">{{ format_uang($item->jumlah) }}</td>
                    <td class="text-center">{{ $item->satuan }}</td>
                    <td class="text-right">Rp{{ format_uang($item->subtotal) }}</td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td colspan="5" class="text-right"><b>Total Kas Kecil</b></td>
                <td class="text-right"><b>Rp{{ format_uang($kaskecil->kredit) }}</b></td>
            </tr>
        </tfoot>
    </table> <br><br>

    <table width="100%">
        <tr>
            <td class="text-center" width="50%">
                <b>Menyetujui</b>
                <br>
                <br>
                <br>
                Divisi Keuangan
            </td>
            <td class="text-center" width="50%">
                <b>Kasir</b>
                <br>
                <br>
                <br>
                {{ auth()->user()->name }}
            </td>
        </tr>
        <tr>
            <td class="text-center" colspan="3">
                <b>Mengetahui</b>
                <br>
                <br>
                <br>
                Kepala Direktur 
            </td>            
        </tr>
    </table>
</body>
</html>