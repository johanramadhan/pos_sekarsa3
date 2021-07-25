@extends('layouts.user')

@section('title')
    Edit Gallery Pengajuan
@endsection

@push('addon-style')
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
            <h1 class="m-0">Edit Gallery Pengajuan</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active">Edit Gallery Pengajuan</li>
            </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-12">
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Edit Gallery Pengajuan</h3>
              </div>
              <!-- /.card-header -->
              <form action="{{ route('proposal-gallery.update', $item->id) }}" method="POST" enctype="multipart/form-data">
                @method('PUT')
                @csrf
                <div class="card-body">
                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <div class="form-group">
                          <label>Barang</label>
                          <select name="proposals_id" class="form-control select2">
                            <option>--Pilih Barang--</option>
                            @foreach ($proposals as $item)
                              <option value="{{ $item->id }}">{{ $item->name }}</option>
                            @endforeach
                          </select>                            
                        </div>
                        <!-- /.Barang -->
                    </div>
                    <div class="col-md-6">  
                      
                    </div>
                  </div>
                </div>

                <div class="card-footer text-right">
                  
                  <button type="submit" class="btn btn-block btn-primary">
                    Edit
                  </button>
                  <a href="{{ route('aset.index') }}" class="btn btn-block btn-default">Kembali</a>
                </div>
              </form>
              <div class=" card-body mt-2">
                <div class="row">
                  @foreach ($item->galleries as $gallery)
                    <div class="col-md-12 col-lg-6 col-xl-4">
                      <div class="small-box bg-dark mb-2">
                        <div class="inner">
                          <img
                          src="{{ Storage::url($gallery->photos ?? '') }}"
                          alt=""
                          class="w-100"
                          />
                        </div>
                        <div class="icon">
                          <i class="ion ion-bag"></i>
                        </div>
                        <a
                          href="{{ route('product-gallery-delete', $gallery->id) }}" class="small-box-footer">Delete <i class="fas fa-times"></i></a>
                      </div>
                    </div>
                  @endforeach
                </div>
                <div class="row">
                  <div class="col-md-12">
                    <form action="{{ route('product-gallery-upload') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="products_id" value="{{ $item->id }}">

                        <input
                          type="file"
                          name="photos"
                          id="file"
                          style="display: none;"
                          onchange="form.submit()"
                        />
                        <button
                          type="button"
                          class="btn btn-secondary btn-block mt-3"
                          onclick="thisFileUpload()">
                          Add Photo
                        </button>

                    </form>

                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>
@endsection

@push('addon-script')
  <!-- Sweet alert -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
  @include('includes.admin.alerts')
  <!-- Select2 -->
  <script src="{{ asset('plugins/select2/js/select2.full.min.js') }}"></script>
  <!-- Summernote -->
  <script src="{{ asset('plugins/summernote/summernote-bs4.min.js') }}"></script>
  <script>
      function thisFileUpload() {
          document.getElementById("file").click();
      }
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
@endpush