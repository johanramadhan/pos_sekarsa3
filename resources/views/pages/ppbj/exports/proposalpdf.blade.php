<?php
use Illuminate\Support\Facades\Storage;
?>
<html>
<head>
	<title>Rekapitulasi Pengajuan Perbidang</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</head>

<style>
  table, th, td {
    border: 1px solid black;
  }

  th {
    padding: 3px;
    background-color: #2c2e92;
    color: white;
  }

  td {
    padding: 5px;
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

  <div class="text-center" style="margin-top: 200px">
    <img src="{{ public_path('images/logo-sidebar.png') }}" width="200px" >
  </div>
  <div class="position-relative">
    <h5 class="text-center cover">RENCANA KEBUTUHAN BARANG MILIK DAERAH (RKBMD) OLEH BIDANG DAN SUB BAGIAN PADA <br> DINAS PEMADAM KEBAKARAN DAN PENYELAMATAN KOTA PEKANBARU <br> TAHUN ANGGARAN 2021</h5>
  </div>

  <div class="page-break"></div>

  <h6 class="text-center" style="font-size: 14px;">RENCANA KEBUTUHAN BARANG MILIK DAERAH (RKBMD) OLEH BIDANG DAN SUB BAGIAN <br> PADA DINAS PEMADAM KEBAKARAN DAN PENYELAMATAN KOTA PEKANBARU <br> TAHUN ANGGARAN 2021</h6>

  <table class="table" style="border: 1px solid black; font-size: 12px;">
    <thead>
      <tr>
        <th class="text-center">No</th>
        <th class="text-center">Bidang Pengusul</th>
        <th class="text-center">Kategori</th>
        <th class="text-center">Nama Barang</th>
        <th class="text-center">Merek/Type</th>
        <th class="text-center">Kebutuhan Maksimum</th>
        <th class="text-center">Jumlah</th>
        <th class="text-center">Satuan</th>
        <th class="text-center">Harga Satuan</th>
        <th class="text-center">Total Harga</th>
        <th class="text-center">Fungsi</th>
        <th class="text-center">Spesifikasi</th>
        <th class="text-center">Gambar</th>
      </tr>
    </thead>

    <tbody>
      @foreach ($proposals as $item)
        <tr style="line-height: 12px;">
          <td>{{ $loop->iteration }}</td>
          <td>Bidang {{ $item->user->bidang }}</td>
          <td>{{ $item->category->name }}</td>
          <td>{{ $item->name }}</td>
          <td>{{ $item->brand }}</td>
          <td class="text-center">{{ $item->max_requirement }}</td>
          <td class="text-center">{{ $item->qty }}</td>
          <td class="text-center">{{ $item->satuan }}</td>
          <td>{{ number_format($item->price) }}</td>
          <td>{{ number_format($item->total_price) }}</td>
          <td>{{ $item->benefit }}</td>
          <td>{!! $item->description !!}</td>
          <td>
            <img src="{{ public_path("storage/".$item->galleries->first()->photos ?? 'tidak ada foto') }}" style="width: 100px; margin-top:10px;">
          </td>
        </tr>
      @endforeach
      <tr>
        <td colspan="9"><b>Total</b></td>
        <td><b>Rp{{ number_format($total ?? '') }}</b></td>
        <td colspan="3"></td>
      </tr>
    </tbody>    
  </table>

  
</body>
</html>