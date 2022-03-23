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
                          <label>Kode Persediaan*</label>
                          <input
                            type="text"
                            name="code"
                            id="code"
                            class="form-control"
                            placeholder="Kode Persediaan"
                            readonly
                          />
                        </div>
                        <!-- /.Kode Persediaan --> 
                        <div class="form-group">
                          <label>Nama Persediaans*</label>
                          <input
                            type="text"
                            name="name_persediaan"
                            id="name_persediaan"
                            class="form-control"
                            placeholder="Nama Persediaan"
                            required
                          />
                        </div>
                        <!-- /.Nama Persediaan --> 
                        <div class="form-group">
                          <label>Kategori*</label>
                          <select name="categories_id" class="form-control select2">
                            <option>--Pilih Kategori--</option>
                            @foreach ($categories as $category)
                              <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                          </select>                            
                        </div>
                        <!-- /.Kategori --> 
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label>Satuan Barang*</label>
                          <select name="satuan" class="form-control select2" required>
                            <option>--Pilih satuan--</option>
                            @foreach ($satuans as $item)
                              <option value="{{ $item->name }}">{{ $item->name }}</option>
                            @endforeach
                          </select>                            
                        </div>
                        <!-- /.satuan -->   
                        <div class="form-group">
                          <label>Satuan Berat*</label>
                          <select name="satuan_berat" class="form-control select2" required>
                            <option>--Pilih satuan--</option>
                            @foreach ($satuans as $item)
                              <option value="{{ $item->name }}">{{ $item->name }}</option>
                            @endforeach
                          </select>                            
                        </div>
                        <!-- /.satuan berat -->             
                        <div class="form-group">
                          <label>Harga Beli*</label>
                          <input
                            type="number"
                            name="harga_beli"
                            id="harga_beli"
                            class="form-control"
                            placeholder="Harga Modal"
                            required
                          />
                        </div>
                        <!-- /.Harga Modal -->                          
                      </div>
                      <div class="col-md-12">
                        <div class="form-group">
                          <label>Merk</label>
                          <textarea class="form-control" name="merk" id="merk" rows="3" placeholder="Merk Barang"></textarea>
                        </div>
                        <!-- /.Fungsi -->
                        <div class="form-group">
                          <label>Thumbnail*</label>
                          <input type="file" name="photos" id="photos" class="form-control"/>
                          <p class="text-muted">
                            Masukkan gambar barang
                          </p>
                        </div>
                        <!-- /.Thumbnail -->
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