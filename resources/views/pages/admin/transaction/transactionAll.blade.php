@extends('layouts.admin')

@section('title')
    Transaksi Detail Penjualan
@endsection

@push('addon-style')
  <link rel="stylesheet" href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')}}">
  <link rel="stylesheet" href="{{ asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css')}}">
  <link rel="stylesheet" href="{{ asset('plugins/datatables-buttons/css/buttons.bootstrap4.min.css')}}">
  <!-- daterange picker -->
  <link rel="stylesheet" href="{{ asset('plugins/daterangepicker/daterangepicker.css') }}">
  <!-- Tempusdominus Bbootstrap 4 -->
  <link rel="stylesheet" href="{{ asset('plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">
  <!-- Select2 -->
  <link rel="stylesheet" href="{{ asset('plugins/select2/css/select2.min.css') }}">
  <link rel="stylesheet" href="{{ asset('plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
@endpush

@section('content')
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Laporan Penjualan {{ tanggal_indonesia($tanggalAwal, false) }} s/d {{ tanggal_indonesia($tanggalAkhir, false) }}</h1>
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
                    <button onclick="addForm()" class="btn btn-primary mb-2 ml-2">Update Tanggal</i></button>
                    <thead>
                      <tr class="text-center">
                        <th>No</th>
                        <th>Code Transaksi</th>
                        <th>Tanggal</th>
                        <th>Nama Produk</th>
                        <th>Modal</th>
                        <th>Harga Jual</th>
                        <th>Jumlah</th>
                        <th>Diskon</th>
                        <th>Total Modal</th>
                        <th>Total Harga</th>
                        <th>Keuntungan</th>
                      </tr>
                    </thead>
                    <tbody>
                      @forelse ($transactionAll as $item)
                        <tr>
                          <td class="text-center">{{ $loop->iteration }}</td>
                          <td class="text-center">{{ $item->code }}</td>
                          <td>{{ tanggal_indonesia ($item->created_at) }}</td>
                          <td class="text-center">{{ $item->produk->name_product }}</td>
                          <td class="text-center">Rp{{ format_uang ($item->produk->harga_beli) }}</td>
                          <td class="text-center">Rp{{ format_uang ($item->harga_jual) }}</td>
                          <td class="text-center">{{ format_uang ($item->jumlah) }}</td>
                          <td class="text-center">{{ $item->diskon }}%</td>
                          <td>Rp{{ format_uang ($item->produk->harga_beli) }}</td>
                          <td>Rp{{ format_uang ($item->subtotal) }}</td>
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

  @includeIf('pages.admin.transaction.date') 

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
<!-- InputMask -->
<script src="{{ asset('plugins/moment/moment.min.js') }}"></script>
<script src="{{ asset('plugins/inputmask/min/jquery.inputmask.bundle.min.js') }}"></script>
<!-- date-range-picker -->
<script src="{{ asset('plugins/daterangepicker/daterangepicker.js') }}"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="{{ asset('plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}"></script>

<script>
  let table, table1;

  $(function () {
      table = $('.table-penjualan-detail1').DataTable({
        processing: true,
        autoWidth: false,  
        bSort: true,
        bPaginate: true,
        ajax: {
          url: '{{ route('transactions.transactionAllDetail') }}',
        },
        columns: [
            {data: 'DT_RowIndex', searchable: false, sortable: false},
            {class: 'text-center', data: 'code'},
            {class: 'text-center', data: 'created_at'},
            {data: 'name_produk'},
            {data: 'modal'},
            {data: 'harga_jual'},
            {class: 'text-center', data: 'jumlah'},
            {class: 'text-center', data: 'diskon'},
            {data: 'total_modal'},
            {data: 'subtotal'},
            {data: 'keuntungan'},
        ]
      });

       //Date range picker
       $('#reservationdate').datetimepicker({
          format: 'YYYY-MM-DD',
          autoclose: true
      });
      //Date range picker
      $('#reservationdate2').datetimepicker({
          format: 'YYYY-MM-DD',
          autoclose: true
      });

    });

    function addForm() {
        $('#modal-laporan').modal('show');
    }
</script>

@endpush