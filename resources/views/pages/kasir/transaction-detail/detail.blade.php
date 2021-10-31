@extends('layouts.admin')

@section('title')
    Detail Produk
@endsection

@push('addon-style')
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ asset('dist/css/adminlte.min.css') }}">
  <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet" />
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
            <h1 class="m-0">Detail Pengajuan {{ $item->name }}</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active">Detail Produk {{ $item->name }}</li>
            </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <section class="content" id="gallery">
      <div class="container-fluid">
        <div class="card card-solid">
          <div class="card-body">
            <div class="row">
              <div class="col-12 col-sm-6">
                <h3 class="d-inline-block d-sm-none">LOWA Men’s Renegade GTX Mid Hiking Boots Review</h3>
                <div class="col-12" data-aos="zoom-in">
                  <transition name="slide-fade" made="out-in">
                    <img
                      :src="photos[activePhoto].url"
                      :key="photos[activePhoto].id"
                      class="product-image mw-100"
                      height="475px"
                      alt="{{ $item->name }}"
                    />
                  </transition>
                </div>
                <div class="col-12 product-image-thumbs">
                  <div class="product-image-thumb active"
                      v-for="(photo, index) in photos"
                      :key="photo.id"
                      data-aos="zoom-in"
                      data-aos-delay="100">
                    <a href="#" @click="changeActive(index)">
                      <img
                        :src="photo.url"
                        class="w-100 thumbnail-image"
                        height="105px"
                        :class="{active: index == activePhoto}"
                        alt=""
                      />
                    </a>
                  </div>
                </div>
              </div>
              <div class="col-12 col-sm-6">
                <h3 class="my-2">{{ $item->name }} - ({{ $item->code }})</h3> 
                 {{ $item->category->name }} | {{ $item->created_at }}
                   <br> <br>
                <h5>Deskripsi Produk</h5>
                <p>Stok : {{$item->stok }} {{ $item->satuan }}</p>
                <p>Harga Modal : Rp{{ number_format($item->price_modal) }}</p>
                <p>Harga Jual : Rp{{ number_format($item->price_jual) }}</p>
                <p>{{ $item->description }} </p>
                <hr>

                <div class="mt-4">
                  <button type="button" class="btn btn-danger btn-lg btn-flat" data-toggle="modal" data-target="#modal-primary">
                    <i class="fas fa-play fa-md mr-2"></i>
                    Play Video
                  </button>
                </div>
              </div>
            </div>
            {{-- <div class="row mt-5">
              <div class="col-12 col-sm-12">
                <div class="card card-primary card-outline card-tabs">
                  <div class="card-header p-0 pt-1 border-bottom-0">
                    <ul class="nav nav-tabs" id="custom-tabs-three-tab" role="tablist">
                      <li class="nav-item">
                        <a class="nav-link active" id="custom-tabs-three-home-tab" data-toggle="pill" href="#custom-tabs-three-home" role="tab" aria-controls="custom-tabs-three-home" aria-selected="true">Deskripsi/Spesifikasi</a>
                      </li>
                    </ul>
                  </div>
                  <div class="card-body">
                    <div class="tab-content" id="custom-tabs-three-tabContent">
                      <div class="tab-pane fade show active" id="custom-tabs-three-home" role="tabpanel" aria-labelledby="custom-tabs-three-home-tab">
                        {{ $item->description}}
                      </div>
                    </div>
                  </div>
                  <!-- /.card -->
                </div>
              </div>
            </div> --}}
          </div>
        </div>
      </div>
    </section>
  </div>
  <br><br><br><br><br><br><br><br><br><br><br><br>
@endsection

<div class="modal fade" id="modal-primary">
  <div class="modal-dialog modal-xl">
    <div class="modal-content bg-default">
      <div class="modal-header">
        <h4 class="modal-title">Video {{ $item->name }}</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="embed-responsive embed-responsive-21by9">
          <iframe class="embed-responsive-item" src="https://www.youtube.com/embed/{{$item->link}}" allowfullscreen></iframe>
        </div>
      </div>
      <div class="modal-footer justify-content-between">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

@push('addon-script')
  <!-- AdminLTE App -->
  <script src="{{ asset('dist/js/adminlte.min.js') }}"></script>
  <!-- AdminLTE for demo purposes -->
  <script src="{{ asset('dist/js/demo.js') }}"></script>
  <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
  <!-- Summernote -->
  <script src="{{ asset('plugins/summernote/summernote-bs4.min.js') }}"></script>
  <script>
    AOS.init();
  </script>
  <script src="{{ asset('vue/vue.js') }}"></script>
  <script>
    var gallery = new Vue({
      el: "#gallery",
      mounted() {
        AOS.init();
      },
      data: {
        activePhoto: 0,
        photos: [
          @foreach($item->galleries as $gallery)
            {
              id: {{ $gallery->id }},
              url: "{{ Storage::url($gallery->photos) }}",
            },
          @endforeach
        ],
      },
      methods: {
        changeActive(id) {
          this.activePhoto = id;
        },
      },
    });
  </script>
  <script>
    $(document).ready(function() {
      $('.product-image-thumb').on('click', function () {
        var $image_element = $(this).find('img')
        $('.product-image').prop('src', $image_element.attr('src'))
        $('.product-image-thumb.active').removeClass('active')
        $(this).addClass('active')
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