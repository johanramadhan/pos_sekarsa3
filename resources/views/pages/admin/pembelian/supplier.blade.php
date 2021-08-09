<div class="modal fade" id="modal-supplier" tabindex="-1" role="dialog" aria-labelledby="modal-supplier">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Pilih Supplier</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
                <table class="table table-striped table-bordered table-supplier">
                    <thead>
                        <th width="5%">No</th>
                        <th>Nama</th>
                        <th>Telepon</th>
                        <th>Alamat</th>
                        <th>Keterangan</th>
                        <th><i class="fa fa-cog"></i></th>
                    </thead>
                    <tbody>
                        @foreach ($suppliers as $item)
                          <tr>
                            <td width="5%">{{ $loop->iteration }}</td>
                            <td>{{ $item->name }}</td>
                            <td>{{ $item->phone }}</td>
                            <td>{{ $item->address }}</td>
                            <td>{{ $item->description }}</td>
                            <td width="10%">
                                <a href="{{ route('tambah-pembelian', $item->id) }}" class="btn btn-primary">
                                    <i class="fa fa-check-circle"></i>
                                    Pilih
                                </a>
                            </td>
                          </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>