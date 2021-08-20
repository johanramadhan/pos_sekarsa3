<div class="modal fade" id="modal-form" tabindex="-1" role="dialog" aria-labelledby="modal-form">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title"></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="">
        <div class="modal-body">
          <div class="form-group row">
            <label for="code" class="col-sm-3 col-form-label">Code</label>
            <div class="col-sm-9">
              <input type="text" class="form-control" name="code" id="code"  placeholder="Kode Transaksi" readonly>
            </div>
          </div>
          <div class="form-group row">
            <label for="jumlah" class="col-sm-3 col-form-label">Jumlah</label>
            <div class="col-sm-9">
              <input type="number" class="form-control" name="jumlah" id="jumlah" onkeyup="sum()" placeholder="Jumlah">
            </div>
          </div>
          <div class="form-group row">
            <label for="Harga Jual" class="col-sm-3 col-form-label">Harga Jual</label>
            <div class="col-sm-9">
              <input type="number" class="form-control" name="harga_jual" id="harga_jual" onkeyup="sum()" placeholder="Harga Jual" readonly>
            </div>
          </div>
          <div class="form-group row">
            <label for="Diskon" class="col-sm-3 col-form-label">Disc/potongan</label>
            <div class="col-sm-9">
              <input type="number" class="form-control" name="diskon" id="diskon" onkeyup="sum()" placeholder="diskon">
            </div>
          </div>
          <div class="form-group row">
            <label for="Subtotal" class="col-sm-3 col-form-label">Subtotal</label>
            <div class="col-sm-9">
              <input type="number" class="form-control" name="subtotal" id="subtotal" onkeyup="sum()" placeholder="Subtotal" readonly>
            </div>
          </div>

        </div>
      </form>
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary">Save changes</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>