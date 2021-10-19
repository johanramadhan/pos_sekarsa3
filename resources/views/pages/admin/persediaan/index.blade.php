@extends('layouts.admin')

@section('title')
    Data Persediaan
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
            <h1 class="m-0">Persediaan </h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active">Data Persediaan</li>
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
                <h3 class="card-title">Data Persediaan</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <div class="table-responsive">
                  <table class="table table-bordered table-striped table-persediaan">
                    <button type="button" class="btn btn-primary mb-3" data-toggle="modal" data-target="#modal-primary">
                      + Persediaan
                    </button>
                    <a href="{{ route('productExportPdf') }}" class="btn btn-danger ml-3 mb-3">
                      Print PDF
                    </a>
                    <thead>
                      <tr class="text-center">
                        <th>No</th>
                        <th>Kode Persediaan</th>
                        <th>Nama Persediaan</th>
                        <th>Merek</th>
                        <th>Kategori</th>
                        <th>Jumlah Stok</th>
                        <th>Total Berat</th>
                        <th>Harga Beli</th>
                        <th>Status</th>
                        <th>Foto</th>
                        <th>Aksi</th>
                      </tr>
                    </thead>
                    <tbody>
                      @forelse ($persediaans as $item)
                        <tr>
                          <td>{{ $loop->iteration }}</td>
                          <td>{{ $item->code }}</td>
                          <td>{{ $item->name_persediaan }}</td>
                          <td>{{ $item->merk }}</td>
                          <td>{{ $item->category->name }}</td>
                          <td class="text-center">{{ $item->stok ?? 0 }} {{ $item->satuan }}</td>
                          <td class="text-center">{{ $item->total_berat ?? 0 }} {{ $item->satuan_berat }}</td>
                          <td>Rp{{ format_uang($item->harga_beli) }}</td>
                          <td class="text-center">
                            @if (($item->total_berat) == 0)
                              <span class="badge badge-danger">Habis</span> 
                            @elseif(($item->total_berat) <= 100)
                              <span class="badge badge-warning">Warning</span>
                            @elseif(($item->total_berat) >= 100)
                              <span class="badge badge-success">Aman</span>
                            @endif
                          </td>
                          <td>
                            <img src="{{Storage::url($item->galleries->first()->photos ?? 'tidak ada foto')}}" style="max-height: 50px;">
                          </td>
                          <td class="text-center">
                            <div class="btn-group">
                              <button onclick="editForm( '{{ route('persediaan.update', $item->id_persediaan) }}')" class="btn btn-xs btn-warning btn-flat m-1"><i class="fa fa-edit"></i></button>
                              <button onclick="showDetail( '{{ route('persediaan.detail', $item->id_persediaan) }}')" class="btn btn-xs btn-info btn-flat m-1"><i class="fa fa-eye"></i></button>
                              <button type="submit" id="delete" href="{{ route('persediaan.destroy', $item->id_persediaan) }}" 
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
            </div><!-- /.card -->
          </div>
          <!-- /.col-md-6 -->
        </div>
        <!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
  </div>

  @includeIf('pages.admin.persediaan.detail')
  @includeIf('pages.admin.persediaan.form')

  <div class="modal fade" id="modal-primary">
    <div class="modal-dialog modal-xl">
      <form action="{{ route('persediaan.store') }}" method="POST" enctype="multipart/form-data">
      @csrf
        <div class="modal-content bg-default">
          <div class="modal-header">
            <h4 class="modal-title">Tambah Persediaan</h4>
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
                            <label>Kode Persediaan*</label>
                            <input
                              type="text"
                              name="code"
                              class="form-control"
                              placeholder="Kode Persediaan"
                              readonly
                              value="{{$code}}"
                              readonly
                            />
                          </div>
                          <!-- /.Kode Persediaan --> 
                          <div class="form-group">
                            <label>Nama Persediaan*</label>
                            <input
                              type="text"
                              name="name_persediaan"
                              class="form-control"
                              placeholder="Nama Persediaan"
                              required
                            />
                          </div>
                          <!-- /.Nama Persediaan --> 
                          <div class="form-group">
                            <label>Kategori*</label>
                            <select name="categories_id" class="form-control select2">
                              <option>--Pilih Kategori--</option>
                              @foreach ($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                              @endforeach
                            </select>                            
                          </div>
                          <!-- /.Kategori --> 
                        </div>
                        <div class="col-md-6">
                          <div class="form-group">
                            <label>Satuan Barang*</label>
                            <select name="satuan" class="form-control select2" required>
                              <option>--Pilih satuan--</option>
                              <option value="Gram">Gram</option>
                              <option value="Kilogram">Kilogram</option>
                              <option value="Bungkus">Bungkus</option>
                              <option value="Unit">Unit</option>
                              <option value="Buah">Buah</option>
                              <option value="Botol">Botol</option>
                              <option value="Stell">Stell</option>
                              <option value="Jalan">Jalan</option>
                              <option value="Paket">Paket</option>
                              <option value="Besi">Besi</option>
                              <option value="Biro">Biro</option>
                              <option value="Fiber">Fiber</option>
                              <option value="Gros">Gros</option>
                              <option value="Helai">Helai</option>
                              <option value="Kali">Kali</option>
                              <option value="Kayu">Kayu</option>
                              <option value="Lembar">Lembar</option>
                              <option value="Lusin">Lusin</option>
                              <option value="Meter">Meter</option>
                              <option value="Pcs">Pcs</option>
                              <option value="Peket">Peket</option>
                              <option value="Plastik">Plastik</option>
                              <option value="Plong">Plong</option>
                              <option value="SET">SET</option>
                              <option value="Shet">Shet</option>
                              <option value="Stenlis">Stenlis</option>
                              <option value="Beton">Beton</option>
                              <option value="M2">M2</option>
                              <option value="Exp">Exp</option>
                              <option value="Kaleng">Kaleng</option>
                              <option value="Kotak">Kotak</option>
                              <option value="Pasang">Pasang</option>
                              <option value="Slop">Slop</option>
                              <option value="Sambungan">Sambungan</option>
                              <option value="m'">m'</option>
                              <option value="KVA">KVA</option>
                              <option value="Keping">Keping</option>
                            </select>                            
                          </div>
                          <!-- /.satuan -->   
                          <div class="form-group">
                            <label>Satuan Berat*</label>
                            <select name="satuan_berat" class="form-control select2" required>
                              <option>--Pilih satuan--</option>
                              <option value="Gram">Gram</option>
                              <option value="Kilogram">Kilogram</option>
                              <option value="Unit">Unit</option>
                              <option value="Buah">Buah</option>
                              <option value="Roll">Roll</option>
                              <option value="Stell">Stell</option>
                              <option value="Jalan">Jalan</option>
                              <option value="Paket">Paket</option>
                              <option value="Besi">Besi</option>
                              <option value="Biro">Biro</option>
                              <option value="Fiber">Fiber</option>
                              <option value="Gros">Gros</option>
                              <option value="Helai">Helai</option>
                              <option value="Kali">Kali</option>
                              <option value="Kayu">Kayu</option>
                              <option value="Lembar">Lembar</option>
                              <option value="Lusin">Lusin</option>
                              <option value="Meter">Meter</option>
                              <option value="Pcs">Pcs</option>
                              <option value="Peket">Peket</option>
                              <option value="Plastik">Plastik</option>
                              <option value="Plong">Plong</option>
                              <option value="SET">SET</option>
                              <option value="Shet">Shet</option>
                              <option value="Stenlis">Stenlis</option>
                              <option value="Beton">Beton</option>
                              <option value="M2">M2</option>
                              <option value="Exp">Exp</option>
                              <option value="Kaleng">Kaleng</option>
                              <option value="Kotak">Kotak</option>
                              <option value="Pasang">Pasang</option>
                              <option value="Slop">Slop</option>
                              <option value="Sambungan">Sambungan</option>
                              <option value="m'">m'</option>
                              <option value="KVA">KVA</option>
                              <option value="Keping">Keping</option>
                            </select>                            
                          </div>
                          <!-- /.satuan berat -->             
                          <div class="form-group">
                            <label>Harga Beli*</label>
                            <input
                              type="number"
                              name="harga_beli"
                              class="form-control"
                              placeholder="Harga Modal"
                              required
                            />
                          </div>
                          <!-- /.Harga Modal -->                          
                        </div>
                        <div class="col-md-12">
                          <div class="form-group">
                            <label>Merk</label>
                            <textarea class="form-control" name="merk" rows="3" placeholder="Merk Barang"></textarea>
                          </div>
                          <!-- /.Fungsi -->
                          <div class="form-group">
                            <label>Thumbnail*</label>
                            <input type="file" name="photos" class="form-control" required/>
                            <p class="text-muted">
                              Masukkan gambar barang
                            </p>
                          </div>
                          <!-- /.Thumbnail -->
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
        var qty = document.getElementById('qty').value;
        var price = document.getElementById('price').value;
        var result = parseInt(price) * parseInt(qty);
        if (!isNaN(result)) {
            document.getElementById('total_price').value = result;
        }
    }
  </script>

  <script>
    let table, table1;

    $(function () {
      table = $('.table-persediaan').DataTable({
        processing: true,
        autoWidth: false,  
      });

      table1 = $('.table-detail-persediaan').DataTable({
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
      $('#modal-form .modal-title').text('Edit Persediaan');

      $('#modal-form form')[0].reset();
      $('#modal-form form').attr('action', url);
      $('#modal-form [name=_method]').val('put');
      $('#modal-form [name=name_persediaan]').focus();

      $.get(url)
        .done((response) => {
            $('#modal-form [name=code]').val(response.code);
            $('#modal-form [name=name_persediaan]').val(response.name_persediaan);
            $('#modal-form [name=categories_id]').val(response.categories_id);
            $('#modal-form [name=satuan]').val(response.satuan);
            $('#modal-form [name=satuan_berat]').val(response.satuan_berat);
            $('#modal-form [name=harga_beli]').val(response.harga_beli);
            $('#modal-form [name=merk]').val(response.merk);
            $('#modal-form [name=photos]').val(response.photos);
        })
        .fail((errors) => {
            alert('Tidak dapat menampilkan data');
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