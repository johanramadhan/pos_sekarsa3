<div class="modal fade" id="modal-produk" tabindex="-1" role="dialog" aria-labelledby="modal-produk">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Pilih Persediaan</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <table class="table table-striped table-bordered table-supplier table-produk">
                <thead>
                    <th width="5%" class="text-center">No</th>
                    <th class="text-center">Kode</th>
                    <th class="text-center">Nama</th>
                    <th class="text-center">Stok</th>
                    <th class="text-center">Berat Per Item</th>
                    <th class="text-center">Sisa Berat Persediaan</th>
                    <th class="text-center">Harga Beli</th>
                    <th class="text-center">Harga Per Gram</th>
                    <th class="text-center">Merek</th>
                    <th class="text-center"><i class="fa fa-cog"></i></th>
                </thead>
                <tbody>
                  @foreach ($persediaan as $item)
                    <tr>
                      <td width="5%" class="text-center">{{ $loop->iteration }}</td>
                      <td class="text-center" width="10%"><span class="badge badge-success">{{ $item->code }}</span></td>
                      <td class="text-center">{{ $item->name_persediaan }}</td>
                      <td class="text-center">{{ $item->stok }} {{ $item->satuan }}</td>
                      <td class="text-center">{{ format_uang($item->berat ?? 0) }} {{ $item->satuan_berat }}</td>
                      <td class="text-center">{{ format_uang($item->total_berat ?? 0) }} {{ $item->satuan_berat }}</td>
                      <td class="text-center">Rp{{ format_uang($item->harga_beli) }}</td>
                      <td class="text-center">Rp{{ format_uang($item->harga_persatuan) }}</td>
                      <td class="text-center">{{ $item->merk }}</td>
                      <td class="text-center">
                        <a href="#" class="modal-pilih-produk btn btn-primary btn-xs" onclick="pilihProduk('{{ $item->id_persediaan }}', '{{ $item->code }}', '{{ $item->name_persediaan }}', '{{ $item->harga_persatuan }}')" data-dismiss="modal">
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