<div class="modal fade" id="modal-form" tabindex="-1" role="dialog" aria-labelledby="modal-form" role="document">
  <div class="modal-dialog modal-xl">
    <form action="" method="POST" class="form-horizontal" enctype="multipart/form-data">
      @csrf
      @method('POST')

      <div class="modal-content bg-default">
        <div class="modal-header">
          <h4 class="modal-title"></h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="container-fluid">
            <div class="row">
              <div class="col-md-12">
                @if ($errors->any())
                  <div class="alert alert-danger">
                    <ul>
                      @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                      @endforeach
                    </ul>
                  </div>
                @endif
                <div class="card card-primary">
                  <div class="card-body">
                    <div class="row">   
                      <div class="col-md-6">
                        <div class="form-group">
                          <label>Pembelian*</label>
                          <select name="id_pembelian" class="form-control select2" required>
                            <option>--Pilih Pembelian--</option>
                            @foreach ($pembelians as $pembelian)
                              <option value="{{ $pembelian->id_pembelian }}">{{ $pembelian->code }} - {{ $pembelian->supplier->name }}</option>
                            @endforeach
                          </select>                            
                        </div>
                        <!-- /.Pembelian -->
                        <div class="form-group">
                          <label>Persediaan*</label>
                          <select name="id_pembelian" class="form-control select2" required>
                            <option>--Pilih Persediaan--</option>
                            @foreach ($persediaans as $item)
                              <option value="{{ $item->id_persediaan }}">{{ $item->code }} - {{ $item->name_persediaan }}</option>
                            @endforeach
                          </select>                            
                        </div>
                        <!-- /.Persediaan -->
                        <div class="form-group">
                          <label>jumlah*</label>
                          <input
                            type="number"
                            name="jumlah"
                            id="jumlah"
                            class="form-control"
                            placeholder="Jumlah"
                            required
                          />                            
                        </div>
                        <!-- /.Jumlah -->
                        <div class="form-group">
                          <label>Harga Beli*</label>
                          <input
                            type="number"
                            name="harga_beli"
                            id="harga_beli"
                            class="form-control"
                            placeholder="Harga Beli"
                            required
                          />                            
                        </div>
                        <!-- /.Harga Beli -->
                      </div>    
                      <div class="col-md-6">
                        <div class="form-group">
                          <label>Harga Per Satuan*</label>
                          <input
                            type="number"
                            name="harga_persatuan"
                            id="harga_persatuan"
                            class="form-control"
                            placeholder="Harga Per Satuan"
                            required
                          />                            
                        </div>
                        <!-- /.Harga Per Satuan -->
                        <div class="form-group">
                          <label>Berat*</label>
                          <input
                            type="number"
                            name="berat"
                            id="berat"
                            class="form-control"
                            placeholder="Berat"
                            required
                          />                            
                        </div>
                        <!-- /.Total Harga -->
                        <div class="form-group">
                          <label>Berat Total*</label>
                          <input
                            type="number"
                            name="berat_total"
                            id="berat_total"
                            class="form-control"
                            placeholder="Berat Total"
                            required
                          />                            
                        </div>
                        <!-- /.Berat Total -->
                        <div class="form-group">
                          <label>Subtotal*</label>
                          <input
                            type="number"
                            name="subtotal"
                            id="subtotal"
                            class="form-control"
                            placeholder="Subtotal"
                            required
                          />                            
                        </div>
                        <!-- /.Subtotal -->
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer justify-content-between">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Save</button>
        </div>
      </div>
    </form>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>