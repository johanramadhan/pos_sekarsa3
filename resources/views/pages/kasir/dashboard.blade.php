@extends('layouts.kasir')

@section('title')
    Dashboard Kasir
@endsection

@push('addon-style')
  <link rel="stylesheet" href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')}}">
  <link rel="stylesheet" href="{{ asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css')}}">
  <link rel="stylesheet" href="{{ asset('plugins/datatables-buttons/css/buttons.bootstrap4.min.css')}}">
  <!-- daterange picker -->
  <link rel="stylesheet" href="{{ asset('plugins/daterangepicker/daterangepicker.css') }}">
  <!-- iCheck for checkboxes and radio inputs -->
  <link rel="stylesheet" href="{{ asset('plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
  <!-- Bootstrap Color Picker -->
  <link rel="stylesheet" href="{{ asset('plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.min.css') }}">
  <!-- Tempusdominus Bootstrap 4 -->
  <link rel="stylesheet" href="{{ asset('plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">
  <!-- Select2 -->
  <link rel="stylesheet" href="{{ asset('plugins/select2/css/select2.min.css') }}">
  <link rel="stylesheet" href="{{ asset('plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
  <!-- Bootstrap4 Duallistbox -->
  <link rel="stylesheet" href="{{ asset('plugins/bootstrap4-duallistbox/bootstrap-duallistbox.min.css') }}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ asset('dist/css/adminlte.min.css') }}">
@endpush

@section('content')
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
            <h1 class="m-0">Dashboard - <b>{{ tanggal_indonesia(date('Y-m-d')) }}</b></h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active">Starter Page</li>
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
          <div class="col-12 col-sm-3 col-md-3">
            <!-- small box -->
            <div class="small-box bg-danger">
              <div class="inner">
                <h3>{{ $total_menu_today }}</h3>

                <p>Total Menu Terjual Harini</p>
              </div>
              <div class="icon">
                <i class="ion ion-person"></i>
              </div>
              <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- /.col -->
          <div class="col-12 col-sm-3 col-md-3">
            <!-- small box -->
            <div class="small-box bg-danger">
              <div class="inner">
                <h3>Rp{{ format_uang($kaskecil) }},00</h3>

                <p>Kas Kecil</p>
              </div>
              <div class="icon">
                <i class="ion ion-person"></i>
              </div>
              <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- /.col -->
          <div class="col-12 col-sm-3 col-md-3">
            <!-- small box -->
            <div class="small-box bg-success">
              <div class="inner">
                <h3>Rp{{ format_uang($bayar) }},00</h3>

                <p>Penjualan Hari Ini</p>
              </div>
              <div class="icon">
                <i class="ion ion-person"></i>
              </div>
              <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- /.col -->
          <div class="col-12 col-sm-3 col-md-3">
            <!-- small box -->
            <div class="small-box bg-success">
              <div class="inner">
                <h3>Rp{{ format_uang($pengeluaran) }},00</h3>

                <p>Pengeluaran Hari Ini</p>
              </div>
              <div class="icon">
                <i class="ion ion-person"></i>
              </div>
              <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- /.col -->
          <div class="col-12 col-sm-12 col-md-12 text-center">
            <div class="info-box mb-3">
              <div class="info-box-content">
                <span class="info-box-text">Sisa Kas Kecil</span>
                <h3 class="info-box-number">Rp{{ format_uang($sisakas) }},00</h3>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
        </div>
        
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
  </div>

    
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
  <!-- InputMask -->
  <script src="{{ asset('plugins/moment/moment.min.js') }}"></script>
  <script src="{{ asset('plugins/inputmask/jquery.inputmask.min.js') }}"></script>
  <!-- date-range-picker -->
  <script src="{{ asset('plugins/daterangepicker/daterangepicker.js') }}"></script>
  <!-- Tempusdominus Bootstrap 4 -->
  <script src="{{ asset('plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}"></script>
  <script>
  $(function () {
      //Initialize Select2 Elements
      $('.select2').select2()

      //Initialize Select2 Elements
      $('.select2bs4').select2({
        theme: 'bootstrap4'
      })

      //Datemask dd/mm/yyyy
      $('#datemask').inputmask('dd/mm/yyyy', { 'placeholder': 'dd/mm/yyyy' })
      //Datemask2 mm/dd/yyyy
      $('#datemask2').inputmask('mm/dd/yyyy', { 'placeholder': 'mm/dd/yyyy' })
      //Money Euro
      $('[data-mask]').inputmask()

      //Date picker
      $('#reservationdate').datetimepicker({
          format: 'L'
      });

      //Date and time picker
      $('#reservationdatetime').datetimepicker({ icons: { time: 'far fa-clock' } });

      //Timepicker
      $('#timepicker').datetimepicker({
        format: 'LT'
      })


    })
  </script>
@endpush