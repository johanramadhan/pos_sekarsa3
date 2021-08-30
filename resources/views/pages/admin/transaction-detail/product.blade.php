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
              <table class="table table-striped table-bordered table-supplier table-produk">
                <thead>
                    <th width="5%">No</th>
                    <th>Kode</th>
                    <th>Nama</th>
                    <th>Stok</th>
                    <th>Diskon</th>
                    <th>Harga Jual</th>
                    <th><i class="fa fa-cog"></i></th>
                </thead>
                <tbody>
                  @foreach ($produk as $item)
                    <tr>
                      <td width="5%">{{ $loop->iteration }}</td>
                      <td><span class="badge badge-success">{{ $item->code }}</span></td>
                      <td>{{ $item->name_product }}</td>
                      <td>{{ $item->stok }}</td>
                      <td>{{ $item->diskon }}%</td>
                      <td>{{ format_uang($item->harga_jual) }}</td>
                      <td>
                        <a href="#" class="modal-pilih-produk btn btn-primary btn-xs" onclick="pilihProduk('{{ $item->id_produk }}', '{{ $item->code }}', '{{ $item->name_product }}', '{{ $item->harga_jual }}', '{{ $item->diskon }}')" data-dismiss="modal">
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