@extends('layouts.admin')

@section('title')
    Data Produk
@endsection

@push('addon-style')
  <link rel="stylesheet" href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')}}">
  <link rel="stylesheet" href="{{ asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css')}}">
  <link rel="stylesheet" href="{{ asset('plugins/datatables-buttons/css/buttons.bootstrap4.min.css')}}">
  <!-- Select2 -->
  <link rel="stylesheet" href="{{ asset('plugins/select2/css/select2.min.css') }}">
  <link rel="stylesheet" href="{{ asset('plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{asset('dist/css/adminlte.min.css')}}">
  <!-- summernote -->
  <link rel="stylesheet" href="{{ asset('plugins/summernote/summernote-bs4.min.css') }}">
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/dt-1.10.21/datatables.min.css"/>
@endpush

@section('content')
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
            <h1 class="m-0">Produk </h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active">Data Produk</li>
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
                <h3 class="card-title">Data Produk</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <div class="table-responsive">
                  <table class="table table-produk table-bordered table-striped">
                    <button type="button" class="btn btn-primary mb-3" data-toggle="modal" data-target="#modal-primary">
                      + Produk
                    </button>
                    <a href="{{ route('productExportPdf') }}" class="btn btn-danger ml-3 mb-3">
                      Print PDF
                    </a>
                    <thead>
                      <tr class="text-center">
                        <th>No</th>
                        <th>Kode Produk</th>
                        <th>Poin</th>
                        <th>Nama Produk</th>
                        <th>Kategori</th>
                        <th>Diskon</th>
                        <th>Jumlah Stok</th>
                        <th>Satuan</th>
                        <th>Berat</th>
                        <th>Harga Modal</th>
                        <th>Harga Jual</th>
                        <th>Aksi</th>
                      </tr>
                    </thead>
                    <tbody>
                      @forelse ($products as $item)
                        <tr>
                          <td>{{ $loop->iteration }}</td>
                          <td>{{ $item->code }}</td>
                          <td class="text-center">{{ $item->poin }}</td>
                          <td>{{ $item->name_product }}</td>
                          <td>{{ $item->category->name }}</td>
                          <td class="text-center">{{ format_uang($item->diskon) }}%</td>
                          <td class="text-center">
                            @if (($item->stok) == 0)
                              <span class="badge badge-danger">Habis</span> 
                            @else
                              {{ $item->stok }}
                            @endif
                          </td>
                          <td class="text-center">{{ $item->satuan }}</td>
                          <td class="text-center">{{ $item->berat }} {{ $item->satuan_berat }}</td>
                          <td class="text-center">Rp{{ format_uang($item->harga_beli) }}</td>
                          <td class="text-center">Rp{{ format_uang($item->harga_jual) }}</td>
                          <td class="text-center">
                            <div class="btn-group">
                              <button onclick="editForm( '{{ route('produk.update', $item->id_produk) }}')" class="btn btn-xs btn-warning btn-flat m-1"><i class="fa fa-edit"></i></button>
                              <button onclick="showDetail( '{{ route('produk.detail', $item->id_produk) }}')" class="btn btn-xs btn-info btn-flat m-1"><i class="fa fa-eye"></i></button>
                              <button type="submit" id="delete" href="{{ route('produk.destroy', $item->id_produk) }}" 
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

  @includeIf('pages.admin.produk.detail')
  @includeIf('pages.admin.produk.form')

  <div class="modal fade" id="modal-primary">
    <div class="modal-dialog modal-xl">
      <form action="{{ route('produk.store') }}" method="POST" enctype="multipart/form-data">
      @csrf
        <div class="modal-content bg-default">
          <div class="modal-header">
            <h4 class="modal-title">Tambah Produk</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="container-fluid">
              <div class="row">
                <div class="col-md-12">
                  @if ($errors->any())
                    <div class="alert alert-danger">
                      <ul>
                        @foreach ($errors->all() as $error)
                          <li>{{ $error }}</li>
                        @endforeach
                      </ul>
                    </div>
                  @endif
                  <div class="card card-primary">
                    <div class="card-body">
                      <div class="row">
                        <div class="col-md-6">
                          <div class="form-group">
                            <label>Kode Produk*</label>
                            <input
                              type="text"
                              name="code"
                              class="form-control"
                              placeholder="Kode Barang"
                              readonly
                              value="{{$code}}"
                            />
                          </div>
                          <!-- /.Kode Barang --> 
                          <div class="form-group">
                            <label>Nama Produk*</label>
                            <input
                              type="text"
                              name="name_product"
                              class="form-control"
                              placeholder="Nama Barang"
                              required
                            />
                          </div>
                          <!-- /.Nama Barang --> 
                          <div class="form-group">
                            <label>Kategori*</label>
                            <select name="categories_id" class="form-control select2" required>
                              <option>--Pilih Kategori--</option>
                              @foreach ($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                              @endforeach
                            </select>                            
                          </div>
                          <!-- /.Kategori --> 
                          <div class="form-group">
                            <label>Satuan Barang*</label>
                            <select name="satuan" class="form-control select2" required>
                              <option>--Pilih satuan--</option>
                              @foreach ($satuans as $item)
                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                              @endforeach
                            </select>                            
                          </div>
                          <!-- /.satuan -->    
                          <div class="form-group">
                            <label>Satuan Berat*</label>
                            <select name="satuan_berat" class="form-control select2" required>
                              <option>--Pilih satuan berat--</option>
                              <option value="Kilogram">Kilogram</option>
                              <option value="Gram">Gram</option>
                            </select>                            
                          </div>
                          <!-- /.satuan berat-->  
                          <div class="form-group">
                            <label>Poin</label>
                            <input
                              type="number"
                              name="poin"
                              class="form-control"
                              placeholder="Poin"
                            />
                          </div>
                          <!-- /.Poin -->   
                        </div>
                        <div class="col-md-6">    
                          <div class="form-group">
                            <label>diskon</label>
                            <input
                              type="number"
                              name="diskon"
                              class="form-control"
                              placeholder="Masukkan diskon"
                              required
                            />
                          </div>
                          <!-- /.Diskon -->       
                          <div class="form-group">
                            <label>Harga Modal*</label>
                            <input
                              type="number"
                              name="harga_beli"
                              class="form-control"
                              placeholder="Harga Modal"
                              required
                            />
                          </div>
                          <!-- /.Harga Modal -->  
                          <div class="form-group">
                            <label>Harga Jual*</label>
                            <input
                              type="number"
                              name="harga_jual"
                              class="form-control"
                              placeholder="Harga Jual"
                              required
                            />
                          </div>
                          <!-- /.Harga Jual -->                                
                          <div class="form-group">
                            <label>Merk</label> (<i><small>Kosongkan jika tidak ada merek</small></i>)
                            <input
                              type="text"
                              name="merk"
                              class="form-control"
                              placeholder="Masukkan Merk"
                            />
                          </div>
                          <!-- /.Merk --> 
                          <div class="form-group">
                          <label>Stok*</label>
                          <input
                            type="text"
                            name="stok"
                            class="form-control"
                            placeholder="Masukkan Stok"
                            required
                          />
                        </div>
                        <!-- /.Stok -->                           
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="modal-footer justify-content-between">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Save</button>
          </div>
        </div>
      </form>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>
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
    function sum() {
        var stok = document.getElementById('stok').value;
        var berat = document.getElementById('berat').value;
        var result = parseInt(stok) * parseInt(berat);
        if (!isNaN(result)) {
            document.getElementById('total_berat').value = result;
        }
    }
  </script>

  <script>
    let table, table1;

    $(function () {
      table = $('.table-produk').DataTable({
        processing: true,
        autoWidth: false,  
      });

      table1 = $('.table-detail-produk').DataTable({
        processing: true,
          columns: [
            {data: 'DT_RowIndex', searchable: false, sortable: false},
            {data: 'stok'},
            {data: 'satuan'},
            {data: 'berat'},
            {data: 'total_berat'},
            {data: 'satuan_berat'},
            {data: 'harga_beli'},
            {data: 'diskon'},
        ]
      });
    });

    function showDetail(url) {
      $('#modal-detail').modal('show');

      table1.ajax.url(url);
      table1.ajax.reload();
    }

    function editForm(url) {
      $('#modal-form').modal('show');
      $('#modal-form .modal-title').text('Edit Produk');

      $('#modal-form form')[0].reset();
      $('#modal-form form').attr('action', url);
      $('#modal-form [name=_method]').val('put');
      $('#modal-form [name=name_persediaan]').focus();

      $.get(url)
        .done((response) => {
            $('#modal-form [name=code]').val(response.code);
            $('#modal-form [name=name_product]').val(response.name_product);
            $('#modal-form [name=categories_id]').val(response.categories_id);
            $('#modal-form [name=stok]').val(response.stok);
            $('#modal-form [name=satuan]').val(response.satuan);
            $('#modal-form [name=berat]').val(response.berat);
            $('#modal-form [name=total_berat]').val(response.total_berat);
            $('#modal-form [name=satuan_berat]').val(response.satuan_berat);
            $('#modal-form [name=poin]').val(response.poin);
            $('#modal-form [name=merk]').val(response.merk);
            $('#modal-form [name=stok]').val(response.stok);
            $('#modal-form [name=diskon]').val(response.diskon);
            $('#modal-form [name=harga_beli]').val(response.harga_beli);
            $('#modal-form [name=harga_diskon]').val(response.harga_diskon);
            $('#modal-form [name=harga_jual]').val(response.harga_jual);
            $('#modal-form [name=status]').val(response.status);
        })
        .fail((errors) => {
            alert('Tidak dapat menampilkan persediaan');
            return;
        });
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