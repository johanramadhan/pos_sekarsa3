<?php
use Illuminate\Support\Facades\Storage;
?>
<html>
<head>
	<title>Rekapitulasi Data Produk</title>
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
    <h5 class="text-center cover">DATA PRODUK <br> SEKARSA COFFEE </h5>
  </div>

  <div class="page-break"></div>

  <h6 class="text-center" style="font-size: 14px;">DATA PRODUK <br> SEKARSA COFFEE </h6>

  <table class="table" style="border: 1px solid black; font-size: 12px;">
    <thead>
      <tr>
        <th class="text-center">No</th>
        <th class="text-center">Kode Produk</th>
        <th class="text-center">Kategori</th>
        <th class="text-center">Nama Produk</th>
        <th class="text-center">Stok Barang</th>
        <th class="text-center">Satuan</th>
        <th class="text-center">Harga Modal</th>
        <th class="text-center">Harga Jual</th>
        <th class="text-center">Deskripsi</th>
        <th class="text-center">Gambar</th>
      </tr>
    </thead>

    <tbody>
      @foreach ($products as $item)
        <tr style="line-height: 12px;">
          <td class="text-center">{{ $loop->iteration }}</td>
          <td>{{ $item->code }}</td>
          <td>{{ $item->category->name }}</td>
          <td>{{ $item->name }}</td>
          <td class="text-center">{{ $item->stok }}</td>
          <td class="text-center">{{ $item->satuan }}</td>
          <td>{{ number_format($item->price_modal) }}</td>
          <td>{{ number_format($item->price_jual) }}</td>
          <td>{!! $item->description !!}</td>
          <td>
            <img src="{{ public_path("storage/".$item->galleries->first()->photos ?? 'tidak ada foto') }}" style="width: 100px; margin-top:10px;">
          </td>
        </tr>
      @endforeach
    </tbody>    
  </table>

  
</body>
</html>