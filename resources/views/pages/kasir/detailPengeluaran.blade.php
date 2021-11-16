<div class="modal fade" id="modal-pengeluaran" tabindex="-1" role="dialog" aria-labelledby="modal-persediaan">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Detail Pengeluaran</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <table class="table table-striped table-bordered table-detail-pengeluaran">
                <thead>
                  <tr>
                    <th width="5%" class="text-center">No</th>
                    <th class="text-center">Kode</th>
                    <th class="text-center">Keterangan</th>
                    <th class="text-center">Status</th>
                    <th class="text-center">Total Item</th>
                    <th class="text-center">Total Harga</th>
                    <th class="text-center">Diskon</th>
                    <th class="text-center">Bayar</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($pengeluaranDetail as $item)
                    <tr>
                      <td width="5%" class="text-center">{{ $loop->iteration }}</td>
                      <td>{{ $item->code }}</td>
                      <td>{{ $item->keterangan }}</td>
                      <td>{{ $item->status }}</td>
                      <td width="15%" class="text-center">{{ format_uang($item->total_item) }}</td>
                      <td width="15%" class="text-center">Rp{{ format_uang($item->total_harga) }}</td>
                      <td class="text-center">{{ $item->diskon }}%</td>
                      <td width="15%" class="text-center">Rp{{ format_uang($item->bayar) }}</td>
                    </tr> 
                  @endforeach
                </tbody>
              </table>
            </div>
        </div>
    </div>
</div>