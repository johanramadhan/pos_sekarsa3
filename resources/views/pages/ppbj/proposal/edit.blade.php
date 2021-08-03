@extends('layouts.ppbj')

@section('title')
    Edit Pengajuan
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
            <h1 class="m-0">Edit Pengajuan</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active">Edit Data Pengajuan</li>
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
                <h3 class="card-title">Edit Pengajuan</h3>
              </div>
              <!-- /.card-header -->
              <form action="{{ route('proposal.update', $item->id) }}" method="POST" enctype="multipart/form-data">
                @method('PUT')
                @csrf
                <div class="card-body">
                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <label>Nama Bidang</label>
                        <input
                          type="text"
                          class="form-control"
                          placeholder="Nama Barang"
                          value="{{ $item->user->bidang }}" 
                          readonly
                        />                            
                      </div>
                      <!-- /.Nama Bidang -->             
                      <div class="form-group">
                        <label>Kategori</label>
                        <input
                          type="text"
                          class="form-control"
                          placeholder="Nama Barang"
                          value="{{ $item->category->name }}" 
                          readonly
                        />                            
                      </div>
                      <!-- /.Kategori --> 
                      <div class="form-group">
                        <label>Nama Barang</label>
                        <input
                          type="text"
                          class="form-control"
                          placeholder="Nama Barang"
                          value="{{ $item->name }}" 
                          readonly
                        />
                      </div>
                      <!-- /.Nama Barang -->   
                      <div class="form-group">
                        <label>Merek/Type Barang</label>
                        <input
                          type="text"
                          class="form-control"
                          placeholder="Merek/Type Barang"
                          value="{{ $item->brand }}" 
                          readonly
                        />
                      </div>
                      <!-- /.brand -->         
                      <div class="form-group">
                        <label>Jumlah Kebutuhan Maksimum</label>
                        <input
                          type="text"
                          class="form-control"
                          placeholder="Jumlah Maksimum Kebutuhan Barang"
                          value="{{ $item->max_requirement }}" 
                          readonly
                        />
                      </div>
                      <!-- /.Jumlah Maksimum Kebutuhan Barang --> 
                      <div class="form-group">
                        <label>Justifikasi Kebutuhan Maksimum</label>
                        <textarea class="form-control" rows="3" placeholder="Justifikasi Kebutuhan Maksimum" readonly>{{ $item->justifikasi }}</textarea>
                      </div>
                      <!-- /.Justifikasi Kebutuhan Maksimum -->        
                      <div class="form-group">
                        <label>Status Pengajuan</label>
                        <select name="proposal_status" class="form-control">
                          <option value="{{ $item->proposal_status }}" selected>Tidak diganti -- ({{ $item->proposal_status}})</option>
                          <option value="Pending">Pending</option>
                          <option value="Standar Harga">Standar Harga</option>
                          <option value="RKBMD">RKBMD</option>
                          <option value="RKA">RKA</option>
                        </select>                            
                      </div>
                      <!-- /.Status -->
                      <div class="form-group">
                        <label>Catatan Pengajuan</label>
                        <textarea class="form-control" name="note" rows="1" placeholder="Catatan Pengajuan" required>{{ $item->note }}</textarea>
                      </div>
                      <!-- /.Catatan Pengajuan -->
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label>Satuan</label>
                        <input
                          type="text"
                          class="form-control"
                          value="{{ $item->satuan }}" 
                          readonly
                        />                           
                      </div>
                      <!-- /.satuan -->              
                      <div class="form-group">
                        <label>Jumlah</label>
                        <input
                          type="number"
                          id="qty" 
                          onkeyup="sum()"
                          value="{{ $item->qty }}"
                          class="form-control"
                          placeholder="Jumlah Barang"
                          readonly
                        />
                      </div>
                      <!-- /.Jumlah -->   
                      <div class="form-group">
                        <label>Harga Satuan</label> (<i><small>Harga Rill</small></i>)
                        <input
                          type="number"
                          id="price" 
                          onkeyup="sum()"
                          class="form-control"
                          value="{{ $item->price }}"
                          placeholder="Harga Satuan"
                          readonly
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
                          value="{{ $item->total_price }}"
                          placeholder="Total Harga"
                          readonly
                        />
                      </div>
                      <!-- /.Total Harga -->
                      <div class="form-group">
                        <label>Fungsi Barang</label>
                        <textarea class="form-control" rows="3" placeholder="Fungsi/kegunaan barang" readonly>{{ $item->benefit }}</textarea>
                      </div>
                      <!-- /.Fungsi -->
                      <div class="form-group">
                        <label>Link Video</label> (<i><small>Kosongkan jika tidak ada link</small></i>)
                        <input
                          type="text"
                          class="form-control"
                          value="{{ $item->link }}"
                          placeholder="Link Video Barang"
                          readonly
                        />
                      </div>
                      <!-- /.link --> 
                      <div class="form-group">
                        <label>Harga Satuan di RKA</label>
                        <input
                          type="number"
                          name="price_dpa"
                          class="form-control"
                           value="{{ $item->price_dpa }}"
                          placeholder="Harga Satuan di RKA"
                        />
                      </div>
                      <!-- /.Harga di RKA --> 
                      <div class="form-group">
                        <label>Jumlah Realisasi</label>
                        <input
                          type="number"
                          name="realisasi" 
                          class="form-control"
                          value="{{ $item->realisasi }}"
                          placeholder="Jumlah Realisasi Barang Yang Diajukan"
                        />
                      </div>
                      <!-- /.Jumlah Realisasi -->
                    </div>
                    <div class="col-md-12">
                      <div class="form-group">
                        <label>Deskripsi Barang</label>
                        <textarea class="form-control" name="description" rows="3" readonly>
                          {!! $item->description !!}
                        </textarea>
                      </div>
                      <!-- /.deskripsi -->
                    </div>
                  </div>
                </div>

                <div class="card-footer text-right">
                  
                  <button type="submit" class="btn btn-block btn-primary">
                    Edit
                  </button>
                  <a href="{{ route('proposal.index') }}" class="btn btn-block btn-default">Kembali</a>
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
                      </div>
                    </div>
                  @endforeach
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