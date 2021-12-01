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
                      </div>    
                      <div class="col-md-6">                        
                        <div class="form-group">
                          <label>Status*</label>
                          <select name="transaction_status" class="form-control select2">
                            <option>--Pilih Status--</option>
                            <option value="sukses">Sukses</option>
                            <option value="success">Success</option>
                            <option value="pending">Pending</option>
                          </select>                            
                        </div>
                        <!-- /.Total Harga -->
                      </div>               
                      <div class="col-md-12">
                        <!-- /.Tanggal pengeluaran -->
                        <div class="form-group">
                          <label>Keterangan</label>
                          <textarea class="form-control" name="keterangan" id="keterangan" rows="3" placeholder="Keterangan"></textarea>
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