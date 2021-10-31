<div class="modal fade" id="modal-produk" tabindex="-1" role="dialog" aria-labelledby="modal-produk">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Pilih Produk</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <table class="table table-striped table-bordered table-produk">
                <thead>
                    <th width="5%" class="text-center">No</th>
                    <th class="text-center">Code</th>
                    <th class="text-center">Menu</th>
                    <th class="text-center">Satuan</th>
                    <th class="text-center">Sisa Stok</th>
                    <th class="text-center">Status</th>
                    <th class="text-center">Description</th>
                    <th><i class="fa fa-cog"></i></th>
                </thead>
                <tbody>
                  @foreach ($produks as $item)
                    <tr>
                      <td width="5%" class="text-center">{{ $loop->iteration }}</td>
                      <td>{{ $item->code }}</td>
                      <td>{{ $item->name_product }}</td>
                      <td class="text-center">{{ $item->satuan }}</td>
                      <td>{{ $item->stok }}</td>
                      <td>
                        @if (($item->stok) === 0)
                          <span class="badge badge-danger">Habis</span>
                        @elseif(($item->stok) > 5)
                          <span class="badge badge-success">Aman</span>
                        @else
                          <span class="badge badge-warning">Hampir Habis</span>
                        @endif
                      </td>
                      <td>{{ $item->description }}</td>
                      <td>
                        <a href="{{ route('tambah-stokProduk', $item->id_produk) }}" class="btn btn-primary btn-xs">
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