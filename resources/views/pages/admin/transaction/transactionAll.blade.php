@extends('layouts.admin')

@section('title')
    Transaksi Detail Penjualan
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
            <h1 class="m-0">Transaksi Penjualan</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Transaksi Penjualan</li>
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
                      + Transaksi Penjualan
                    </a>
                    @empty(! session('id_transaction'))
                    <a href="{{ route('transaction-details.index') }}" class="btn btn-danger mb-2 ml-2"> Transaksi Aktif</a>
                    @endempty
                    <thead>
                      <tr class="text-center">
                        <th>No</th>
                        <th>Code</th>
                        <th>Tanggal</th>
                        <th>Transaksi</th>
                        <th>Nama Produk</th>
                        <th>Harga Jual</th>
                        <th>Jumlah</th>
                        <th>Diskon</th>
                        <th>Total Harga</th>
                        <th>Total Modal</th>
                        <th>Keuntungan</th>
                        <th>Aksi</th>
                      </tr>
                    </thead>
                    <tbody>
                      @forelse ($transactionAll as $item)
                        <tr>
                          <td class="text-center">{{ $loop->iteration }}</td>
                          <td class="text-center">{{ $item->code }}</td>
                          <td>{{ tanggal_indonesia ($item->created_at) }}</td>
                          <td class="text-center">{{ $item->transaction->code }}</td>
                          <td class="text-center">{{ $item->produk->name_product }}</td>
                          <td class="text-center">Rp{{ format_uang ($item->harga_jual) }}</td>
                          <td class="text-center">{{ format_uang ($item->jumlah) }}</td>
                          <td class="text-center">{{ $item->diskon }}%</td>
                          <td>Rp{{ format_uang ($item->subtotal) }}</td>
                          <td class="text-center">
                            <div class="btn-group">
                              <button onclick="showDetail( '{{ route('transactions.show', $item->id_transaction_detail) }}')" class="btn btn-xs btn-info btn-flat m-1"><i class="fa fa-eye"></i></button>
                              <button type="submit" id="delete" href="{{ route('transactions.destroy', $item->id_transaction_detail) }}" 
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
</script>

@endpush