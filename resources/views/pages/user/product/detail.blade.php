@extends('layouts.user')

@section('title')
    Detail Aset
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
            <h1 class="m-0">Detail {{ $item->name }}</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active">Detail Data {{ $item->name }}</li>
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
                <h3 class="my-2">{{ $item->name }}</h3> 
                <small>Fungsi : {{ $item->fungsi }} | Bidang {{ $item->user->bidang }} | {{ $item->status }} | {{ $item->kondisi }}</small> <br>
                <p>{!! $item->description !!}</p>
                <hr>

                <small>Merek : {{ $item->brand }}</small> <br>
                <small>Kategori : {{ $item->category->name }}</small> <br>
                <small>Jumlah : {{ $item->qty }} {{ $item->satuan }}</small> <br>
                <small>Harga Satuan : Rp{{ number_format($item->price) }}</small> <br>
                <small>Total Harga : Rp{{ number_format($item->total_price) }}</small> <br>
                
                <div class="mt-4">
                  <button type="button" class="btn btn-danger btn-lg btn-flat" data-toggle="modal" data-target="#modal-primary">
                    <i class="fas fa-play fa-md mr-2"></i>
                    Play Video
                  </button>
                </div>
              </div>
            </div>
            <div class="row mt-4">
              <nav class="w-100">
                <div class="nav nav-tabs" id="product-tab" role="tablist">
                  <a class="nav-item nav-link active" id="product-desc-tab" data-toggle="tab" href="#product-desc" role="tab" aria-controls="product-desc" aria-selected="true">Description</a>
                </div>
              </nav>
              <div class="tab-content p-3" id="nav-tabContent">
                <div class="tab-pane fade show active" id="product-desc" role="tabpanel" aria-labelledby="product-desc-tab">
                  <textarea id="summernote" name="description" rows="3" readonly required>
                    {{$item->description}}
                  </textarea>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>
  <br><br><br><br><br>
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