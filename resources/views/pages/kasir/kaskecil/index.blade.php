@extends('layouts.kasir')

@section('title')
    Kas Kecil
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
            <h1 class="m-0">Kas Kecil</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active">Kas Kecil</li>
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
                  <table class="table table-kaskecil table-bordered table-striped">
                    <thead>
                      <tr>
                        <th>No</th>
                        <th class="text-center">Code</th>
                        <th class="text-center">Tanggal</th>
                        <th class="text-center">Uraian</th>
                        <th class="text-center">Debet</th>
                        <th class="text-center">Kredit</th>
                        <th class="text-center">Keterangan</th>
                        <th class="text-center">Aksi</th>
                      </tr>
                    </thead>
                    <tbody>
                      @forelse ($kaskecils as $item)
                      <tr>
                        <td class="text-center">{{ $loop->iteration }}</td>
                        <td class="text-center">{{ $item->code }}</td>
                        <td class="text-center">{{ tanggal_indonesia($item->created_at) }}</td>
                        <td class="text-center">{{ $item->uraian }}</td>
                        <td class="text-center">Rp{{ format_uang($item->debit) }}</td>
                        <td class="text-center">Rp{{ format_uang($item->kredit) }}</td>
                        <td class="text-center">{{ $item->keterangan }}</td>
                        <td class="text-center">
                          <div class="btn-group">
                            <button onclick="editForm( '{{ route('kaskecilkasir.update', $item->id_kaskecil) }}')" class="btn btn-xs btn-warning btn-flat m-1"><i class="fa fa-edit"></i></button>
                            <button onclick="print('{{ route('kaskecil.print', $item->id_kaskecil) }}')" class="btn btn-xs btn-default btn-flat m-1"><i class="fa fa-print"></i></button>
                            <button onclick="showDetail( '{{ route('kaskecil.detail', $item->id_kaskecil) }}')" class="btn btn-xs btn-info btn-flat m-1"><i class="fa fa-eye"></i></button>
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

  @includeIf('pages.kasir.kaskecil.tambah')
  @includeIf('pages.kasir.kaskecil.detail')
  @includeIf('pages.kasir.kaskecil.form')

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
      table = $('.table-kaskecil').DataTable({
        processing: true,
        autoWidth: false,
    });
      $('.table-supplier').DataTable();
      table1 = $('.table-detail').DataTable({
          processing: true,
          bSort: false,
          columns: [
              {class: 'text-center', data: 'DT_RowIndex', searchable: false, sortable: false},
              {class: 'text-center', data: 'tanggal'},
              {class: 'text-center', data: 'uraian'},
              {class: 'text-center', data: 'jenis_uang'},
              {class: 'text-center', data: 'jumlah'},
              {class: 'text-center', data: 'satuan'},
              {class: 'text-center', data: 'subtotal'},
          ]
      })

    });

    function addForm() {
        $('#modal-kaskecil').modal('show');
    }

    function showDetail(url) {
        $('#modal-detail').modal('show');

        table1.ajax.url(url);
        table1.ajax.reload();
    }

    function editForm(url) {
      $('#modal-form').modal('show');
      $('#modal-form .modal-title').text('Edit Kas Kecil');

      $('#modal-form form')[0].reset();
      $('#modal-form form').attr('action', url);
      $('#modal-form [name=_method]').val('put');
      $('#modal-form [name=uraian]').focus();

      $.get(url)
        .done((response) => {
            $('#modal-form [name=code]').val(response.code);
            $('#modal-form [name=uraian]').val(response.uraian);
            $('#modal-form [name=debit]').val(response.debit);
            $('#modal-form [name=kredit]').val(response.kredit);
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
        cancelButtonText: 'No, cancel!',
        reverseButtons: true
      }).then((result) => {
        if (result.isConfirmed) {
          document.getElementById('deleteForm').action = href;
          document.getElementById('deleteForm').submit();
          
          swalWithBootstrapButtons.fire(
            'Terhapus!',
            'Data Kas Kecil berhasil dihapus.',
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