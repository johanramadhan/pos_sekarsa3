@extends('layouts.admin')

@section('title')
    Transaksi Penjualan
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
            <h1 class="m-0">Transaksi Penjualan <b>{{ format_uang($jumlah_penjualan_report) }} Menu -> Rp{{ format_uang($total_penjualan_report) }}</b></h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active">Transaksi Penjualan</li>
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
                  <table class="table table-penjualan table-bordered table-striped">
                    <a href="{{ route('transactions.create') }}" class="btn btn-primary mb-2">
                      + Transaksi Penjualan
                    </a>
                    @empty(! session('id_transaction'))
                    <a href="{{ route('transaction-details.index') }}" class="btn btn-danger mb-2 ml-2"> Transaksi Aktif</a>
                    @endempty
                    <thead>
                      <tr class="text-center">
                        <th>No</th>
                        <th>Code</th>
                        <th>Pukul</th>
                        <th>Tanggal</th>
                        <th>Kasir</th>
                        <th>Member</th>
                        <th>Customer</th>
                        <th>Total Item</th>
                        <th>Total Harga</th>
                        <th>Diskon</th>
                        <th>Bayar</th>
                        <th>Diterima</th>
                        <th>Status</th>
                        <th>Keterangan</th>
                        <th>Aksi</th>
                      </tr>
                    </thead>
                    <tbody>
                      @forelse ($transactions as $item)
                        <tr>
                          <td class="text-center">{{ $loop->iteration }}</td>
                          <td class="text-center">{{ $item->code }}</td>
                          <td>{{ $item->created_at->format('H:i') }} WIB</td>
                          <td>{{ tanggal_indonesia ($item->created_at) }}</td>
                          <td class="text-center">{{ $item->user->name }}</td>
                          <td>{{ $item->member->name ?? '' }}</td>
                          <td>{{ $item->customer_name ?? '' }}</td>
                          <td class="text-center">{{ format_uang ($item->total_item) }}</td>
                          <td>Rp{{ format_uang ($item->total_harga) }}</td>
                          <td class="text-center">{{ $item->diskon }}%</td>
                          <td>Rp{{ format_uang ($item->bayar) }}</td>
                          <td>Rp{{ format_uang ($item->diterima) }}</td>
                          <td class="text-center">
                            @if (($item->transaction_status ) === "success")
                              <span class="badge badge-success">Success</span>
                            @elseif (($item->transaction_status ) === "sukses")
                              <span class="badge badge-success">Sukses</span>
                            @elseif (($item->transaction_status ) === "piutang")
                              <span class="badge badge-primary">Piutang</span>
                            @else
                              <span class="badge badge-danger">Pending</span>
                            @endif                                
                          </td>
                          <td>{{ $item->keterangan ?? '' }}</td>
                          <td class="text-center">
                            <div class="btn-group">
                              <button onclick="editForm( '{{ route('transactions.update', $item->id_transaction) }}')" class="btn btn-xs btn-warning btn-flat m-1"><i class="fa fa-edit"></i></button>
                              @if (($item->transaction_status) === "pending")
                              @else
                                <button onclick="print('{{ route('transactions.print', $item->id_transaction) }}')" class="btn btn-xs btn-default btn-flat m-1"><i class="fa fa-print"></i></button>
                              @endif
                              <button onclick="showDetail( '{{ route('transactions.detail', $item->id_transaction) }}')" class="btn btn-xs btn-info btn-flat m-1"><i class="fa fa-eye"></i></button>
                              <button type="submit" id="delete" href="{{ route('transactions.destroy', $item->id_transaction) }}" 
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
                          Tidak ada data
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

  @includeIf('pages.admin.transaction.product')
  @includeIf('pages.admin.transaction.detail')
  @includeIf('pages.admin.transaction.form')


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
      $('body').addClass('sidebar-collapse');
      
      table = $('.table-penjualan').DataTable({
        processing: true,
        autoWidth: false,  
      });

      table1 = $('.table-detail-penjualan').DataTable({
        processing: true,
          columns: [
            {data: 'DT_RowIndex', searchable: false, sortable: false},
            {data: 'code'},
            {data: 'tanggal'},
            {data: 'nama_produk'},
            {data: 'harga_jual'},
            {data: 'jumlah'},
            {data: 'diskon'},
            {data: 'subtotal'},
        ]
      });
    });

    function showDetail(url) {
        $('#modal-detail').modal('show');

        table1.ajax.url(url);
        table1.ajax.reload();
    }

    function editForm(url) {
      $('#modal-form').modal('show');
      $('#modal-form .modal-title').text('Edit Transaction');

      $('#modal-form form')[0].reset();
      $('#modal-form form').attr('action', url);
      $('#modal-form [name=_method]').val('put');
      $('#modal-form [name=keterangan]').focus();

      $.get(url)
        .done((response) => {
            $('#modal-form [name=bayar]').val(response.bayar);
            $('#modal-form [name=transaction_status]').val(response.transaction_status);
            $('#modal-form [name=keterangan]').val(response.keterangan);
        })
        .fail((errors) => {
            alert('Tidak dapat menampilkan data');
            return;
        });
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
        cancelButtonText: 'Jangaaann!!!',
        reverseButtons: true
      }).then((result) => {
        if (result.isConfirmed) {
          document.getElementById('deleteForm').action = href;
          document.getElementById('deleteForm').submit();
          
          swalWithBootstrapButtons.fire(
            'Terhapus!',
            'Data penjualan berhasil dihapus.',
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