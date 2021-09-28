@extends('layouts.admin')

@section('title')
    Edit Product
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
            <h1 class="m-0">Edit Product</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active">Edit Data Product</li>
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
                <h3 class="card-title">Edit Product</h3>
              </div>
              <!-- /.card-header -->
              <form action="{{ route('products.update', $item->id) }}" method="POST" enctype="multipart/form-data">
                @method('PUT')
                @csrf
                <div class="card-body">
                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <label>Kode Barang</label>
                        <input
                          type="text"
                          name="code"
                          class="form-control"
                          placeholder="Kode Barang"
                          value="{{ $item->code }}" 
                          required
                        />
                      </div>
                      <!-- /.Kode Barang -->             
                      <div class="form-group">
                        <label>Nama Barang</label>
                        <input
                          type="text"
                          name="name"
                          class="form-control"
                          placeholder="Nama Barang"
                          value="{{ $item->name }}" 
                          required
                        />
                      </div>
                      <!-- /.Nama Barang -->             
                      <div class="form-group">
                        <label>Kategori</label>
                        <select name="categories_id" class="form-control select2">
                          <option value="{{ $item->category->id }}" selected>Tidak diganti -- ({{ $item->category->name }})</option>
                          @foreach ($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                          @endforeach
                        </select>                            
                      </div>
                      <!-- /.Kategori --> 
                    </div>
                    <div class="col-md-6">                                   
                      <div class="form-group">
                        <label>Stok</label>
                        <input
                          type="number"
                          name="stok"
                          value="{{ $item->stok }}"
                          class="form-control"
                          placeholder="Jumlah Stok Barang"
                          required
                        />
                      </div>
                      <!-- /.Jumlah -->   
                      <div class="form-group">
                        <label>Harga Modal</label>
                        <input
                          type="number"
                          name="price_modal"
                          class="form-control"
                          value="{{ $item->price_modal }}"
                          placeholder="Harga Modal Produk"
                          required
                        />
                      </div>
                      <!-- /.Harga Satuan --> 
                      <div class="form-group">
                        <label>Harga Jual</label>
                        <input
                          type="number"
                          name="price_jual"
                          class="form-control"
                          value="{{ $item->price_jual }}"
                          placeholder="Harga Jual Produk"
                          required
                        />
                      </div>
                      <!-- /.Harga Satuan -->    
                    </div>
                    <div class="col-md-12">
                      <div class="form-group">
                        <label>Satuan</label>
                        <select name="satuan" class="form-control select2" required>
                          <option value="{{ $item->satuan }}" selected>Tidak diganti -- ({{ $item->satuan}})</option>
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
                        <label>Deskripsi Barang</label>
                        <textarea class="form-control" name="description" rows="3" required>{{ $item->description }}</textarea>
                      </div>
                      <!-- /.deskripsi -->
                    </div>
                  </div>
                </div>

                <div class="card-footer text-right">
                  
                  <button type="submit" class="btn btn-block btn-primary">
                    Edit
                  </button>
                  <a href="{{ route('products.index') }}" class="btn btn-block btn-default">Kembali</a>
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