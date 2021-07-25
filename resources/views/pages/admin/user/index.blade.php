@extends('layouts.admin')

@section('title')
    Data User
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
            <h1 class="m-0">User</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active">Data User</li>
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
                <h3 class="card-title">Data User</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <div class="table-responsive">
                  <table id="example1" class="table table-bordered table-striped">
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-primary">
                      + User
                    </button>
                    <thead>
                      <tr>
                        <th>No</th>
                        <th>Nama Bidang/Subbag</th>
                        <th>Nama Kepala Bidang/Subbag</th>
                        <th>NIP</th>
                        <th>Email</th>
                        <th>Roles</th>
                        <th>Status User</th>
                        <th>Foto</th>
                        <th>Aksi</th>
                      </tr>
                    </thead>
                    <tbody>
                      @forelse ($users as $item)
                        <tr>
                          <td>{{ $loop->iteration }}</td>
                          <td>{{ $item->bidang }}</td>
                          <td>{{ $item->name }}</td>
                          <td>{{ $item->nip }}</td>
                          <td>{{ $item->email }}</td>
                          <td>{{ $item->roles }}</td>
                          <td class="text-center">
                            @if (($item->store_status) === 1)
                              <span class="badge badge-primary">Aktif</span>
                            @else
                              <span class="badge badge-danger">Tidak Aktif</span>
                            @endif
                          </td>
                          <td>
                            <img src="{{Storage::url($item->photo)}}" style="max-height: 50px;">
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
                                  <a class="dropdown-item" href="{{ route('user.edit', $item->id) }}">
                                    Sunting
                                  </a>
                                  <button type="submit" id="delete" href="{{ route('user.destroy', $item->id) }}" 
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
      <form action="{{ route('user.store') }}" method="POST" enctype="multipart/form-data">
      @csrf
        <div class="modal-content bg-default">
          <div class="modal-header">
            <h4 class="modal-title">Tambah User</h4>
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
                            <label>Role</label>
                            <select name="roles" class="form-control">
                              <option value="USER">User</option>
                              <option value="ADMIN">Admin</option>
                            </select>                            
                          </div>
                          <!-- /.Nama Kabid/Kasubbag/Kasi -->             
                          <div class="form-group">
                            <label>Nama Bidang</label>
                            <input
                              type="text"
                              name="bidang"
                              class="form-control"
                              placeholder="Nama Bidang"
                              required
                            />
                          </div>
                          <!-- /.Nama Bidang -->             
                          <div class="form-group">
                            <label>Nama Kabid/Kasubbag/Kasi</label>
                            <input
                              type="text"
                              name="name"
                              class="form-control"
                              placeholder="Nama Kabid/Kasubbag/Kasi"
                              required
                            />
                          </div>
                          <!-- /.Nama Kabid/Kasubbag/Kasi -->            
                        </div>
                        <div class="col-md-6">
                          <div class="form-group">
                            <label>NIP</label>
                            <input
                              type="text"
                              name="nip"
                              class="form-control"
                              placeholder="NIP"
                              required
                            />
                          </div>
                          <!-- /.NIP -->             
                          <div class="form-group">
                            <label>Email</label>
                            <input
                              type="email"
                              name="email"
                              class="form-control"
                              placeholder="Email"
                              required
                            />
                          </div>
                          <!-- /.Email -->             
                          <div class="form-group">
                            <label>Password</label>
                            <input
                              type="password"
                              name="password"
                              class="form-control"
                              placeholder="Password"
                              required
                            />
                          </div>
                          <!-- /.Password -->  
                        </div>
                        <div class="col-md-12">
                          <div class="form-group">
                            <label>Icon Bidang</label>
                            <div class="input-group">
                              <div class="custom-file">
                                <input
                                  type="file"
                                  class="custom-file-input"
                                  name="photo"
                                  required
                                />
                                <label
                                  class="custom-file-label"
                                  for="exampleInputFile"
                                  >Pilih Icon Bidang</label
                                >
                              </div>
                            </div>
                          </div>
                          <!-- /.Nama Icon -->
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