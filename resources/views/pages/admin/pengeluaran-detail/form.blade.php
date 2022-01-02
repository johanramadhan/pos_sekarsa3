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
                          <label>Tanggal Pengeluaran</label>
                          <div class="input-group date" id="reservationdate" data-target-input="nearest">
                            <input type="text" 
                            class="form-control datetimepicker-input"  
                            data-inputmask-alias="datetime" 
                            data-inputmask-inputformat="dd/mm/yyyy" 
                            data-mask 
                            data-target="#reservationdate"
                            name="created_at"
                            required/>
                            <div class="input-group-append" data-target="#reservationdate" data-toggle="datetimepicker">
                              <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                            </div>
                          </div>
                        </div>
                        <div class="form-group">
                          <label>Pengeluaran*</label>
                          <select name="id_pengeluaran" class="form-control select2" required>
                            <option>--Pilih Pengeluaran--</option>
                            @foreach ($pengeluarans as $pengeluaran)
                              <option value="{{ $pengeluaran->id_pengeluaran }}">{{ $pengeluaran->code }} - {{ $pengeluaran->keterangan }}</option>
                            @endforeach
                          </select>                            
                        </div>
                        <!-- /.pengeluaran -->
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
                      </div>    
                      <div class="col-md-6">
                        <div class="form-group">
                          <label>Satuan*</label>
                          <select name="satuan" class="form-control select2" required>
                            <option>--Pilih Satuan--</option>
                            @includeIf('pages.satuan')
                          </select>                            
                        </div>
                        <!-- /.Kasir -->
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
                      <div class="col-md-12">
                        <div class="form-group">
                          <label>Uraian</label>
                          <textarea class="form-control" name="uraian" id="uraian" rows="3" placeholder="Uraian"></textarea>
                        </div>
                        <!-- /.Keterangan -->
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