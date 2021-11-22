<div class="modal fade" id="modal-menu-total" tabindex="-1" role="dialog" aria-labelledby="modal-persediaan">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Detail Menu Terjual</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <table class="table table-striped table-bordered table-detail-menu-total">
                <thead>
                  <tr>
                    <tr>
                      <th rowspan="2" width="5%" class="text-center">No</th>
                      <th rowspan="2" class="text-center">Kode</th>
                      <th rowspan="2" class="text-center">Nama Menu</th>
                      <th rowspan="2" class="text-center">Jumlah Terjual</th>
                      <th colspan="2" class="text-center">Modal</th>
                      <th colspan="2"  class="text-center">Penjualan</th>
                      <th rowspan="2" class="text-center">Keuntungan</th>
                    </tr>
                    <tr>
                      <th class="text-center">Harga</th>
                      <th class="text-center">Total</th>
                      <th class="text-center">Harga</th>
                      <th class="text-center">Total</th>
                    </tr>
                  </tr>
                </thead>
                <thead>
                  <tr>
                    <th colspan="4" class="text-center">TOTAL</th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($menu_terjual as $item)
                  <tr>
                    <td width="5%" class="text-center">{{ $loop->iteration }}</td>
                    <td>{{ $item->produk->code }}</td>
                    <td>{{ $item->produk->name_product }} - {{ $item->produk->diskon }}%</td>
                    <td width="15%" class="text-center">{{ format_uang($item->total_jumlah) }}</td>
                    <td width="15%" class="text-center">Rp{{ format_uang($item->produk->harga_beli) }}</td>
                    <td width="15%" class="text-center">Rp{{ format_uang($item->total_jumlah * $item->produk->harga_beli) }}</td>
                    <td width="15%" class="text-center">Rp{{ format_uang($item->produk->harga_jual) }}</td>
                    <td width="15%" class="text-center">Rp{{ format_uang(($item->total_jumlah * $item->produk->harga_jual) - (($item->produk->harga_jual * $item->produk->diskon / 100) * $item->total_jumlah)) }}</td>
                    <td width="15%" class="text-center">Rp{{ format_uang((($item->total_jumlah * $item->produk->harga_jual) - (($item->produk->harga_jual * $item->produk->diskon / 100) * $item->total_jumlah)) -  ($item->total_jumlah * $item->produk->harga_beli))}}</td>
                  </tr> 
                  @endforeach
                </tbody>
                
              </table>
            </div>
        </div>
    </div>
</div>