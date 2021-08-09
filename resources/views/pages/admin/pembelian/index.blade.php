@extends('layouts.admin')

@section('title')
   Data Pembelian
@endsection

@push('addon-style')
  <link rel="stylesheet" href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')}}">
  <link rel="stylesheet" href="{{ asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css')}}">
  <link rel="stylesheet" href="{{ asset('plugins/datatables-buttons/css/buttons.bootstrap4.min.css')}}">
  <!-- Select2 -->
  <link rel="stylesheet" href="{{ asset('plugins/select2/css/select2.min.css') }}">
  <link rel="stylesheet" href="{{ asset('plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
  <!-- summernote -->
  <link rel="stylesheet" href="{{ asset('plugins/summernote/summernote-bs4.min.css') }}">
@endpush

@section('content')
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
            <h1 class="m-0">Pembelian</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active">Data Pembelian</li>
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
                <h3 class="card-title">Data Pembelian</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <div class="table-responsive">
                  <table id="example1" class="table table-bordered table-striped">
                    <button onclick="addForm()" class="btn btn-primary"><i class="fa fa-plus-circle"></i> Transaksi Baru</button>
                    <thead>
                      <tr>
                        <th>No</th>
                        <th>Tanggal</th>
                        <th>Supplier</th>
                        <th>Total Item</th>
                        <th>Total Harga</th>
                        <th>Diskon</th>
                        <th>Total Bayar</th>
                        <th>Aksi</th>
                      </tr>
                    </thead>

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

  @includeIf('pages.admin.pembelian.supplier')
  <!-- /.modal -->
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
  <!-- Summernote -->
  <script src="{{ asset('plugins/summernote/summernote-bs4.min.js') }}"></script>

  <script>
      let table, table1;

      $(function () {
          table = $('.table-pembelian').DataTable({
            // processing: true,
            // autoWidth: false,
            // ajax: {
            //     url: '#',
            // },
            // columns: [
            //     {data: 'DT_RowIndex', searchable: false, sortable: false},
            //     {data: 'tanggal'},
            //     {data: 'supplier'},
            //     {data: 'total_item'},
            //     {data: 'total_harga'},
            //     {data: 'diskon'},
            //     {data: 'bayar'},
            //     {data: 'aksi', searchable: false, sortable: false},
            // ]
          });

          $('.table-supplier').DataTable();
          table1 = $('.table-detail').DataTable({
              processing: true,
              bSort: false,
              dom: 'Brt',
              columns: [
                  {data: 'DT_RowIndex', searchable: false, sortable: false},
                  {data: 'kode_produk'},
                  {data: 'nama_produk'},
                  {data: 'harga_beli'},
                  {data: 'jumlah'},
                  {data: 'subtotal'},
              ]
          })
      });

      function addForm() {
          $('#modal-supplier').modal('show');
      }

      function showDetail(url) {
          $('#modal-detail').modal('show');

          table1.ajax.url(url);
          table1.ajax.reload();
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
     $(function () {
        //Initialize Select2 Elements
        $('.select2').select2()

        //Initialize Select2 Elements
        $('.select2bs4').select2({
          theme: 'bootstrap4'
        })
     })
  </script>

  <script>
    $(function () {
      // Summernote
      $('#summernote').summernote()

      // CodeMirror
      CodeMirror.fromTextArea(document.getElementById("codeMirrorDemo"), {
        mode: "htmlmixed",
        theme: "monokai"
      });
    })
  </script>

  <script>
    $(function () {
      $("#example1").DataTable({
        "responsive": true, "lengthChange": false, "autoWidth": false,
        "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
      }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
      $('#example2').DataTable({
        "paging": true,
        "lengthChange": false,
        "searching": false,
        "ordering": true,
        "info": true,
        "autoWidth": false,
        "responsive": true,
      });
    });
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