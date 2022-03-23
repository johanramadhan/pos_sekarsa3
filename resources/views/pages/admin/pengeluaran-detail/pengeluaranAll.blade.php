@extends('layouts.admin')

@section('title')
    Transaksi Detail Pengeluaran
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
@endpush

@section('content')
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Detail Pengeluaran</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Detail Pengeluaran</li>
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
                  <table class="table table-pengeluaran-detail table-bordered table-striped">
                    <a href="{{ route('transactions.create') }}" class="btn btn-primary mb-2">
                      + Transaksi Pengeluaran
                    </a>
                    @empty(! session('id_transaction'))
                    <a href="{{ route('transaction-details.index') }}" class="btn btn-danger mb-2 ml-2"> Transaksi Aktif</a>
                    @endempty
                    <thead>
                      <tr class="text-center">
                        <th>No</th>
                        <th>Code</th>
                        <th>Tanggal</th>
                        <th>ID Pengeluaran</th>
                        <th>Uraian</th>
                        <th>Harga Beli</th>
                        <th>Jumlah</th>
                        <th>Satuan</th>
                        <th>Subtotal</th>
                        <th>Aksi</th>
                      </tr>
                    </thead>
                    <tbody>
                      @forelse ($pengeluaranAll as $item)
                        <tr>
                          <td class="text-center">{{ $loop->iteration }}</td>
                          <td class="text-center">{{ $item->code }}</td>
                          <td>{{ tanggal_indonesia ($item->created_at) }}</td>
                          <td class="text-center">{{ $item->pengeluaran->code }} - {{ $item->pengeluaran->keterangan }}</td>
                          <td class="text-center">{{ $item->uraian }}</td>
                          <td class="text-center">Rp{{ format_uang($item->harga_beli) }}</td>
                          <td class="text-center">{{ format_uang($item->jumlah) }}</td>
                          <td class="text-center">{{ $item->satuan }}</td>
                          <td class="text-center">Rp{{ format_uang($item->subtotal) }}</td>
                          <td class="text-center">
                            <div class="btn-group">
                              <button onclick="editForm( '{{ route('pengeluaran_detail.update', $item->id_pengeluaran_detail) }}')" class="btn btn-xs btn-warning btn-flat m-1"><i class="fa fa-edit"></i></button>
                              <button onclick="showDetail( '{{ route('pengeluaran.pengeluaranDetailAset', $item->id_pengeluaran_detail) }}')" class="btn btn-xs btn-info btn-flat m-1"><i class="fa fa-eye"></i></button>
                              <button type="submit" id="delete" href="{{ route('pengeluaran.pengeluaranDelete', $item->id_pengeluaran_detail) }}" 
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

  @includeIf('pages.admin.pengeluaran-detail.form')
  @includeIf('pages.admin.pengeluaran-detail.aset')

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
      table = $('.table-pengeluaran-detail').DataTable({
        processing: true,
        autoWidth: false,   
      });

      // table1 = $('.table-detail-pengeluaran').DataTable({
      //   processing: true,
      //     columns: [
      //       {data: 'DT_RowIndex', searchable: false, sortable: false},
      //       {data: 'code'},
      //       {data: 'tanggal'},
      //       {data: 'nama_produk'},
      //       {data: 'harga_jual'},
      //       {data: 'jumlah'},
      //       {data: 'diskon'},
      //       {data: 'subtotal'},
      //   ]
      // });

      //Date range picker
      $('#reservationdate').datetimepicker({
          format: 'YYYY-MM-DD',
          autoclose: true
      });
    });

    function editForm(url) {
      $('#modal-form').modal('show');
      $('#modal-form .modal-title').text('Edit Detail Pengeluaran');

      $('#modal-form form')[0].reset();
      $('#modal-form form').attr('action', url);
      $('#modal-form [name=_method]').val('put');
      $('#modal-form [name=id_pengeluaran]').focus();

      $.get(url)
        .done((response) => {
            $('#modal-form [name=created_at]').val(response.created_at);
            $('#modal-form [name=id_pengeluaran]').val(response.id_pengeluaran);
            $('#modal-form [name=uraian]').val(response.uraian);
            $('#modal-form [name=jumlah]').val(response.jumlah);
            $('#modal-form [name=satuan]').val(response.satuan);
            $('#modal-form [name=harga_beli]').val(response.harga_beli);
            $('#modal-form [name=subtotal]').val(response.subtotal);
        })
        .fail((errors) => {
            alert('Tidak dapat menampilkan data');
            return;
        });
    }
    function showDetail(url) {
      $('#modal-aset').modal('show');
      $('#modal-aset .modal-title').text('Tambah Aset');

      $('#modal-aset form')[0].reset();

      $.get(url)
        .done((response) => {
            $('#modal-aset [name=created_at]').val(response.created_at);
            $('#modal-aset [name=id_pengeluaran]').val(response.id_pengeluaran);
            $('#modal-aset [name=uraian]').val(response.uraian);
            $('#modal-aset [name=jumlah]').val(response.jumlah);
            $('#modal-aset [name=satuan]').val(response.satuan);
            $('#modal-aset [name=harga_beli]').val(response.harga_beli);
            $('#modal-aset [name=subtotal]').val(response.subtotal);
        })
        .fail((errors) => {
            alert('Tidak dapat menampilkan data');
            return;
        });
    }

    function deleteData(url) {
      if (confirm('Yakin ingin menghapus data terpilih?')) {
        $.post(url, {
            '_token': $('[name=csrf-token]').attr('content'),
            '_method': 'delete'
        })
        .done((response) => {
            table.ajax.reload();
        })
        .fail((errors) => {
            alert('Tidak dapat menghapus data');
            return;
        });
      }
    }
</script>

<script>
  $('button#delete').on('click', function(e){
    e.preventDefault();
    var href = $(this).attr('href');
  
    const swalWithBootstrapButtons = Swal.mixin({
      customClass: {
        confirmButton: 'btn btn-success',
        cancelButton: 'btn btn-danger'
      },
      buttonsStyling: false
    })

    swalWithBootstrapButtons.fire({
      title: 'Are you sure?',
      text: "Data yang dihapus tidak bisa dikembalikan lagi!",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonText: 'Yes, Hapus Saja!',
      cancelButtonText: 'No, cancel!',
      reverseButtons: true
    }).then((result) => {
      if (result.isConfirmed) {
        document.getElementById('deleteForm').action = href;
        document.getElementById('deleteForm').submit();
        
        swalWithBootstrapButtons.fire(
          'Terhapus!',
          'Data Kas Kecil berhasil dihapus.',
          'success'
        )
      } else if (
        /* Read more about handling dismissals below */
        result.dismiss === Swal.DismissReason.cancel
      ) {
        swalWithBootstrapButtons.fire(
          'Cancelled',
          'Data anda tidak jadi dihapus',
          'error'
        )
      }
    })
  })
</script>

@endpush