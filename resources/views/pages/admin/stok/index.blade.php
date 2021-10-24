@extends('layouts.admin')

@section('title')
    Tambah Stok Produk
@endsection

@push('addon-style')
  <link rel="stylesheet" href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')}}">
  <link rel="stylesheet" href="{{ asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css')}}">
  <link rel="stylesheet" href="{{ asset('plugins/datatables-buttons/css/buttons.bootstrap4.min.css')}}">
  <!-- Select2 -->
  <link rel="stylesheet" href="{{ asset('plugins/select2/css/select2.min.css') }}">
  <link rel="stylesheet" href="{{ asset('plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
@endpush

@section('content')
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
            <h1 class="m-0">Tambah Stok Produk</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active">Tambah Stok Produk</li>
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
            <div class="card">
              <div class="card-body">
                <div class="table-responsive">
                  <table class="table table-pembelian table-bordered table-striped">
                    <button onclick="addForm()" class="btn btn-primary mb-2">
                      + Stok Produk
                    </button>
                    @empty(! session('id_stok'))
                    <a href="{{ route('tambahStok_detail.index') }}" class="btn btn-danger mb-2 ml-2"> Transaksi Aktif</a>
                    @endempty
                    <thead>
                      <tr>
                        <th>No</th>
                        <th class="text-center">Code</th>
                        <th class="text-center">Tanggal Penambahan</th>
                        <th class="text-center">Nama Produk</th>
                        <th class="text-center">Total Penambahan</th>
                        <th class="text-center">Total Modal</th>
                        <th class="text-center">Status</th>
                        <th class="text-center">Aksi</th>
                      </tr>
                    </thead>
                    <tbody>
                      @forelse ($stok as $item)
                      <tr>
                        <td class="text-center">{{ $loop->iteration }}</td>
                        <td class="text-center">{{ $item->code }}</td>
                        <td class="text-center">{{ tanggal_indonesia($item->created_at) }}</td>
                        <td>{{ $item->produk->name_product }}</td>
                        <td class="text-center">{{ format_uang($item->total_item) }}</td>
                        <td class="text-center">Rp{{ format_uang($item->total_harga) }}</td>
                        <td class="text-center">
                          @if (($item->status ) === "Success")
                            <span class="badge badge-success">Success</span>
                          @else
                            <span class="badge badge-danger">Pending</span>
                          @endif                                
                        </td>
                        <td class="text-center">
                          <div class="btn-group">
                            @if (($item->status) === "Pending")
                            @else
                              <button onclick="print('{{ route('tambahStok.print', $item->id_produk) }}')" class="btn btn-xs btn-default btn-flat m-1"><i class="fa fa-print"></i></button>
                            @endif
                            <button onclick="showDetail( '{{ route('tambahStok.show', $item->id_produk) }}')" class="btn btn-xs btn-info btn-flat m-1"><i class="fa fa-eye"></i></button>
                            <button type="submit" id="delete" href="{{ route('tambahStok.destroy', $item->id_produk) }}" 
                              class="btn btn-xs btn-danger btn-flat m-1"><i class="fa fa-trash"></i></button>
                            <form action="" method="POST" id="deleteForm">
                              @csrf
                              @method("DELETE")
                              <input type="submit" value="Hapus" style="display: none">
                              
                            </form>
                          </div>
                        </td>
                      </tr>                          
                      @empty
                          
                      @endforelse
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
  </div>

  @includeIf('pages.admin.stok.produk')
  @includeIf('pages.admin.pembelian.detail')

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
  
  <script>
    let table, table1;

    $(function () {
      table = $('.table-pembelian').DataTable({
        processing: true,
        autoWidth: false,
    });
      $('.table-produk').DataTable();
      table1 = $('.table-detail').DataTable({
          processing: true,
          bSort: false,
          columns: [
              {class: 'text-center', data: 'DT_RowIndex', searchable: false, sortable: false},
              {class: 'text-center', data: 'code'},
              {class: 'text-center', data: 'tanggal'},
              {class: 'text-center', data: 'name'},
              {class: 'text-center', data: 'harga_beli'},
              {class: 'text-center', data: 'jumlah'},
              {class: 'text-center', data: 'berat'},
              {class: 'text-center', data: 'berat_total'},
              {class: 'text-center', data: 'subtotal'},
          ]
      })

    });

    function addForm() {
        $('#modal-produk').modal('show');
    }

    function showDetail(url) {
        $('#modal-detail').modal('show');

        table1.ajax.url(url);
        table1.ajax.reload();
    }

    function print(url, title) {
        popupCenter(url, title, 625, 500);
    }

    function popupCenter(url, title, w, h) {
        const dualScreenLeft = window.screenLeft !==  undefined ? window.screenLeft : window.screenX;
        const dualScreenTop  = window.screenTop  !==  undefined ? window.screenTop  : window.screenY;

        const width  = window.innerWidth ? window.innerWidth : document.documentElement.clientWidth ? document.documentElement.clientWidth : screen.width;
        const height = window.innerHeight ? window.innerHeight : document.documentElement.clientHeight ? document.documentElement.clientHeight : screen.height;

        const systemZoom = width / window.screen.availWidth;
        const left       = (width - w) / 2 / systemZoom + dualScreenLeft
        const top        = (height - h) / 2 / systemZoom + dualScreenTop
        const newWindow  = window.open(url, title, 
        `
            scrollbars=yes,
            width  = ${w / systemZoom}, 
            height = ${h / systemZoom}, 
            top    = ${top}, 
            left   = ${left}
        `
        );

        if (window.focus) newWindow.focus();
    }

    function deleteData(url) {
      if (confirm('Yakin ingin menghapus data terpilih?')) {
        $.post(url, {
            '_token': $('[name=csrf-token]').attr('content'),
            '_method': 'delete'
        })
        .done((response) => {
            table.ajax.reload();
        })
        .fail((errors) => {
            alert('Tidak dapat menghapus data');
            return;
        });
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
            'Data produk berhasil dihapus.',
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