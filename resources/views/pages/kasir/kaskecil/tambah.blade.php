<div class="modal fade" id="modal-kaskecil" tabindex="-1" role="dialog" aria-labelledby="modal-kaskecil">
  <div class="modal-dialog modal-xl" role="document">
    <div class="modal-content">
      <form action="{{ route('kasKecil.create') }}">
        <div class="modal-header">
          <h4 class="modal-title">Tambah Kas kecil</h4>
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
                        <label>Uraian</label>
                        <textarea class="form-control" name="uraian" rows="3" placeholder="Uraian"></textarea>
                      </div>
                      <!-- /.Uraian -->
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