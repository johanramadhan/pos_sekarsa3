<div class="modal fade" id="modal-member" tabindex="-1" role="dialog" aria-labelledby="modal-member">
  <div class="modal-dialog modal-xl" role="document">
    <div class="modal-content">
      <form action="{{ route('memberkasir.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="modal-header">
          <h4 class="modal-title">Tambah Kas kecil</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="container-fluid">
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
                      <label>Tipe Member*</label>
                      <select name="type" class="form-control select2" required>
                        <option>--Pilih Tipe Member--</option>
                        <option value="1">Gold</option>
                        <option value="2">Silver</option>
                      </select>                            
                    </div>
                    <!-- /.Tipe Member --> 
                    <div class="form-group">
                      <label>Kode Member*</label>
                      <input
                        type="hidden"
                        name="code"
                        class="form-control"
                        placeholder="Kode Member"
                        value="{{ $code }}"
                        readonly
                        required
                      />                      
                      <input
                        type="text"
                        name="code2"
                        class="form-control"
                        placeholder="Kode Member"
                        required
                      />                      
                    </div>
                    <div class="form-group">
                      <label>Nama Member*</label>
                      <input
                        type="text"
                        name="name"
                        class="form-control"
                        placeholder="Nama Member"
                        required
                      />
                    </div>
                    <!-- /.Nama Member --> 
                    <div class="form-group">
                      <label>Jenis Kelamin*</label>
                      <select name="gender" class="form-control select2" required>
                        <option>--Pilih Jenis Kelamin--</option>
                        <option value="1">Laki-laki</option>
                        <option value="2">Perempuan</option>
                        <option value="3">Others</option>
                      </select>                            
                    </div>
                    <!-- /.Jenis Kelamin -->  
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label>No HP*</label>
                      <input
                        type="number"
                        name="phone"
                        class="form-control"
                        placeholder="No HP"
                      />
                    </div>
                    <!-- /.No HP --> 
                    <div class="form-group">
                      <label>Email</label>
                      <input
                        type="email"
                        name="email"
                        class="form-control"
                        placeholder="Nama Email"
                      />
                    </div>
                    <!-- /.Nama Email --> 
                    <div class="form-group">
                      <label>Alamat</label>
                      <textarea class="form-control" name="address" rows="5" placeholder="Alamat"></textarea>
                    </div>
                    <!-- /.Keterangan -->
                  </div>
                  <div class="col-md-12">
                    <div class="form-group">
                      <label>Keterangan</label>
                      <textarea class="form-control" name="description" rows="3" placeholder="Keterangan"></textarea>
                    </div>
                    <!-- /.Keterangan -->
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