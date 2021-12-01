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
                          <label>Tanggal Pembelian</label>
                          <div class="input-group date" id="reservationdate2" data-target-input="nearest">
                            <input type="text" 
                            class="form-control datetimepicker-input"  
                            data-inputmask-alias="datetime" 
                            data-inputmask-inputformat="dd/mm/yyyy" 
                            data-mask 
                            data-target="#reservationdate2"
                            name="tgl_pembelian"
                            id="tgl_pembelian"
                            required/>
                            <div class="input-group-append" data-target="#reservationdate2" data-toggle="datetimepicker">
                              <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                            </div>
                          </div>
                        </div>
                        <div class="form-group">
                          <label>Kasir*</label>
                          <select name="users_id" class="form-control select2" required>
                            <option>--Pilih Kasir--</option>
                            @foreach ($user as $kasir)
                              <option value="{{ $kasir->id }}">{{ $kasir->name }}</option>
                            @endforeach
                          </select>                            
                        </div>
                        <!-- /.Kasir -->
                        <div class="form-group">
                          <label>Supplier*</label>
                          <select name="id_supplier" class="form-control select2" required>
                            <option>--Pilih Supplier--</option>
                            @foreach ($suppliers as $supplier)
                              <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                            @endforeach
                          </select>                            
                        </div>
                        <!-- /.Kasir -->
                        <div class="form-group">
                          <label>Total Item*</label>
                          <input
                            type="number"
                            name="total_item"
                            id="total_item"
                            class="form-control"
                            placeholder="Total Item"
                            required
                          />                            
                        </div>
                        <!-- /.Total Item -->
                      </div>    
                      <div class="col-md-6">
                        <div class="form-group">
                          <label>Total Harga*</label>
                          <input
                            type="number"
                            name="total_harga"
                            id="total_harga"
                            class="form-control"
                            placeholder="Total Harga"
                            required
                          />                            
                        </div>
                        <!-- /.Total Harga -->
                        <div class="form-group">
                          <label>Diskon*</label>
                          <input
                            type="number"
                            name="diskon"
                            id="diskon"
                            class="form-control"
                            placeholder="Diskon"
                            required
                          />                            
                        </div>
                        <!-- /.Total Harga -->
                        <div class="form-group">
                          <label>Bayar*</label>
                          <input
                            type="number"
                            name="bayar"
                            id="bayar"
                            class="form-control"
                            placeholder="Bayar"
                            required
                          />                            
                        </div>
                        <!-- /.Bayar -->
                        <div class="form-group">
                          <label>Status*</label>
                          <select name="status" class="form-control select2">
                            <option>--Pilih Status--</option>
                            <option value="Sukses">Sukses</option>
                            <option value="Success">Success</option>
                            <option value="Pending">Pending</option>
                          </select>                            
                        </div>
                        <!-- /.Total Harga -->
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