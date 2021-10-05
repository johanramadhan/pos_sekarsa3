@extends('layouts.admin')

@section('title')
    Settings
@endsection

@section('content')
  <div class="content-wrapper">
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Setting </h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active">Setting</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div>
    </div>
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-3">

            <!-- Profile Image -->
            <div class="card card-primary card-outline">
              <div class="card-body box-profile">
                <div class="text-center">
                  <img class="profile-user-img img-fluid img-circle"
                       src="{{Storage::url($setting->first()->path_logo ?? 'tidak ada foto')}}"
                       alt="User profile picture">
                </div>

                <h3 class="profile-username text-center">{{ $setting->name }}</h3>

                <p class="text-muted text-center">{{ $setting->address }}</p>

                <ul class="list-group list-group-unbordered mb-3">
                  <li class="list-group-item">
                    <b>Followers</b> <a class="float-right">1,322</a>
                  </li>
                  <li class="list-group-item">
                    <b>Following</b> <a class="float-right">543</a>
                  </li>
                  <li class="list-group-item">
                    <b>Friends</b> <a class="float-right">13,287</a>
                  </li>
                </ul>

                <a href="#" class="btn btn-primary btn-block"><b>Follow</b></a>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->

            <!-- About Me Box -->
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">About Me</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <strong><i class="fas fa-book mr-1"></i> Education</strong>

                <p class="text-muted">
                  B.S. in Computer Science from the University of Tennessee at Knoxville
                </p>

                <hr>

                <strong><i class="fas fa-map-marker-alt mr-1"></i> Location</strong>

                <p class="text-muted">Malibu, California</p>

                <hr>

                <strong><i class="fas fa-pencil-alt mr-1"></i> Skills</strong>

                <p class="text-muted">
                  <span class="tag tag-danger">UI Design</span>
                  <span class="tag tag-success">Coding</span>
                  <span class="tag tag-info">Javascript</span>
                  <span class="tag tag-warning">PHP</span>
                  <span class="tag tag-primary">Node.js</span>
                </p>

                <hr>

                <strong><i class="far fa-file-alt mr-1"></i> Notes</strong>

                <p class="text-muted">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam fermentum enim neque.</p>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
          <div class="col-md-9">
            <div class="card">
              <div class="card-header p-2">
                <ul class="nav nav-pills">
                  <li class="nav-item"><a class="nav-link active" href="#settings" data-toggle="tab">Settings</a></li>
                </ul>
              </div><!-- /.card-header -->
              <div class="card-body">
                <div class="tab-content">

                  <div class="active tab-pane" id="settings">
                    
                    <div class="form-group row">
                      <label class="col-sm-2 col-form-label">Name</label>
                      <div class="col-sm-10">
                        <input type="text" class="form-control" name="name" value="{{ $setting->name }}" id="inputName" placeholder="Name" readonly>
                      </div>
                    </div>
                    <div class="form-group row">
                      <label class="col-sm-2 col-form-label">Email</label>
                      <div class="col-sm-10">
                        <input type="email" class="form-control" id="inputEmail" placeholder="Email" readonly>
                      </div>
                    </div>
                    <div class="form-group row">
                      <label class="col-sm-2 col-form-label">No. Telepon</label>
                      <div class="col-sm-10">
                        <input type="text" class="form-control" name="telepon" value="{{ $setting->telepon }}" placeholder="Name" readonly>
                      </div>
                    </div>
                    <div class="form-group row">
                      <label class="col-sm-2 col-form-label">Diskon</label>
                      <div class="col-sm-10">
                        <input type="text" class="form-control" name="diskon" value="{{ $setting->diskon }}" placeholder="Skills" readonly>
                      </div>
                    </div>
                    <div class="form-group row">
                      <label for="tipe_nota" class="col-lg-2 control-label">Tipe Nota</label>
                      <div class="col-sm-10">
                        <select name="tipe_nota" class="form-control" id="tipe_nota" readonly>
                            @if (($setting->tipe_nota) === 1)
                              <option value="{{ $setting->tipe_nota }}"> -- Tidak diganti (Nota Kecil) --</option> 
                            @else
                              <option value="{{ $setting->tipe_nota }}">-- Tidak diganti (Nota Besar) --</option>
                            @endif
                            <option value="1">Nota Kecil</option>
                            <option value="2">Nota Besar</option>
                        </select>
                        <span class="help-block with-errors"></span>
                      </div>
                    </div>
                    <div class="form-group row">
                      <label class="col-sm-2 col-form-label">Alamat</label>
                      <div class="col-sm-10">
                        <textarea class="form-control" name="address" placeholder="Alamat" readonly>{{ $setting->address }}</textarea>
                      </div>
                    </div>
                    
                    <div class="form-group row">
                      <div class="offset-sm-2 col-sm-10">
                        <a type="submit" class="btn btn-danger" href="{{ route('setting.edit', $setting->id) }}">Edit</a>
                      </div>
                    </div>
                    
                  </div>
                  <!-- /.tab-pane -->
                </div>
                <!-- /.tab-content -->
              </div><!-- /.card-body -->
            </div>
            <!-- /.nav-tabs-custom -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
  </div>
@endsection

@push('addon-script')
    <!-- Sweet alert -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
  @include('includes.admin.alerts')
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