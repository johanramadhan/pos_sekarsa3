@extends('layouts.admin')

@section('title')
    Aset
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
                        <th>Kategori</th>
                        <th>Nama Aset</th>
                        <th>Jumlah</th>
                        <th>Satuan</th>
                        <th>Harga Satuan</th>
                        <th>Total Harga</th>
                        <th>Pemilik</th>
                        <th>Keterangan</th>
                        <th>Aksi</th>
                      </tr>
                    </thead>
                    <tbody>
                      @forelse ($products as $item)
                        <tr>
                          <td>{{ $loop->iteration }}</td>
                          <td>{{ $item->category->name }}</td>
                          <td>{{ $item->name }}</td>
                          <td>{{ $item->qty }}</td>
                          <td>{{ $item->satuan }}</td>
                          <td>Rp{{ number_format($item->price) }}</td>
                          <td>Rp{{ number_format($item->total_price) }}</td>
                          <td>{{ $item->user->name }}</td>
                          <td>{{ $item->description }}</td>
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
                                  <form action="{{ route('daset.destroy', $item->id) }}" method="POST">
                                    {{method_field('delete')}} {{  csrf_field()}}
                                    <button type="submit" class="dropdown-item text-danger">
                                      Hapus
                                    </button>
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
                            <label>Kategori Barang</label>
                            <select class="form-control select2" name="categories_id" style="width: 100%;">
                              <option value="1">1</option>
                              @foreach ($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                              @endforeach
                            </select>
                          </div>
                          <!-- /.Kategori -->
                          <div class="form-group">
                            <label>Bidang Pemilik</label>
                            <select class="form-control select2" name="users_id" style="width: 100%;">
                              <option value="1">1</option>
                              @foreach ($users as $user)
                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                              @endforeach
                            </select>
                          </div>
                          <!-- /.Pemilik -->
                          <div class="form-group">
                            <label>Nama Barang</label>
                            <input
                              type="text"
                              name="name"
                              class="form-control"
                              id="exampleInputPassword1"
                              placeholder="Nama Barang"
                              required
                            />
                          </div>
                          <!-- /.Nama Barang -->
                          <div class="form-group">
                            <label>Kondisi</label>
                            <select class="form-control" name="kondisi" style="width: 100%;">
                              <option selected="selected" value="Baik">Baik</option>
                              <option value="Rusak Ringan">Rusak Ringan</option>
                              <option value="Rusak Berat">Rusak Berat</option>
                            </select>
                          </div>
                          <!-- /.Kondisi -->
                          <div class="form-group">
                            <label>Status</label>
                            <select class="form-control" name="status" style="width: 100%;">
                              <option selected="selected" value="Pembelian">Pembelian</option>
                              <option value="Hibah">Hibah</option>
                            </select>
                          </div>
                          <!-- /.Status -->                
                        </div>

                        <div class="col-md-6">
                          <div class="form-group">
                            <label>Satuan</label>
                            <select name="satuan" class="form-control select2">
                              <option value="Bidang">Bidang</option>
                              <option value="Unit">Unit</option>
                              <option value="Buah">Buah</option>
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
                          <!-- /.Satuan -->
                          <div class="form-group">
                            <label>Jumlah</label>
                            <input
                              type="number"
                              name="qty" 
                              id="qty" 
                              onkeyup="sum()"
                              class="form-control"
                              placeholder="Jumlah Barang"
                            />
                          </div>
                          <!-- /.Jumlah Barang -->
                          <div class="form-group">
                            <label>Harga Satuan</label>
                            <input
                              type="number"
                              name="price" 
                              id="price" 
                              onkeyup="sum()"
                              class="form-control"
                              placeholder="Harga Satuan"
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
                              disabled
                            />
                          </div>
                          <!-- /.Total Harga -->    
                          <div class="form-group">
                            <label>Merek Barang</label>
                            <input
                              type="text"
                              name="brand"
                              class="form-control"
                              placeholder="Merek Barang"
                            />
                          </div>
                          <!-- /.Merek Barang -->          
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-md-12">
                          <!-- /.Link Video --> 
                          <div class="form-group">
                            <label>Link Video</label>
                            <input
                              type="text"
                              name="link"
                              class="form-control"
                              placeholder="Link Video"
                            />
                          </div>
                          <!-- fungsi -->
                          <div class="form-group">
                            <label>Fungsi</label>
                            <textarea
                              class="form-control"
                              name="fungsi"
                              rows="3"
                              placeholder="Fungsi Barang"
                            ></textarea>
                          </div>
                          <!-- Keterangan -->
                          <div class="form-group">
                            <label>Keterangan/Spesifikasi</label>
                            <textarea
                              class="form-control"
                              rows="3"
                              placeholder="Keterangan/Spesifikasi"
                              name="description"
                              id="summernote"
                            ></textarea>
                          </div>
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
@endpush