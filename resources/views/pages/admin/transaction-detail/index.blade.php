@extends('layouts.admin')

@section('title')
    Transaksi Penjualan
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
                <hr>
                <div class="row">
                  <div class="col-12 text-right">
                    <h3>INVOICE <b>SKS1201197001</b></h3>
                  </div>
                  <div class="col-6">
                    <h1>Total (Rp)</h1>
                  </div>
                  <div class="col-6 text-right">
                    <h1>125.000.000</h1>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-lg-12">
            <div class="card">
              <form action="{{ route('transaction-detail.store') }}" class="form-horizontal" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="row">
                  <div class="col-4">
                    <div class="card-body">
                      <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Kasir</label>
                        <div class="col-sm-9">
                          <input type="text" class="form-control" value="{{ Auth::user()->name }}" placeholder="Kasir" readonly>
                        </div>
                      </div>
                      <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Customer</label>
                        <div class="col-sm-9">
                          <select class="form-control select2">
                            <option>Umum</option>
                            <option>Pegawai</option>
                          </select> 
                        </div>
                      </div>
                      <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Layanan</label>
                        <div class="col-sm-9">
                          <select class="form-control select2">
                            <option>Produk</option>
                            <option>Coffee</option>
                            <option>Non Coffee</option>
                            <option>Cemilan</option>
                          </select>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-4">
                    <div class="card-body">
                      <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Pilih Produk</label>
                        <div class="col-sm-9 input-group">
                          <input type="hidden" class="form-control" name="products_id" id="id_produk">
                          <input type="text" class="form-control" id="code" name="code" readonly>
                          <span class="input-group-append">
                            <button onclick="tampilProduk()" type="button" class="btn btn-info btn-flat"><i class="fa fa-search"></i></button>
                          </span>
                        </div>
                      </div>
                      <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Qty</label>
                        <div class="col-sm-9">
                          <input type="number" class="form-control" name="jumlah" id="qty" onkeyup="sum()" placeholder="Jumlah" min="1">
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-4">
                    <div class="card-body">
                      <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Nama</label>
                        <div class="col-sm-9">
                          <input type="hidden" class="form-control" name="transactions_id" value="{{ $transactions_id }}" readonly>
                          <input type="text" class="form-control" id="name_product" placeholder="Nama Produk" readonly>
                        </div>
                      </div>
                      <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Harga</label>
                        <div class="col-sm-9">
                          <input type="text" class="form-control" name="harga_jual" id="harga_jual" onkeyup="sum()">
                          <input type="text" class="form-control" id="subtotal">
                        </div>
                      </div>
                      <button type="submit" class="btn btn-success float-right"><i class="fa fa-shopping-cart"></i>Tambah</button>
                    </div>
                  </div>
                </div>
                <!-- /.card-body -->
              </form>
            </div><!-- /.card -->
          </div>
          <!-- /.col-md-6 -->
        </div>
        <!-- /.row -->

        <div class="row">
          <div class="col-lg-12">
            <div class="card">
              <div class="card-body">
                <div class="table-responsive">
                  <table id="example1" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th>No</th>
                        <th>Code</th>
                        <th>Nama Item</th>
                        <th>Harga</th>
                        <th>Discon / Item</th>
                        <th>Total</th>
                      </tr>
                    </thead>
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

  @includeIf('pages.admin.transaction-detail.product')

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
      $("#example1").DataTable({
        "responsive": true, "lengthChange": false, "autoWidth": false,
        "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
      });
      $('#example2').DataTable({
        "paging": true,
        "lengthChange": false,
        "searching": true,
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
        var price = document.getElementById('harga_jual').value;
        var result = parseInt(price) * parseInt(qty);
        if (!isNaN(result)) {
            document.getElementById('subtotal').value = result;
        }
    }

    function tampilProduk() {
        $('#modal-produk').modal('show');
    }

    function hideProduk() {
        $('#modal-produk').modal('hide');
    }

    function pilihProduk(id, code, name_product, harga_jual) {
        $('#id_produk').val(id);
        $('#code').val(code);
        $('#name_product').val(name_product);
        $('#harga_jual').val(harga_jual);
        $('#qty').val(1);
        hideProduk();
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
            'Data produk berhasil dihapus.',
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