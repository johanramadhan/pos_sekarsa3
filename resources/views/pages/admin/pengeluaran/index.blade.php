@extends('layouts.admin')

@section('title')
   Data Pengeluaran
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
  <!-- summernote -->
  <link rel="stylesheet" href="{{ asset('plugins/summernote/summernote-bs4.min.css') }}">
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
            <h1 class="m-0">Pengeluaran <b>Rp{{ format_uang($total_pengeluaran_report) }}</b></h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active">Data Pengeluaran</li>
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
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Data Pengeluaran</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <div class="table-responsive">
                  <table id="example1" class="table table-pengeluaran table-bordered table-striped">
                    <button onclick="addForm()" class="btn btn-primary mb-2">+ Transaksi Pengeluaran</i></button>
                    @empty(! session('id_pengeluaran'))
                    <a href="{{ route('pengeluaran_detail.index') }}" class="btn btn-danger mb-2 ml-2"> Transaksi Aktif</a>
                    @endempty
                    <thead>
                      <tr>
                        <th>No</th>
                        <th class="text-center">Code</th>
                        <th class="text-center">Tanggal Pengeluaran</th>
                        <th class="text-center">Keterangan</th>
                        <th class="text-center">Kasir</th>
                        <th class="text-center">Total Item</th>
                        <th class="text-center">Total Harga</th>
                        <th class="text-center">Diskon</th>
                        <th class="text-center">Bayar</th>
                        <th class="text-center">Status</th>
                        <th class="text-center">Aksi</th>
                      </tr>
                    </thead>
                    <tbody>
                      @forelse ($pengeluarans as $item)
                      <tr>
                        <td class="text-center">{{ $loop->iteration }}</td>
                        <td class="text-center">{{ $item->code }}</td>
                        <td class="text-center">{{ tanggal_indonesia($item->tgl_pengeluaran) }}</td>
                        <td>{{ $item->keterangan }}</td>
                        <td class="text-center">{{ $item->user->name }}</td>
                        <td class="text-center">{{ format_uang($item->total_item) }}</td>
                        <td class="text-center">Rp{{ format_uang($item->total_harga) }}</td>
                        <td class="text-center">{{ $item->diskon }}%</td>
                        <td class="text-center">Rp{{ format_uang($item->bayar) }}</td>
                        <td class="text-center">
                          @if (($item->status ) === "Success")
                              <span class="badge badge-success">Success</span>
                            @elseif (($item->status ) === "Sukses")
                              <span class="badge badge-success">Sukses</span>
                            @else
                              <span class="badge badge-danger">Pending</span>
                            @endif                                 
                        </td>
                        <td class="text-center">
                          <div class="btn-group">
                            @if (($item->status) === "Pending")
                            @else
                              <button onclick="print('{{ route('pengeluaran.print', $item->id_pengeluaran) }}')" class="btn btn-xs btn-default btn-flat m-1"><i class="fa fa-print"></i></button>
                            @endif
                            <button onclick="editForm( '{{ route('pengeluaran.update', $item->id_pengeluaran) }}')" class="btn btn-xs btn-warning btn-flat m-1"><i class="fa fa-edit"></i></button>
                            <button onclick="showDetail( '{{ route('pengeluaran.detail', $item->id_pengeluaran) }}')" class="btn btn-xs btn-info btn-flat m-1"><i class="fa fa-eye"></i></button>
                            <button type="submit" id="delete" href="{{ route('pengeluaran.destroy', $item->id_pengeluaran) }}" 
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
                          
                      @endforelse
                    </tbody>
                  </table>
                </div>
              </div>
            </div><!-- /.card -->
          </div>
          <!-- /.col-md-6 -->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
  </div>

  @includeIf('pages.admin.pengeluaran.detail')
  @includeIf('pages.admin.pengeluaran.tambah')
  @includeIf('pages.admin.pengeluaran.form')

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
      table = $('.table-pengeluaran').DataTable({
        processing: true,
        autoWidth: false,
      });
          
      table1 = $('.table-detail-pengeluaran').DataTable({
          processing: true,
          bSort: false,
          columns: [
              {class: 'text-center', data: 'DT_RowIndex', searchable: false, sortable: false},
              {class: 'text-center', data: 'code'},
              {class: 'text-left', data: 'uraian'},
              {class: 'text-center', data: 'jumlah'},
              {class: 'text-center', data: 'satuan'},
              {class: 'text-center', data: 'harga_beli'},
              {class: 'text-center', data: 'subtotal'},
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
        $('#modal-pengeluaran').modal('show');
    }

    function showDetail(url) {
        $('#modal-detail').modal('show');

        table1.ajax.url(url);
        table1.ajax.reload();
    }

    function editForm(url) {
      $('#modal-form').modal('show');
      $('#modal-form .modal-title').text('Edit Pengeluaran');

      $('#modal-form form')[0].reset();
      $('#modal-form form').attr('action', url);
      $('#modal-form [name=_method]').val('put');
      $('#modal-form [name=keterangan]').focus();

      $.get(url)
        .done((response) => {
            $('#modal-form [name=tgl_pengeluaran]').val(response.tgl_pengeluaran);
            $('#modal-form [name=users_id]').val(response.users_id);
            $('#modal-form [name=total_item]').val(response.total_item);
            $('#modal-form [name=total_harga]').val(response.total_harga);
            $('#modal-form [name=bayar]').val(response.bayar);
            $('#modal-form [name=status]').val(response.status);
            $('#modal-form [name=keterangan]').val(response.keterangan);
        })
        .fail((errors) => {
            alert('Tidak dapat menampilkan data');
            return;
        });
    }

    function print(url, title) {
        popupCenter(url, title, 625, 500);
    }

    function popupCenter(url, title, w, h) {
        const dualScreenLeft = window.screenLeft !==  undefined ? window.screenLeft : window.screenX;
        const dualScreenTop  = window.screenTop  !==  undefined ? window.screenTop  : window.screenY;

        const width  = window.innerWidth ? window.innerWidth : document.documentElement.clientWidth ? document.documentElement.clientWidth : screen.width;
        const height = window.innerHeight ? window.innerHeight : document.documentElement.clientHeight ? document.documentElement.clientHeight : screen.height;

        const systemZoom = width / window.screen.availWidth;
        const left       = (width - w) / 2 / systemZoom + dualScreenLeft
        const top        = (height - h) / 2 / systemZoom + dualScreenTop
        const newWindow  = window.open(url, title, 
        `
            scrollbars=yes,
            width  = ${w / systemZoom}, 
            height = ${h / systemZoom}, 
            top    = ${top}, 
            left   = ${left}
        `
        );

        if (window.focus) newWindow.focus();
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
      function sum() {
          var qty = document.getElementById('qty').value;
          var price = document.getElementById('price').value;
          var result = parseInt(price) * parseInt(qty);
          if (!isNaN(result)) {
              document.getElementById('total_price').value = result;
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
            'Data pengeluaran berhasil dihapus.',
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