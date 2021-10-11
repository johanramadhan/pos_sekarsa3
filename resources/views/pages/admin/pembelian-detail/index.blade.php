@extends('layouts.admin')

@section('title')
    Transaksi Pembelian
@endsection

@push('addon-style')
  <link rel="stylesheet" href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')}}">
  <link rel="stylesheet" href="{{ asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css')}}">
  <link rel="stylesheet" href="{{ asset('plugins/datatables-buttons/css/buttons.bootstrap4.min.css')}}">
  <!-- Select2 -->
  <link rel="stylesheet" href="{{ asset('plugins/select2/css/select2.min.css') }}">
  <link rel="stylesheet" href="{{ asset('plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
  <style>
    .tampil-bayar {
        font-size: 4em;
        text-align: center;
    }

    .tampil-terbilang {
        padding: 10px;
        background: #f0f0f0;
    }
    .table-pembelian2 tbody tr:last-child {
        display: none;
    }
  </style>
@endpush

@section('content')
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
            <h1 class="m-0">Transaksi Pembelian</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active">Transaksi Pembelian</li>
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
                    <h3>INVOICE <b>{{ $codePembelian }}</b></h3>
                  </div>
                  <div class="col-6">
                    <h1>Total (Rp)</h1>
                  </div>
                  <div class="col-6 text-right tampil-bayar"></div>
                  <div class="col-12 text-right tampil-terbilang"></div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-lg-12">
            <div class="card">
              <form action="{{ route('pembelian_detail.store') }}" class="form-horizontal" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="row">
                  <div class="col-4">
                    <div class="card-body">
                      <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Supplier</label>
                        <div class="col-sm-9">
                          <input type="text" class="form-control" value="{{ $supplier->name }}" readonly>
                        </div>
                      </div>
                      <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Alamat</label>
                        <div class="col-sm-9">
                          <input type="text" class="form-control" value="{{ $supplier->address }}" readonly>
                        </div>
                      </div>
                      <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Phone</label>
                        <div class="col-sm-9">
                          <input type="text" class="form-control" value="{{ $supplier->phone }}" readonly>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-4">
                    <div class="card-body">
                      <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Pilih Persediaan</label>
                        <div class="col-sm-9 input-group">
                          <input type="hidden" class="form-control" name="id_produk" id="id_persediaan">
                          <input type="hidden" class="form-control" name="id_pembelian" value="{{ $id_pembelian }}" readonly>
                          <input type="hidden" class="form-control" name="code" value="{{ $codePembelian }}">
                          <input type="text" class="form-control" id="code" readonly>
                          <span class="input-group-append">
                            <button onclick="tampilProduk()" type="button" class="btn btn-info btn-flat"><i class="fa fa-search"></i></button>
                          </span>
                        </div>
                      </div>
                      <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Qty</label>
                        <div class="col-sm-9">
                          <input type="number" class="form-control" name="jumlah" id="qty" placeholder="Jumlah">
                        </div>
                      </div>
                      <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Berat Satuan</label>
                        <div class="col-sm-9">
                          <input type="number" class="form-control" name="berat" id="berat" placeholder="Berat">
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-4">
                    <div class="card-body">
                      <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Nama</label>
                        <div class="col-sm-9">                          
                          <input type="text" class="form-control" id="name_persediaan" placeholder="Nama Persediaan" readonly>
                        </div>
                      </div>
                      <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Harga</label>
                        <div class="col-sm-9">
                          <input type="text" class="form-control" name="harga_beli" id="harga_beli" readonly>
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
          <div class="col-lg-8">
            <div class="card">
              <div class="card-body">
                <div class="table-responsive">
                  <table class="table table-bordered table-striped table-pembelian">
                    <thead>
                      <tr>
                        <th class="text-center">No</th>
                        <th class="text-center" width="15%">Kode Produk</th>
                        <th class="text-center">Nama Item</th>
                        <th class="text-center">Satuan Berat</th>
                        <th class="text-center" width="8%">Jumlah</th>
                        <th class="text-center" width="10%">Berat Satuan</th>
                        <th class="text-center" width="10%">Total Berat</th>
                        <th class="text-center">Harga Beli</th>
                        <th class="text-center">Total</th>
                        <th class="text-center">Aksi</th>
                      </tr>
                    </thead>
                  </table>
                </div>
              </div>
            </div>
          </div>

          <div class="col-lg-4">
            <form action="{{ route('pembelian.store') }}" class="form-pembelian" method="post">
              @csrf
              <input type="hidden" name="id_pembelian" value="{{ $id_pembelian }}">
              <input type="hidden" name="total" id="total">
              <input type="hidden" name="total_item" id="total_item">
              <input type="text" name="totalBerat" id="totalBerat">
              <input type="hidden" name="bayar" id="bayar">

              <div class="card">
                <div class="card-body">
                  {{-- Total Pembelian --}}
                  <div class="form-group row">
                    <label for="totalrp" class="col-lg-2 control-label">Total</label>
                    <div class="col-lg-10">
                        <input type="text" id="totalrp" class="form-control" readonly>
                    </div>
                  </div>
                  {{-- Diskon Pembelian --}}
                  <div class="form-group row">
                    <label for="diskon" class="col-lg-2 control-label">Diskon</label>
                    <div class="col-lg-10">
                        <input type="number" name="diskon" id="diskon" class="form-control" value="{{ $diskon }}">
                    </div>
                  </div>
                  {{-- Bayar --}}
                  <div class="form-group row">
                    <label for="bayar" class="col-lg-2 control-label">Bayar</label>
                    <div class="col-lg-10">
                        <input type="text" id="bayarrp" class="form-control" readonly>
                    </div>
                  </div>
                </div>
                <button type="submit" class="btn btn-primary btn-md float-right btn-simpan"><i class="fa fa-save"></i> Simpan Transaksi</button>
              </div>
            </form>
          </div>

        </div>


      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
  </div>

  @includeIf('pages.admin.pembelian-detail.product')

