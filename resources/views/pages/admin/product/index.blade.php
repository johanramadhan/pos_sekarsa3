@extends('layouts.admin')

@section('title')
    Data Aset
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
@endpush

@section('content')
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
            <h1 class="m-0">Aset</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active">Data Aset</li>
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
                <h3 class="card-title">Data Aset</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <div class="table-responsive">
                  <table id="example1" class="table table-bordered table-striped">
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-primary">
                      + Aset
                    </button>
                    <thead>
                      <tr>
                        <th>No</th>
                        <th>Nama Barang</th>
                        <th>Pemilik Barang</th>
                        <th>Kategori</th>
                        <th>Kondisi</th>
                        <th>Status</th>
                        <th>Jumlah</th>
                        <th>Satuan</th>
                        <th>Harga</th>
                        <th>Total Harga</th>
                        <th>Fungsi</th>
                        <th>Foto</th>
                        <th>Aksi</th>
                      </tr>
                    </thead>
                    <tbody>
                      @forelse ($products as $item)
                        <tr>
                          <td>{{ $loop->iteration }}</td>
                          <td>{{ $item->name }}</td>
                          <td>Bidang {{ $item->user->bidang }}</td>
                          <td>{{ $item->category->name }}</td>
                          <td>{{ $item->kondisi }}</td>
                          <td>{{ $item->status }}</td>
                          <td>{{ $item->qty }}</td>
                          <td>{{ $item->satuan }}</td>
                          <td>{{ number_format($item->price) }}</td>
                          <td>{{ number_format($item->total_price) }}</td>
                          <td>{{ $item->fungsi }}</td>
                          <td>
                            <img src="{{Storage::url($item->galleries->first()->photos ?? 'tidak ada foto')}}" style="max-height: 50px;">
                          </td>
                          <td>
                            <div class="btn-group">
                              <div class="dropdown">
                                <button class="btn btn-primary dropdown-toggle mr-1 mb-1"        
                                  type="button"
                                  data-toggle="dropdown">
                                  Aksi
                                </button>
                                <div class="dropdown-menu">
                                  <a class="dropdown-item" href="{{ route('aset.edit', $item->id) }}">
                                    Sunting
                                  </a>
                                  <button type="submit" id="delete" href="{{ route('aset.destroy', $item->id) }}" 
                                    class="dropdown-item text-danger">
                                    Hapus
                                  </button>
                                  <form action="" method="POST" id="deleteForm">
                                    @csrf
                                    @method("DELETE")
                                    <input type="submit" value="Hapus" style="display: none">
                                    
                                  </form>
                                </div>
                              </div>
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

  <div class="modal fade" id="modal-primary">
    <div class="modal-dialog modal-xl">
      <form action="{{ route('aset.store') }}" method="POST" enctype="multipart/form-data">
      @csrf
        <div class="modal-content bg-default">
          <div class="modal-header">
            <h4 class="modal-title">Tambah Aset</h4>
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
                            <label>Nama Barang</label>
                            <input
                              type="text"
                              name="name"
                              class="form-control"
                              placeholder="Nama Barang"
                              required
                            />
                          </div>
                          <!-- /.Nama Barang --> 
                          <div class="form-group">
                            <label>Kategori</label>
                            <select name="categories_id" class="form-control select2">
                              <option>--Pilih Kategori--</option>
                              @foreach ($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                              @endforeach
                            </select>                            
                          </div>
                          <!-- /.Kategori -->             
                          <div class="form-group">
                            <label>User</label>
                            <select name="users_id" class="form-control select2">
                              <option>--Pilih Bidang--</option>
                              @foreach ($users as $user)
                                <option value="{{ $user->id }}">{{ $user->bidang }}</option>
                              @endforeach
                            </select>                            
                          </div>
                          <!-- /.bidang -->             
                          <div class="form-group">
                            <label>Kondisi</label>
                            <select name="kondisi" class="form-control select2" required>
                              <option>--Pilih kondisi--</option>
                              <option value="Baik">Baik</option>
                              <option value="Rusak Ringan">Rusak Ringan</option>
                              <option value="Rusak Berat">Rusak Berat</option>
                            </select>                            
                          </div>
                          <!-- /.kondisi -->             
                          <div class="form-group">
                            <label>Status</label>
                            <select name="status" class="form-control select2" required>
                              <option>--Pilih status--</option>
                              <option value="Pembelian">Pembelian</option>
                              <option value="Hibah">Hibah</option>
                              <option value="Lain-lain">Lain-lain</option>
                            </select>                            
                          </div>
                          <!-- /.status -->  
                          <div class="form-group">
                            <label>Merek</label>
                            <input
                              type="text"
                              name="brand"
                              class="form-control"
                              placeholder="Merek Barang"
                              required
                            />
                          </div>
                          <!-- /.merek -->      
                        </div>
                        <div class="col-md-6">
                          <div class="form-group">
                            <label>Satuan</label>
                            <select name="satuan" class="form-control select2" required>
                              <option>--Pilih satuan--</option>
                              <option value="Bidang">Bidang</option>
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
                          <!-- /.satuan --> 
                          <div class="form-group">
                            <label>Jumlah</label>
                            <input
                              type="number"
                              name="qty"
                              id="qty" 
                              onkeyup="sum()"
                              class="form-control"
                              placeholder="Jumlah Barang"
                              required
                            />
                          </div>
                          <!-- /.Jumlah -->            
                          <div class="form-group">
                            <label>Harga Satuan</label>
                            <input
                              type="number"
                              name="price"
                              id="price" 
                              onkeyup="sum()"
                              class="form-control"
                              placeholder="Harga Satuan"
                              required
                            />
                          </div>
                          <!-- /.Harga Satuan -->            
                          <div class="form-group">
                            <label>Total Harga</label>
                            <input
                              type="number"
                              name="total_price"
                              id="total_price"
                              class="form-control"
                              placeholder="Total Harga"
                              readonly
                            />
                          </div>
                          <!-- /.Total Harga -->
                          <div class="form-group">
                            <label>Link Video</label> (<i><small>Kosongkan jika tidak ada link</small></i>)
                            <input
                              type="text"
                              name="link"
                              class="form-control"
                              placeholder="Link Video Barang"
                            />
                          </div>
                          <!-- /.link -->
                          <div class="form-group">
                            <label>Fungsi Barang</label>
                            <textarea class="form-control" name="fungsi" rows="1" placeholder="Fungsi/kegunaan barang"></textarea>
                          </div>
                          <!-- /.Fungsi -->
                        </div>
                        <div class="col-md-12">
                          <div class="form-group">
                            <label>Deskripsi Barang</label>
                            <textarea id="summernote" name="description" rows="3" required>
                              Tuliskan deskripsi atau spesifikasi barang
                            </textarea>
                          </div>
                          <!-- /.deskripsi -->
                          <div class="form-group">
                            <label>Thumbnail</label>
                            <input type="file" name="photos" class="form-control"/>
                            <p class="text-muted">
                              Masukkan gambar barang
                            </p>
                          </div>
                          <!-- /.deskripsi -->
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
            'Data kategori berhasil dihapus.',
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