@extends('layouts.admin')

@section('title')
    Transaksi Kas Kecil
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
    .table-kaskecil tbody tr:last-child {
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
            <h1 class="m-0">Transaksi Kas Kecil</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active">Transaksi Kas Kecil</li>
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
                    <h3>INVOICE <b>{{ $codeKaskecil }}</b></h3>
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
              <form action="{{ route('kaskecil_detail.store') }}" class="form-horizontal" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="row">
                  <div class="col-4">
                    <div class="card-body">
                      <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Kasir</label>
                        <div class="col-sm-9">
                          <input type="text" class="form-control" value="{{ Auth::user()->name }}" placeholder="Kasir" readonly>
                          <input type="hidden" class="form-control" name="id_kaskecil" value="{{ $id_kaskecil }}" readonly>
                          <input type="hidden" class="form-control" name="code" value="{{ $code }}">
                        </div>
                      </div>
                      <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Uraian</label>
                        <div class="col-sm-9">
                          <select class="form-control select2bs4" name="uraian" id="uraian" style="width: 100%;">
                            <option>--Pilih Jenis Uang--</option>
                            <option value="Kertas Rp100.000" onclick="pilihProduk('lembar', '100000')">Kertas Rp100.000</option>
                            <option value="Kertas Rp75.000">Kertas Rp75.000</option>
                            <option value="Kertas Rp50.000">Kertas Rp50.000</option>
                            <option value="Kertas Rp20.000">Kertas Rp20.000</option>
                            <option value="Kertas Rp10.000">Kertas Rp10.000</option>
                            <option value="Kertas Rp5.000">Kertas Rp5.000</option>
                            <option value="Kertas Rp2.000">Kertas Rp2.000</option>
                            <option value="Kertas Rp1.000">Kertas Rp1.000</option>
                            <option value="Koin Rp1.000">Koin Rp1.000</option>
                            <option value="Koin Rp500">Koin Rp500</option>
                            <option value="Koin Rp200">Koin Rp200</option>
                            <option value="Koin Rp100">Koin Rp100</option>
                          </select>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-4">
                    <div class="card-body">
                      <label class="col-sm-6">Jumlah</label>
                      {{-- koefisien 1 --}}
                      <div class="form-group row">                        
                        <div class="col-sm-6">
                          <input type="number" class="form-control" name="jumlah" id="qty" placeholder="Volume 1" onkeyup="sum()" required>
                        </div>
                        <div class="col-sm-6">
                          <select class="form-control select2bs4" name="satuan" id="satuan" style="width: 100%;">
                            <option>--Pilih Satuan--</option>
                            <option value="Lembar">Lembar</option>
                            <option value="Keping">Keping</option>
                          </select>
                        </div>
                      </div>
                      <div class="form-group row">
                        <div class="col-sm-12">
                          <input type="number" class="form-control" name="jenis_uang" id="harga_beli" placeholder="Jenis Uang" onkeyup="sum()" required>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-4">
                    <div class="card-body">
                      <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Subtotal</label>
                        <div class="col-sm-9">
                          <input type="text" class="form-control" name="subtotal" id="subtotal" readonly>
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
                  <table class="table table-bordered table-striped table-kaskecil">
                    <thead>
                      <tr>
                        <th class="text-center">No</th>
                        <th class="text-center">Kode</th>
                        <th class="text-center">Uraian</th>
                        <th class="text-center" width="15%">Jumlah</th>
                        <th class="text-center">Jenis Uang</th>
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
            <form action="{{ route('kasKecil.store') }}" class="form-pengeluaran" method="post">
              @csrf
              <input type="hidden" name="id_kaskecil" value="{{ $id_kaskecil }}">
              <input type="hidden" name="total" id="total">
              <input type="hidden" name="total_item" id="total_item">
              <input type="hidden" name="bayar" id="bayar">

              <div class="card">
                <div class="card-body">
                  {{-- Total Pengeluaran --}}
                  <div class="form-group row">
                    <label for="totalrp" class="col-lg-2 control-label">Total</label>
                    <div class="col-lg-10">
                        <input type="text" id="totalrp" class="form-control" readonly>
                    </div>
                  </div>
                  {{-- Diskon Pengeluaran --}}
                  {{-- <div class="form-group row">
                    <label for="diskon" class="col-lg-2 control-label">Diskon</label>
                    <div class="col-lg-10">
                        <input type="number" name="diskon" id="diskon" class="form-control" value="{{ $diskon }}">
                    </div>
                  </div> --}}
                  {{-- Bayar --}}
                  {{-- <div class="form-group row">
                    <label for="bayar" class="col-lg-2 control-label">Bayar</label>
                    <div class="col-lg-10">
                        <input type="text" id="bayarrp" class="form-control" readonly>
                    </div>
                  </div> --}}
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

@endsection

@push('addon-script')
  <!-- Sweet alert -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/1000hz-bootstrap-validator/0.11.9/validator.min.js"></script>
  @include('includes.admin.alerts')
  <!-- Select2 -->
  <script src="{{ asset('plugins/select2/js/select2.full.min.js') }}"></script>
  <!-- DataTables  & Plugins -->
  <script src="{{ asset('plugins/datatables/jquery.dataTables.min.js')}}"></script>
  <script src="{{ asset('plugins/datatables-bs4/js/dataTables.bootstrap4.min.js')}}"></script>

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
    function duplicate() {
      var duplicateQty = document.getElementById('duplicateQty').value;
      var result = duplicateQty;
      if (!isNaN(result)) {
            document.getElementById('qty2').value = result;
        }
    }
    function sum() {
        var qty = document.getElementById('qty').value;
        var price = document.getElementById('harga_beli').value;
        var koefisien = qty * price;
        var result = koefisien;
        if (!isNaN(result)) {
            document.getElementById('subtotal').value = result;
        }
    }
  </script>
  
  <script>
    let table;

    $(function () {
      $('body').addClass('sidebar-collapse');

      table = $('.table-kaskecil').DataTable({
          processing: true,
          autoWidth: false,
          dom: 'Brt',
          bSort: false,
          ajax: {
              url: '{{ route('kaskecil_detail.data', $id_kaskecil) }}',
          },
          columns: [
              {class: 'text-center', data: 'DT_RowIndex', searchable: false, sortable: false},
              {class: 'text-center', data: 'code'},
              {class: 'text-center', data: 'uraian'},
              {class: 'text-center', data: 'jumlah'},
              {class: 'text-center', data: 'jenis_uang'},
              {class: 'text-center', data: 'subtotal'},
              {class: 'text-center', data: 'aksi', searchable: false, sortable: false},
          ]
      })
      .on('draw.dt', function () {
          loadForm($('#diskon').val());
      });       

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

            $.post(`{{ url('/admin/kaskecil/kaskecil_detail') }}/${id}`, {
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

    $('.btn-simpan').on('click', function () {
            $('.form-pengeluaran').submit();
        });
      
    });   
    
    function pilihProduk(satuan, harga_beli) {
        $('#satuan').val(satuan);
        $('#harga_beli').val(harga_beli);
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
        $('#total_item').val($('.total_item').text());

        $.get(`{{ url('admin/kaskecil/kaskecil_detail/loadform') }}/${diskon}/${$('.total').text()}`)
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