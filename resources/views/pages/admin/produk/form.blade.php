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
                          <label>Kode Produk*</label>
                          <input
                            type="text"
                            name="code"
                            id="code"
                            class="form-control"
                            placeholder="Kode Barang"
                            readonly
                            value="{{$code}}"
                          />
                        </div>
                        <!-- /.Kode Barang --> 
                        <div class="form-group">
                          <label>Nama Produk*</label>
                          <input
                            type="text"
                            name="name_product"
                            id="name_product"
                            class="form-control"
                            placeholder="Nama Barang"
                            required
                          />
                        </div>
                        <!-- /.Nama Barang --> 
                        <div class="form-group">
                          <label>Kategori*</label>
                          <select name="categories_id" class="form-control select2" required>
                            <option>--Pilih Kategori--</option>
                            @foreach ($categories as $category)
                              <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                          </select>                            
                        </div>
                        <!-- /.Kategori --> 
                        <div class="form-group">
                          <label>Satuan Barang*</label>
                          <select name="satuan" class="form-control select2" required>
                            <option>--Pilih satuan--</option>
                            @includeIf('pages.satuan')
                          </select>                            
                        </div>
                        <!-- /.satuan -->     
                        <div class="form-group">
                          <label>Satuan Berat*</label>
                          <select name="satuan_berat" class="form-control select2" required>
                            <option>--Pilih satuan berat--</option>
                            <option value="Kilogram">Kilogram</option>
                            <option value="Gram">Gram</option>
                          </select>                            
                        </div>
                        <!-- /.satuan berat-->    
                      </div>
                      <div class="col-md-6">    
                        <div class="form-group">
                          <label>diskon</label>
                          <input
                            type="number"
                            name="diskon"
                            id="diskon"
                            class="form-control"
                            placeholder="Masukkan diskon"
                            required
                          />
                        </div>
                        <!-- /.Diskon -->       
                        <div class="form-group">
                          <label>Harga Modal*</label>
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
                        <div class="form-group">
                          <label>Harga Jual*</label>
                          <input
                            type="number"
                            name="harga_jual"
                            id="harga_jual"
                            class="form-control"
                            placeholder="Harga Jual"
                            required
                          />
                        </div>
                        <!-- /.Harga Jual -->                                
                        <div class="form-group">
                          <label>Merk</label> (<i><small>Kosongkan jika tidak ada link</small></i>)
                          <input
                            type="text"
                            name="merk"
                            id="merk"
                            class="form-control"
                            placeholder="Masukkan Merk"
                            required
                          />
                        </div>
                        <!-- /.Merk -->                           
                        <div class="form-group">
                          <label>Stok</label>
                          <input
                            type="text"
                            name="stok"
                            id="stok"
                            class="form-control"
                            placeholder="Masukkan Stok"
                            required
                          />
                        </div>
                        <!-- /.Stok -->                           
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