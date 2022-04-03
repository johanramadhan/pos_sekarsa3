@extends('layouts.admin')

@section('title')
    Dashboard Admin
@endsection

@push('addon-style')
  <link rel="stylesheet" href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')}}">
  <link rel="stylesheet" href="{{ asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css')}}">
  <link rel="stylesheet" href="{{ asset('plugins/datatables-buttons/css/buttons.bootstrap4.min.css')}}">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
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

  <style>
    .table-detail-menu tbody tr:last-child{
      font-weight: bold;
    }
    
  </style>
@endpush

@section('content')
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
            <h1 class="m-0">Dashboard</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active">Dashboard</li>
            </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
        <div class="card">
          <div class="card-header">
            <div class="card-tools">
              <button type="button" class="btn btn-tool" data-card-widget="collapse">
                <i class="fas fa-minus"></i>
              </button>
              <button type="button" class="btn btn-tool" data-card-widget="remove">
                <i class="fas fa-times"></i>
              </button>
            </div>
          </div>

          <div class="card-body">
            <div class="row">
              <div class="col-12 col-sm-3 col-md-3">
                <!-- small box -->
                <div class="small-box bg-success">
                  <div class="inner">
                    <h3>{{ $total_menu_today }}</h3>

                    <p>Total Menu Terjual Harini</p>
                  </div>
                  <div class="icon">
                    <i class="ion ion-person"></i>
                  </div>
                  <a onclick="detailMenu()" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>              
                </div>
              </div>
              <!-- /.col -->
              <div class="col-12 col-sm-3 col-md-3">
                <!-- small box -->
                <div class="small-box bg-success">
                  <div class="inner">
                    <h3>Rp{{ format_uang($total_penjualan_today) }}</h3>

                    <p>Total Penjualan Harini</p>
                  </div>
                  <div class="icon">
                    <i class="ion ion-person-add"></i>
                  </div>
                  <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
              </div>
              <!-- /.col -->
              <div class="col-12 col-sm-3 col-md-3">
                <!-- small box -->
                <div class="small-box bg-primary">
                  <div class="inner">
                    <h3>{{ format_uang($total_menu) }}</h3>

                    <p>Total Menu Terjual</p>
                  </div>
                  <div class="icon">
                    <i class="ion ion-bag"></i>
                  </div>
                  <a onclick="detailMenuTotal()" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a> 
                </div>
              </div>
              <!-- /.col -->
              <div class="col-12 col-sm-3 col-md-3">
                <!-- small box -->
                <div class="small-box bg-primary">
                  <div class="inner">
                    <h3>Rp{{format_uang($total_penjualan)}}</h3>

                    <p>Total Penjualan</p>
                  </div>
                  <div class="icon">
                    <i class="ion ion-archive"></i>
                  </div>
                  <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
              </div>
              <!-- /.col -->

              <!-- fix for small devices only -->
              <div class="clearfix hidden-md-up"></div>
                
            </div>
            <!-- /.row -->

            <div class="row">
              <div class="col-12 col-sm-3 col-md-3">
                <!-- small box -->
                <div class="small-box bg-danger">
                  <div class="inner">
                    <h3>Rp{{ format_uang($total_piutang_today) }}</h3>

                    <p>Total Piutang Harini</p>
                  </div>
                  <div class="icon">
                    <i class="ion ion-person"></i>
                  </div>
                  <a onclick="detailPiutang()" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>              
                </div>
              </div>
              <!-- /.col -->
              <div class="col-12 col-sm-3 col-md-3">
                <!-- small box -->
                <div class="small-box bg-danger">
                  <div class="inner">
                    <h3>Rp{{ format_uang($total_pengeluaran_today) }}</h3>

                    <p>Total Pengeluaran Harini</p>
                  </div>
                  <div class="icon">
                    <i class="ion ion-person"></i>
                  </div>
                  <a onclick="detailMenu()" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>              
                </div>
              </div>
              <!-- /.col -->
              <div class="col-12 col-sm-3 col-md-3">
                <!-- small box -->
                <div class="small-box bg-danger">
                  <div class="inner">
                    <h3>Rp{{ format_uang($total_piutang) }}</h3>

                    <p>Total Piutang</p>
                  </div>
                  <div class="icon">
                    <i class="ion ion-bag"></i>
                  </div>
                  <a onclick="detailPiutangTotal()" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a> 
                </div>
              </div>
              <!-- /.col -->
              <div class="col-12 col-sm-3 col-md-3">
                <!-- small box -->
                <div class="small-box bg-danger">
                  <div class="inner">
                    <h3>Rp{{ format_uang($total_pengeluaran) }}</h3>

                    <p>Total Pengeluaran</p>
                  </div>
                  <div class="icon">
                    <i class="ion ion-bag"></i>
                  </div>
                  <a onclick="detailMenuTotal()" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a> 
                </div>
              </div>
              <!-- /.col -->

              <!-- fix for small devices only -->
              <div class="clearfix hidden-md-up"></div>
                
            </div>
            <!-- /.row -->

            <div class="row">
              <div class="col-12 col-sm-6 col-md-6">
                <div class="info-box mb-3">
                  <span class="info-box-icon bg-warning btn-app">
                    <a href="#">
                      <i class="fas fa-shopping-cart"></i>
                    </a>
                  </span>

                  <div class="info-box-content">
                    <span class="info-box-text">Sisa Kas Hari Ini</span>
                    <span class="info-box-number">Rp{{ format_uang($sisa_kas_today) }}</span>
                  </div>
                  <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
              </div>
              <!-- /.col -->
              <div class="col-12 col-sm-6 col-md-6">
                <div class="info-box mb-3">
                  <span class="info-box-icon bg-warning btn-app">
                    <a href="#">
                      <i class="fas fa-shopping-cart"></i>
                    </a>
                  </span>

                  <div class="info-box-content">
                    <span class="info-box-text">Total Sisa Kas</span>
                    <span class="info-box-number">Rp{{ format_uang($sisa_kas) }}</span>
                  </div>
                  <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
              </div>
              <!-- /.col -->
            </div>
            <!-- /.row -->

            <div class="row">
              <div class="col-12">
                <div class="card">
                  <div class="card-header border-0">
                    <div class="d-flex justify-content-between">
                      <h3 class="card-title">Grafik Penjualan {{ tanggal_indonesia($tanggalAwal, false) }} s/d {{ tanggal_indonesia($tanggalAkhir, false) }}</h3>
                      <a href="javascript:void(0);">View Report</a>
                    </div>
                  </div>
                  <div class="card-body">
                    <div class="d-flex">
                      <p class="d-flex flex-column">
                        <span class="text-bold text-lg">Rp{{ format_uang($total_penjualan) }}</span>
                        <span>Total Penjualan</span>
                      </p>
                    </div>
                    <!-- /.d-flex -->
    
                    <div class="position-relative mb-4">
                      <canvas id="sales-chart" height="200"></canvas>
                    </div>
    
                    <div class="d-flex flex-row justify-content-end">
                      <span class="mr-2">
                        <i class="fas fa-square text-primary"></i> This year
                      </span>
    
                      <span>
                        <i class="fas fa-square text-gray"></i> Last year
                      </span>
                    </div>
                  </div>
                </div>
                <!-- /.card -->
              </div>
            </div>
          </div>
        </div>

        {{-- dashbord report --}}
        <div class="row">
          <div class="col-12 col-sm-3 col-md-3">
            <!-- small box -->
            <div class="small-box bg-success">
              <div class="inner">
                <h3>{{ $total_menu_today }}</h3>

                <p>Total Menu Terjual Harini</p>
              </div>
              <div class="icon">
                <i class="ion ion-person"></i>
              </div>              
            </div>
          </div>
          <!-- /.col -->
          <div class="col-12 col-sm-3 col-md-3">
            <!-- small box -->
            <div class="small-box bg-success">
              <div class="inner">
                <h3>Rp{{ format_uang($total_penjualan_today) }}</h3>

                <p>Total Penjualan Harini</p>
              </div>
              <div class="icon">
                <i class="ion ion-person-add"></i>
              </div>
            </div>
          </div>
          <!-- /.col -->
          <div class="col-12 col-sm-3 col-md-3">
            <!-- small box -->
            <div class="small-box bg-primary">
              <div class="inner">
                <h3>{{ format_uang($jumlah_penjualan_report) }}</h3>

                <p>Total Menu Terjual</p>
              </div>
              <div class="icon">
                <i class="ion ion-bag"></i>
              </div>
            </div>
          </div>
          <!-- /.col -->
          <div class="col-12 col-sm-3 col-md-3">
            <!-- small box -->
            <div class="small-box bg-primary">
              <div class="inner">
                <h3>Rp{{format_uang($total_penjualan_report)}}</h3>

                <p>Total Penjualan</p>
              </div>
              <div class="icon">
                <i class="ion ion-archive"></i>
              </div>
            </div>
          </div>
          <!-- /.col -->

          <!-- fix for small devices only -->
          <div class="clearfix hidden-md-up"></div>
            
        </div>
        <!-- /.row -->

        <div class="row">
          <div class="col-12 col-sm-3 col-md-3">
            <div class="info-box mb-3">
              <span class="info-box-icon bg-danger btn-app">
                <a onclick="detailPengeluaran()">
                  <i class="fas fa-shopping-cart"></i>
                </a>
              </span>

              <div class="info-box-content">
                <span class="info-box-text">Pengeluaran Hari Ini</span>
                <span class="info-box-number">Rp{{ format_uang($total_pengeluaran_today) }}</span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
          <div class="col-12 col-sm-3 col-md-3">
            <div class="info-box mb-3">
              <span class="info-box-icon bg-warning btn-app">
                <a href="#">
                  <i class="fas fa-shopping-cart"></i>
                </a>
              </span>

              <div class="info-box-content">
                <span class="info-box-text">Sisa Kas Hari Ini</span>
                <span class="info-box-number">Rp{{ format_uang($sisa_kas_today) }}</span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
          <div class="col-12 col-sm-3 col-md-3">
            <div class="info-box mb-3">
              <span class="info-box-icon bg-danger btn-app">
                <a href="#">
                  <i class="fas fa-shopping-cart"></i>
                </a>
              </span>

              <div class="info-box-content">
                <span class="info-box-text">Total Pengeluaran</span>
                <span class="info-box-number">Rp{{ format_uang($total_pengeluaran_sum) }}</span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
          <div class="col-12 col-sm-3 col-md-3">
            <div class="info-box mb-3">
              <span class="info-box-icon bg-warning btn-app">
                <a href="#">
                  <i class="fas fa-shopping-cart"></i>
                </a>
              </span>

              <div class="info-box-content">
                <span class="info-box-text">Total Sisa Kas</span>
                <span class="info-box-number">Rp{{ format_uang($sisa_kas_repot) }}</span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->

        @includeIf('pages.admin.detailMenu')
        @includeIf('pages.admin.detailMenuTotal')
        @includeIf('pages.admin.detailPengeluaran')
        @includeIf('pages.admin.detailPiutang')
        @includeIf('pages.admin.detailPiutangTotal')

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
  <script src="{{ asset('plugins/chart.js/Chart.min.js') }}"></script>
  <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
  <script src="{{ asset('dist/js/pages/dashboard3.js') }}"></script>
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
    $("#CountDownTimer").TimeCircles({ time: { Days: { show: true }, Hours: { show: true } }});
  </script>
  <script>
    $(function() {
      
    })
  </script>
  <script>
  $(function () {
      $('body').addClass('sidebar-collapse');
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

      //Bootstrap Duallistbox
      $('.duallistbox').bootstrapDualListbox()

    })
  </script>
  <script>
    let table, table1, table2, table3, table4, table5;

    function detailMenu() {
      table = $('.table-detail-menu').DataTable({
        processing: true,
        autoWidth: true,  
        lengthChange: true, 
        bSort: true,
        bPaginate: true,
        ajax: {
            url: '{{ route('dashboard_admin.menuterjual') }}',
        },
        columns: [
            {data: 'DT_RowIndex', searchable: false, sortable: false},
            {data: 'code'},
            {data: 'name_product'},
            {class: 'text-center', data: 'jumlah_terjual'},
            {data: 'modal'},
            {data: 'penjualan'},
            {data: 'keuntungan'},
        ], 
      });

      $('#modal-menu').modal('show');
    }
    function detailMenuTotal() {
      table1 = $('.table-detail-menu-total').DataTable({
        processing: true,
        autoWidth: true,  
      });

      $('#modal-menu-total').modal('show');
    }

    function detailPengeluaran() {
      table2 = $('.table-detail-pengeluaran').DataTable({
        processing: true,
        autoWidth: true,  
        lengthChange: true, 
        bSort: true,
        bPaginate: true 
      });

      table3 = $('.table-detail-pembelian').DataTable({
        processing: true,
        autoWidth: true,  
        lengthChange: true, 
        bSort: true,
        bPaginate: true,
      });

      $('#modal-pengeluaran').modal('show');
    }

    function detailPiutang() {
      table4 = $('.table-detail-piutang').DataTable({
        processing: true,
        autoWidth: true,  
        lengthChange: true, 
        bSort: true,
        bPaginate: true 
      });

      $('#modal-piutang').modal('show');
    }
    function detailPiutangTotal() {
      table4 = $('.table-detail-piutang-total').DataTable({
        processing: true,
        autoWidth: true,  
        lengthChange: true, 
        bSort: true,
        bPaginate: true 
      });

      $('#modal-piutang-total').modal('show');
    }
  </script>
  <script>
    $(function () {
      $("#example1").DataTable({
        "responsive": true, "lengthChange": false, "autoWidth": true,
        "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
      }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
      $('#example2').DataTable({
        "paging": true,
        "lengthChange": true,
        "searching": true,
        "ordering": true,
        "info": true,
        "autoWidth": true,
        "responsive": true,
      });
    });
  </script>
@endpush