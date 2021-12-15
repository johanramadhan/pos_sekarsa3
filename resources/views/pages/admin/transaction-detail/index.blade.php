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
  <style>
    .tampil-bayar {
        font-size: 4em;
        text-align: center;
    }

    .tampil-terbilang {
        padding: 10px;
        background: #f0f0f0;
    }
    .table-penjualan1  tbody tr:last-child {
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
                    <h3>INVOICE <b>{{ $codeTransaction }}</b></h3>
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
              <form action="{{ route('transaction-details.store') }}" class="form-horizontal" method="POST" enctype="multipart/form-data">
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
                    </div>
                  </div>
                  <div class="col-4">
                    <div class="card-body">
                      <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Pilih Produk</label>
                        <div class="col-sm-9 input-group">
                          <input type="hidden" class="form-control" name="products_id" id="id_produk">
                          <input type="hidden" class="form-control" name="code" value="{{ $codeTransaction }}">
                          <input type="text" class="form-control" id="code" required readonly>
                          <span class="input-group-append">
                            <button onclick="tampilProduk()" type="button" class="btn btn-info btn-flat"><i class="fa fa-search"></i></button>
                          </span>
                        </div>
                      </div>
                      <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Qty</label>
                        <div class="col-sm-9">
                          <input type="number" class="form-control" name="jumlah" id="qty" placeholder="Jumlah" required>
                        </div>
                      </div>
                      <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Diskon</label>
                        <div class="col-sm-9">
                          <input type="number" class="form-control" name="diskon" id="diskon_product" placeholder="diskon" readonly>
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
                          <input type="text" class="form-control" name="harga_jual" id="harga_jual" readonly>
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
                  <table class="table table-penjualan table-bordered table-striped">
                    <thead>
                      <tr>
                        <th class="text-center">No</th>
                        <th class="text-center">Kode Produk</th>
                        <th class="text-center">Poin</th>
                        <th class="text-center">Nama Item</th>
                        <th class="text-center" width="15%">jumlah</th>
                        <th class="text-center">Harga</th>
                        <th class="text-center" >Discont / Item</th>
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
            <form action="{{ route('transactions.store') }}" class="form-penjualan" method="post">
              @csrf
              <input type="hidden" name="transactions_id" value="{{ $transactions_id }}" readonly>
              <input type="text" name="total" id="total" readonly>
              <input type="text" name="total_item" id="total_item" readonly>
              <input type="text" name="bayar" id="bayar" readonly>
              <input type="text" name="id_member" id="id_member" readonly>

              <div class="card">
                <div class="card-body">
                  {{-- Total Penjualan --}}
                  <div class="form-group row">
                    <label for="totalrp" class="col-lg-3 control-label">Total</label>
                    <div class="col-lg-9">
                        <input type="text" id="totalrp" class="form-control" required readonly>
                    </div>
                  </div>
                  {{-- Member --}}
                  <div class="form-group row">
                    <label class="col-lg-3 control-label">Member</label>
                    <div class="col-lg-9 input-group">
                      <input type="text" class="form-control" id="code_member" required readonly>
                      <span class="input-group-append">
                        <button onclick="tampilMember()" type="button" class="btn btn-info btn-flat"><i class="fa fa-search"></i></button>
                      </span>
                    </div>
                  </div>
                  {{-- Diskon Penjualan --}}
                  <div class="form-group row">
                    <label for="diskon" class="col-lg-3 control-label">Diskon</label>
                    <div class="col-lg-9">
                        <input type="number" name="diskon" id="diskon" class="form-control" value="{{ ! empty($memberSelected->id_member) ? $diskon2 : 0  }}" readonly>
                    </div>
                  </div>
                  {{-- Bayar --}}
                  <div class="form-group row">
                    <label for="bayar" class="col-lg-3 control-label">Bayar</label>
                    <div class="col-lg-9">
                        <input type="text" id="bayarrp" class="form-control" required readonly>
                    </div>
                  </div>
                  {{-- Poin --}}
                  <div class="form-group row">
                    <label for="poin_member" class="col-lg-3 control-label">Poin Bertambah</label>
                    <div class="col-lg-9">
                        <input type="number" name="total_poin" id="total_poin" class="form-control" required readonly>
                    </div>
                  </div>
                  {{-- Diterima --}}
                  <div class="form-group row">
                    <label for="diterima" class="col-lg-3 control-label">Diterima</label>
                    <div class="col-lg-9">
                        <input type="text" id="diterima" name="diterima" class="form-control" required value="{{  $penjualan->diterima ?? 0  }}">
                    </div>
                  </div>
                  {{-- Kembali --}}
                  <div class="form-group row">
                    <label for="kembali" class="col-lg-3 control-label">Kembali</label>
                    <div class="col-lg-9">
                        <input type="text" id="kembali" name="kembali" class="form-control" required value="0" readonly>
                    </div>
                  </div>
                  {{-- Nama Customer --}}
                  <div class="form-group row">
                    <label for="customer name" class="col-lg-3 control-label">Nama Customer</label>
                    <div class="col-lg-9">
                        <input type="text" name="customer_name" id="nama_member" class="form-control">
                    </div>
                  </div>
                  {{-- Keterangan --}}
                  <div class="form-group row">
                    <label for="Keterangan" class="col-lg-3 control-label">Keterangan</label>
                    <div class="col-lg-9">
                      <textarea name="keterangan" rows="3" class="form-control" placeholder="Keterangan" required></textarea>
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

  @includeIf('pages.admin.transaction-detail.product')
  @includeIf('pages.admin.transaction-detail.member')
  {{-- @includeIf('pages.admin.transaction-detail.edit') --}}

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
    let table, table1;

    $(function () {
      $('body').addClass('sidebar-collapse');
      
      table = $('.table-penjualan').DataTable({
        processing: true,
        autoWidth: false,
        dom: 'Brt',
        bSort: false,
        ajax: {
          url: '{{ route('transaction_details.data', $transactions_id) }}',
        },
        columns: [
          {class: 'text-center', data: 'DT_RowIndex', searchable:false, sortable:false},
          {class: 'text-center', data: 'code_product'},
          {class: 'text-center', data: 'poin'},
          {class: 'text-center', data: 'name_product'},
          {class: 'text-center', data: 'jumlah'},
          {class: 'text-center', data: 'harga_jual'},
          {class: 'text-center', data: 'diskon'},
          {class: 'text-center', data: 'subtotal'},
          {class: 'text-center', data: 'aksi', searchable:false, sortable:false},
        ]        
      })
      .on('draw.dt', function () {
          loadForm($('#diskon').val());
          setTimeout(() => {
                $('#diterima').trigger('input');
            }, 300);
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
                alert('Jumlah tidak boleh lebih dari 10000');
                return;
            }

            $.post(`{{ url('/admin/data-transaction/transaction-details') }}/${id}`, {
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
                    alert('Tidak dapat menyimpan data');
                    return;
                });
      });

      $(document).on('input', '#diskon', function () {
          if ($(this).val() == "") {
              $(this).val(0).select();
          }
          loadForm($(this).val());
      });

      $('#diterima').on('input', function () {
            if ($(this).val() == "") {
                $(this).val(0).select();
            }

            loadForm($('#diskon').val(), $(this).val());
      }).focus(function () {
          $(this).select();
      });

      $('.btn-simpan').on('click', function () {
            $('.form-penjualan').submit();
      });

      $('#modal-form').validator().on('submit', function (e) {
          if (! e.preventDefault()) {
              $.post($('#modal-form form').attr('action'), $('#modal-form form').serialize())
                .done((response) => {
                    $('#modal-form').modal('hide');
                    table.ajax.reload();
                })
                .fail((errors) => {
                    alert('Tidak dapat menyimpan data');
                    return;
                });
            }
        });
      });

    function tampilProduk() {
        $('#modal-produk').modal('show');
    }

    function hideProduk() {
        $('#modal-produk').modal('hide');
    }

    function pilihProduk(id, code, name_product, harga_jual, diskon) {
        $('#id_produk').val(id);
        $('#code').val(code);
        $('#name_product').val(name_product);
        $('#harga_jual').val(harga_jual);
        $('#diskon_product').val(diskon);
        $('#qty').val(1);
        hideProduk();
    }

    function tampilMember() {
        $('#modal-member').modal('show');
    }

    function pilihMember(id, code_member, nama_member) {
        $('#id_member').val(id);
        $('#code_member').val(code_member);
        $('#nama_member').val(nama_member);
         $('#diskon').val('{{ $diskon2 }}');
        loadForm($('#diskon').val());
        $('#diterima').val(0).focus().select();
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

    function loadForm(diskon = 0, diterima = 0) {
        $('#total').val($('.total').text());
        $('#total_item').val($('.total_item').text());
        $('#total_poin').val($('.total_poin').text());

        $.get(`{{ url('admin/data-transaction/transaction-detail/loadform') }}/${diskon}/${$('.total').text()}/${diterima}`)
            .done(response => {
                $('#totalrp').val('Rp'+ response.totalrp);
                $('#bayarrp').val('Rp'+ response.bayarrp);
                $('#bayar').val(response.bayar);
                $('#poin').val(response.poin);
                $('.tampil-bayar').text('Bayar: Rp. '+ response.bayarrp);
                $('.tampil-terbilang').text(response.terbilang);

                $('#kembali').val('Rp'+ response.kembalirp);
                if ($('#diterima').val() != 0) {
                    $('.tampil-bayar').text('Kembali: Rp'+ response.kembalirp);
                    $('.tampil-terbilang').text(response.kembali_terbilang);
                }
            })
            .fail(errors => {
                alert('Tidak dapat menampilkan data2');
                return;
            })
    }

    // function sum() {
    //     var jumlah = document.getElementById('jumlah').value;
    //     var price = document.getElementById('harga_jual').value;
    //     var diskon = document.getElementById('diskon').value;
    //     var result = parseInt(jumlah) * parseInt(price) * parseInt(diskon)/100;
    //     if (!isNaN(result)) {
    //         document.getElementById('subtotal').value = result;
    //     }
    // }

    // function editForm(url) {
    //     $('#modal-form').modal('show');
    //     $('#modal-form .modal-title').text('Edit Produk');

    //     $('#modal-form form')[0].reset();
    //     $('#modal-form form').attr('action', url);
    //     $('#modal-form [name=_method]').val('put');
    //     $('#modal-form [name=jumlah]').focus();

    //     $.get(url)
    //         .done((response) => {
    //             $('#modal-form [name=code]').val(response.code);
    //             $('#modal-form [name=jumlah]').val(response.jumlah);
    //             $('#modal-form [name=harga_jual]').val(response.harga_jual);
    //             $('#modal-form [name=subtotal]').val(response.subtotal);
    //             $('#modal-form [name=diskon]').val(response.diskon);
    //         })
    //         .fail((errors) => {
    //             alert('Tidak dapat menampilkan data');
    //             return;
    //         });
    // }       

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