@endsection

@push('addon-script')
  <!-- Sweet alert -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/1000hz-bootstrap-validator/0.11.9/validator.min.js"></script>
  @include('includes.admin.alerts')
  <!-- DataTables  & Plugins -->
  <script src="{{ asset('plugins/datatables/jquery.dataTables.min.js')}}"></script>
  <script src="{{ asset('plugins/datatables-bs4/js/dataTables.bootstrap4.min.js')}}"></script>
  <!-- Select2 -->
  <script src="{{ asset('plugins/select2/js/select2.full.min.js') }}"></script>

  {{-- <script>
     $(function () {
        //Initialize Select2 Elements
        $('.select2').select2()

        //Initialize Select2 Elements
        $('.select2bs4').select2({
          theme: 'bootstrap4'
        })
     })
  </script> --}}
  
  <script>
    let table, table1;

    $(function () {
      $('body').addClass('sidebar-collapse');

      table = $('.table-pembelian').DataTable({
          processing: true,
          autoWidth: false,
          dom: 'Brt',
          bSort: false,
          ajax: {
              url: '{{ route('pembelian_detail.data', $id_pembelian) }}',
          },
          columns: [
              {class: 'text-center', data: 'DT_RowIndex', searchable: false, sortable: false},
              {class: 'text-center', data: 'codePersediaan'},
              {class: 'text-center', data: 'namaPersediaan'},
              {class: 'text-center', data: 'satuanBerat'},
              {class: 'text-center', data: 'jumlah'},
              {class: 'text-center', data: 'berat'},
              {class: 'text-right', data: 'beratTotal'},
              {class: 'text-right', data: 'harga_beli'},
              {class: 'text-right', data: 'subtotal'},
              {class: 'text-center', data: 'aksi', searchable: false, sortable: false},
          ]
      })
      .on('draw.dt', function () {
          loadForm($('#diskon').val());
      });       

      table1 = $('.table-produk').DataTable();  

      $(document).on('input', '.quantity', function () {
            let id = $(this).data('id');
            let jumlah = parseInt($(this).val());

            if (jumlah < 1) {
                $(this).val(1);
                alert('Jumlah tidak boleh kurang dari 1');
                return;
            }
            if (jumlah > 10000) {
                $(this).val(10000);
                alert('Jumlah tidak boleh lebih dari 10.000');
                return;
            }

            $.post(`{{ url('/admin/data-transaction/pembelian_detail') }}/${id}`, {
                '_token': $('[name=csrf-token]').attr('content'),
                '_method': 'put',
                'jumlah': jumlah
            })
            .done(response => {
                $(this).on('mouseout', function () {
                    table.ajax.reload(() => loadForm($('#diskon').val()));
                });
            })
            .fail(errors => {
                alert('Tidak dapat menyimpan data jumlah');
                return;
            });
      });

      $(document).on('input', '#diskon', function () {
          if ($(this).val() == "") {
              $(this).val(0).select();
          }

          loadForm($(this).val());
      });

      $('.btn-simpan').on('click', function () {
            $('.form-pembelian').submit();
        });
      
    });          


    function tampilProduk() {
      $('#modal-produk').modal('show');
    }

    function hideProduk() {
      $('#modal-produk').modal('hide');
    }

    function pilihProduk(id, code, name_persediaan, harga_beli) {
        $('#id_persediaan').val(id);
        $('#code').val(code);
        $('#name_persediaan').val(name_persediaan);
        $('#harga_beli').val(harga_beli);
        $('#qty').val(1);
        hideProduk();
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

    function loadForm(diskon = 0) {
        $('#total').val($('.total').text());
        $('#totalBerat').val($('.totalBerat').text());
        $('#total_item').val($('.total_item').text());

        $.get(`{{ url('admin/data-transaction/pembelian_detail/loadform') }}/${diskon}/${$('.total').text()}`)
            .done(response => {
                $('#totalrp').val('Rp'+ response.totalrp);
                $('#bayarrp').val('Rp'+ response.bayarrp);
                $('#bayar').val(response.bayar);
                $('.tampil-bayar').text('Rp. '+ response.bayarrp);
                $('.tampil-terbilang').text(response.terbilang);
            })
            .fail(errors => {
                alert('Tidak dapat menampilkan data2');
                return;
            })
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