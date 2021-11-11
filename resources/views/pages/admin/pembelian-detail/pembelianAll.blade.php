@extends('layouts.admin')

@section('title')
    Transaksi Detail Pembelian
@endsection

@push('addon-style')
  <link rel="stylesheet" href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')}}">
  <link rel="stylesheet" href="{{ asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css')}}">
  <link rel="stylesheet" href="{{ asset('plugins/datatables-buttons/css/buttons.bootstrap4.min.css')}}">
  <!-- Select2 -->
  <link rel="stylesheet" href="{{ asset('plugins/select2/css/select2.min.css') }}">
  <link rel="stylesheet" href="{{ asset('plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
@endpush

@section('content')
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Detail Pembelian</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Detail Pembelian</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-lg-12">
            <div class="card">
              <div class="card-body">
                <div class="table-responsive">
                  <table class="table table-penjualan-detail table-bordered table-striped">
                    <a href="{{ route('transactions.create') }}" class="btn btn-primary mb-2">
                      + Transaksi pembelian
                    </a>
                    @empty(! session('id_transaction'))
                    <a href="{{ route('transaction-details.index') }}" class="btn btn-danger mb-2 ml-2"> Transaksi Aktif</a>
                    @endempty
                    <thead>
                      <tr class="text-center">
                        <th>No</th>
                        <th>Code</th>
                        <th>Toko</th>
                        <th>Tanggal</th>
                        <th>Nama Persediaan</th>
                        <th>Jumlah</th>
                        <th>Satuan</th>
                        <th>Berat</th>
                        <th>Total Berat</th>
                        <th>Satuan Berat</th>
                        <th>Merek</th>
                        <th>Harga Beli</th>
                        <th>Harga Per Satuan</th>
                        <th>Subtotal</th>
                        <th>Aksi</th>
                      </tr>
                    </thead>
                    <tbody>
                      @forelse ($pembelianAll as $item)
                        <tr>
                          <td class="text-center">{{ $loop->iteration }}</td>
                          <td class="text-center">{{ $item->code }}</td>
                          <td class="text-center">{{ $item->pembelian->supplier->name }}</td>
                          <td>{{ tanggal_indonesia ($item->created_at) }}</td>
                          <td class="text-center">{{ $item->persediaan->name_persediaan }}</td>
                          <td class="text-center">{{ format_uang($item->jumlah) }}</td>
                          <td class="text-center">{{ $item->persediaan->satuan }}</td>
                          <td class="text-center">{{ format_uang($item->berat) }}</td>
                          <td class="text-center">{{ format_uang($item->berat_total) }}</td>
                          <td class="text-center">{{ $item->persediaan->satuan_berat }}</td>
                          <td class="text-center">{{ $item->persediaan->merk }}</td>
                          <td class="text-center">Rp{{ format_uang($item->harga_beli) }}</td>
                          <td class="text-center">Rp{{ format_uang($item->harga_persatuan) }}</td>
                          <td>Rp{{ format_uang ($item->subtotal) }}</td>
                          <td class="text-center">
                            <div class="btn-group">
                              <button onclick="editForm( '{{ route('pembelian_detail.update', $item->id_pembelian_detail) }}')" class="btn btn-xs btn-warning btn-flat m-1"><i class="fa fa-edit"></i></button>
                              <button type="submit" id="delete" href="{{ route('pembelian.destroy', $item->id_pembelian_detail) }}" 
                                class="btn btn-xs btn-danger btn-flat m-1"><i class="fa fa-trash"></i></button>
                              <form action="" method="POST" id="deleteForm">
                                @csrf
                                @method("DELETE")
                                <input type="submit" value="Hapus" style="display: none">
                                
                              </form>
                            </div>
                          </td>
                        </tr>
                      @empty
                          Tidak ada data
                      @endforelse
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
  </div>

  @includeIf('pages.admin.pembelian-detail.form')

@endsection

@push('addon-script')
<!-- Sweet alert -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
@include('includes.admin.alerts')
<!-- DataTables  & Plugins -->
<script src="{{ asset('plugins/datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{ asset('plugins/datatables-bs4/js/dataTables.bootstrap4.min.js')}}"></script>
<!-- Select2 -->
<script src="{{ asset('plugins/select2/js/select2.full.min.js') }}"></script>

<script>
  let table, table1;

  $(function () {
      table = $('.table-penjualan-detail').DataTable({
        processing: true,
        autoWidth: false,  
      });

      table1 = $('.table-detail-penjualan').DataTable({
        processing: true,
          columns: [
            {data: 'DT_RowIndex', searchable: false, sortable: false},
            {data: 'code'},
            {data: 'tanggal'},
            {data: 'nama_produk'},
            {data: 'harga_jual'},
            {data: 'jumlah'},
            {data: 'diskon'},
            {data: 'subtotal'},
        ]
      });
    });

    function editForm(url) {
      $('#modal-form').modal('show');
      $('#modal-form .modal-title').text('Edit Detail Pembelian');

      $('#modal-form form')[0].reset();
      $('#modal-form form').attr('action', url);
      $('#modal-form [name=_method]').val('put');
      $('#modal-form [name=id_pembelian]').focus();

      $.get(url)
        .done((response) => {
            $('#modal-form [name=id_pembelian]').val(response.id_pembelian);
            $('#modal-form [name=id_produk]').val(response.id_produk);
            $('#modal-form [name=harga_beli]').val(response.harga_beli);
            $('#modal-form [name=harga_persatuan]').val(response.harga_persatuan);
            $('#modal-form [name=jumlah]').val(response.jumlah);
            $('#modal-form [name=berat]').val(response.berat);
            $('#modal-form [name=berat_total]').val(response.berat_total);
            $('#modal-form [name=subtotal]').val(response.subtotal);
        })
        .fail((errors) => {
            alert('Tidak dapat menampilkan data');
            return;
        });
    }
</script>

@endpush