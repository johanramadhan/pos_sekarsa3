<div class="modal fade" id="modal-laporan" tabindex="-1" role="dialog" aria-labelledby="modal-laporan">
  <div class="modal-dialog modal-xl" role="document">
    <div class="modal-content">
      <form action="{{ route('transactions.searchByDate') }}" method="post" data-toggle="validator">
        {{ csrf_field() }}
        <div class="modal-header">
          <h4 class="modal-title">Update Tanggal</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="container-fluid">
            <div class="card card-primary">
              <div class="card-body">
                <div class="row">
                  <div class="col-md-6">
                    <!-- Date -->
                    <div class="form-group">
                      <label>Tanggal Awal :</label>
                        <div class="input-group date" id="reservationdate" data-target-input="nearest">
                            <input type="text" 
                            class="form-control datetimepicker-input"  
                            data-inputmask-alias="datetime" 
                            data-inputmask-inputformat="dd/mm/yyyy" 
                            data-mask 
                            data-target="#reservationdate"
                            name="tanggal_awal"
                            id="tanggal_awal"
                            value="{{ request('tanggal_awal') ??  date('Y-m-d') }}"
                            required/>
                            <div class="input-group-append" data-target="#reservationdate" data-toggle="datetimepicker">
                              <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                            </div>
                        </div>
                    </div>
                    <!-- /.form group -->
                  </div>
                  <div class="col-md-6">
                    <!-- Date -->
                    <div class="form-group">
                      <label>Tanggal Akhir :</label>
                        <div class="input-group date" id="reservationdate2" data-target-input="nearest">
                            <input type="text" 
                            class="form-control datetimepicker-input"  
                            data-inputmask-alias="datetime" 
                            data-inputmask-inputformat="dd/mm/yyyy" 
                            data-mask 
                            data-target="#reservationdate2"
                            name="tanggal_akhir"
                            id="tanggal_akhir"
                            value="{{ request('tanggal_akhir') ?? date('Y-m-d') }}"
                            required/>
                            <div class="input-group-append" data-target="#reservationdate2" data-toggle="datetimepicker">
                              <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                            </div>
                        </div>
                    </div>
                    <!-- /.form group -->
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