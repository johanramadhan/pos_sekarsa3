<div class="modal fade" id="modal-kaskecil" tabindex="-1" role="dialog" aria-labelledby="modal-persediaan">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Detail Kas Kecil</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <table class="table table-striped table-bordered table-detail-kaskecil">
                <thead>
                  <tr>
                    <th width="5%" class="text-center">No</th>
                    <th class="text-center">Kode</th>
                    <th class="text-center">Uraian</th>
                    <th class="text-center">Jenis Uang</th>
                    <th class="text-center">Jumlah</th>
                    <th class="text-center">Satuan</th>
                    <th class="text-center">Total</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($kaskecil_detail as $item)
                     <tr>
                      <td width="5%" class="text-center">{{ $loop->iteration }}</td>
                      <td>{{ $item->code }}</td>
                      <td>{{ $item->uraian }}</td>
                      <td width="15%" class="text-center">Rp{{ format_uang($item->jenis_uang) }}</td>
                      <td width="15%" class="text-center">{{ format_uang($item->jumlah) }}</td>
                      <td class="text-center">{{ $item->satuan }}</td>
                      <td width="15%" class="text-center">Rp{{ format_uang($item->subtotal) }}</td>
                    </tr> 
                  @endforeach
                </tbody>
              </table>
            </div>
        </div>
    </div>
</div>