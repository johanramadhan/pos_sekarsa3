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
  .cover {
    margin-top: 100px;
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
    <h5 class="text-center cover">RENCANA KEBUTUHAN BARANG MILIK DAERAH (RKBMD) <br> OLEH BIDANG PADA  <br> DINAS PEMADAM KEBAKARAN DAN PENYELAMATAN KOTA PEKANBARU TAHUN ANGGARAN 2021</h5>
  </div>

  <div class="page-break"></div>

  <table class="table table-bordered table-sm">
    <thead>
      <tr>
        <th class="text-center">No</th>
        <th class="text-center">Gambar</th>
        <th class="text-center">Uraian</th>
      </tr>
    </thead>
    @foreach ($proposals  as $proposal)
        <tr>
          <td class="text-center col-0 mt-2">{{ $loop->iteration }}</td>
          <td class="col-2 mt-2">
            <img src="{{ public_path("storage/".$proposal->galleries->first()->photos) }}" style="width: 300px;" class="m-4">
          </td>
          <td  class="col-4 mt-2">
            <table class="table-borderless">
              <tr>
                <td>Kode</td>
                <td>:</td>
                <td>{{ $proposal->code }}</td>
              </tr>
              <tr>
                <td>Status Usulan</td>
                <td>:</td>
                <td>
                  @if (($proposal->proposal_status) === "Pending")
                    <span class="badge badge-danger">Pending</span>
                  @elseif(($proposal->proposal_status) === "RKBMD")
                    <span class="badge badge-warning">RKBMD</span>
                  @elseif(($proposal->proposal_status) === "Standar Harga")
                    <span class="badge badge-success">Standar Harga</span>
                  @elseif(($proposal->proposal_status) === "RKA")
                    <span class="badge badge-primary">RKA</span>
                  @endif
                </td>
              </tr>
              <tr>
                <td>Bidang Pengusul</td>
                <td>:</td>
                <td>{{ $proposal->user->bidang }}</td>
              </tr>
              <tr>
                <td>Kategori</td>
                <td>:</td>
                <td>{{ $proposal->category->name }}</td>
              </tr>
              <tr>
                <td>Nama Barang</td>
                <td>:</td>
                <td>{{ $proposal->name }}</td>
              </tr>
              <tr>
                <td>Merek</td>
                <td>:</td>
                <td>{{ $proposal->brand }}</td>
              </tr>
              <tr>
                <td>Kebutuhan Max</td>
                <td>:</td>
                <td>{{ $proposal->max_requirement }}</td>
              </tr>
              <tr>
                <td>Jumlah Yang Diajukan</td>
                <td>:</td>
                <td>{{ $proposal->qty }}</td>
              </tr>
              <tr>
                <td>Satuan</td>
                <td>:</td>
                <td>{{ $proposal->satuan }}</td>
              </tr>
              <tr>
                <td>Harga Satuan</td>
                <td>:</td>
                <td>Rp{{ number_format($proposal->price) }}</td>
              </tr>
              <tr>
                <td>Total Harga</td>
                <td>:</td>
                <td>Rp{{ number_format($proposal->total_price) }}</td>
              </tr>
              <tr>
                <td>Fungsi</td>
                <td>:</td>
                <td>{{ $proposal->benefit }}</td>
              </tr>
            </table>
          </td>
        </tr>
        <tr>
          <td colspan="3">Spesifikasi :</td>
        </tr>
        <tr>
          <td colspan="3">
            {!! Str::limit($proposal->description, 500) !!}
          </td>
        </tr>
    @endforeach
  </table>

  
</body>
</html>