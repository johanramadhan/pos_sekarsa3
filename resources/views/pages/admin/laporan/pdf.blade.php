<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Laporan Pendapatan</title>
    
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

</head>

<style>
  table, th, td {
    border: 1px solid black;
  }

  th {
    background-color: #2c2e92;
    color: white;
  }

  td {
    vertical-align: top;
  }
  .cover {
    margin-top: 70px;
    font-size: 18px;
  }
  .table {
    width: 100%;
    font-size: 12px;
    
  }

  .page-break {
    page-break-after: always;
  }
</style>

<body>
    <h4 class="text-center text-uppercase">Laporan Penjualan <br>Sekarsa Coffee & Space</h4>
    <h5 class="text-center text-uppercase">
        Tanggal {{ tanggal_indonesia($awal, false) }}
        s/d
        Tanggal {{ tanggal_indonesia($akhir, false) }}
    </h5>

    <table class="table table-striped">
        <thead>
            <tr>
                <th width="5%" class="text-center">No</th>
                <th class="text-center">Tanggal</th>
                <th class="text-center">Menu</th>
                <th class="text-center">Penjualan</th>
                <th class="text-center">Pendapatan</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $row)
                <tr>
                    @foreach ($row as $col)
                        <td>{{ $col }}</td>
                    @endforeach
                </tr>
            @endforeach
        </tbody>
    </table>

    <table width="100%" style="border: 0px;">
        <tr >
            <td class="text-center" width="65%">
                
            </td>
            <td class="text-left text-uppercase p-2" style="font-size: 14px" colspan="3">
                <b>Chief Executive Officier <br>Sekarsa Coffee & Space</b>
                <br>
                <br>
                <br>
                Rahmat Saputra
            </td> 
        </tr>
    </table>
    
</body>
</html> 