<div class="modal fade" id="modal-piutang-total" tabindex="-1" role="dialog" aria-labelledby="modal-piutang-total">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Detail Piutang - <b>{{ tanggal_indonesia(date('Y-m-d')) }}</b></h4>

              {{-- <ul class="nav nav-pills ml-auto">
                <li class="nav-item"><a class="nav-link active" href="#tab_1" data-toggle="tab">Piutang</a></li>
              </ul> --}}

              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
              
            </div>
            <div class="modal-body">              
              <div class="tab-content">
                <div class="tab-pane active" id="tab_1">
                  <table class="table table-striped table-bordered table-detail-piutang-total">
                    <thead>
                      <tr>
                        <th width="5%" class="text-center">No</th>
                        <th class="text-center">Kode</th>
                        <th class="text-center">Waktu</th>
                        <th class="text-center">Kasir</th>
                        <th class="text-center">Customer</th>
                        <th class="text-center">Total Item</th>
                        <th class="text-center">Total Piutang</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach ($list_total_piutang as $item)
                        <tr>
                          <td class="text-center">{{ $loop->iteration }}</td>
                          <td>{{ $item->code }}</td>
                          <td class="text-center">{{ $item->created_at->format('H:i') }} WIB</td>
                          <td class="text-center">{{ $item->user->name }}</td>
                          <td class="text-center">{{ $item->customer_name ?? '' }}</td>
                          <td class="text-center">{{ format_uang ($item->total_item) }}</td>
                          <td>Rp{{ format_uang ($item->bayar) }}</td>
                        </tr>
                      @endforeach
                    </tbody>
                    <tfoot>
                      <tr>
                        <th class="text-center" colspan="6">Total</th>
                        <th>Rp{{ format_uang($total_piutang ) }}</th>
                      </tr>
                    </tfoot>
                  </table>
                </div>
                {{-- <div class="tab-pane" id="tab_2">
                  <table class="table table-striped table-bordered table-detail-pembelian">
                    <thead>
                      <tr>
                        <th width="5%" class="text-center">No</th>
                        <th class="text-center">Kode</th>
                        <th class="text-center">Nama Persediaan</th>
                        <th class="text-center">Jumlah</th>
                        <th class="text-center">Satuan</th>
                        <th class="text-center">Harga Beli</th>
                        <th class="text-center">Subtotal</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach ($pembelianDetail as $item)
                        <tr>
                          <td>{{ $loop->iteration }}</td>
                          <td>{{ $item->code }}</td>
                          <td>{{ $item->persediaan->name_persediaan }}</td>
                          <td class="text-center">{{ $item->jumlah }}</td>
                          <td class="text-center">{{ $item->persediaan->satuan }}</td>
                          <td>Rp{{ format_uang($item->harga_beli) }}</td>
                          <td>Rp{{ format_uang($item->subtotal) }}</td>
                        </tr>
                      @endforeach
                    </tbody>
                    <tfoot>
                      <tr>
                        <th class="text-center" colspan="6">Total</th>
                        <th>Rp{{ format_uang($pembelianDetailSum) }}</th>
                      </tr>
                    </tfoot>
                  </table>
                </div> --}}
              </div>
            </div>
        </div>
    </div>
</div>