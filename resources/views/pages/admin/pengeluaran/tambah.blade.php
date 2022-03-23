<div class="modal fade" id="modal-pengeluaran" tabindex="-1" role="dialog" aria-labelledby="modal-pengeluaran">
  <div class="modal-dialog modal-xl" role="document">
    <div class="modal-content">
      <form action="{{ route('pengeluaran.create') }}">
        <div class="modal-header">
          <h4 class="modal-title">Tambah Pengeluaran</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="container-fluid">
            <div class="card card-primary">
              <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                      <div class="form-group">
                        <label>Tanggal Pengeluaran</label>
                        <div class="input-group date" id="reservationdate" data-target-input="nearest">
                          <input type="text" 
                          class="form-control datetimepicker-input"  
                          data-inputmask-alias="datetime" 
                          data-inputmask-inputformat="dd/mm/yyyy" 
                          data-mask 
                          data-target="#reservationdate"
                          name="tgl_pengeluaran"
                          value="{{ date("d-m-Y") }}"
                          required/>
                          <div class="input-group-append" data-target="#reservationdate" data-toggle="datetimepicker">
                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                          </div>
                        </div>
                      </div>
                      <!-- /.Tanggal pengeluaran -->
                      <div class="form-group">
                        <label>Keterangan Pengeluaran</label>
                        <textarea class="form-control" name="keterangan" rows="3" placeholder="Keterangan pengeluaran"></textarea>
                      </div>
                      <!-- /.Keterangan pengeluaran -->
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
      </form>           
    </div>
  </div>
</div>