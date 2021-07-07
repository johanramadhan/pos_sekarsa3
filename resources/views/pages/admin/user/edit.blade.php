@extends('layouts.admin')

@section('title')
    Edit User
@endsection

@section('content')
  <div class="content-wrapper">
  <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
            <h1 class="m-0">Edit User</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active">Edit Data User</li>
            </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-12">
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Edit User</h3>
              </div>
              <!-- /.card-header -->
              <form action="{{ route('user.update', $item->id) }}" method="POST" enctype="multipart/form-data">
                @method('PUT')
                @csrf
                <div class="card-body">
                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <label>Role</label>
                        <select name="roles" class="form-control">
                          <option value="{{ $item->roles }}" selected>Tidak diganti -- ({{ $item->roles }})</option>
                          <option value="USER">User</option>
                          <option value="ADMIN">Admin</option>
                        </select>                            
                      </div>
                      <!-- /.Nama Kabid/Kasubbag/Kasi -->             
                      <div class="form-group">
                        <label>Nama Bidang</label>
                        <input
                          type="text"
                          name="bidang"
                          class="form-control"
                          placeholder="Nama Bidang"
                          value="{{ $item->bidang }}" 
                          required
                        />
                      </div>
                      <!-- /.Nama Bidang -->             
                      <div class="form-group">
                        <label>Nama Kabid/Kasubbag/Kasi</label>
                        <input
                          type="text"
                          name="name"
                          class="form-control"
                          placeholder="Nama Kabid/Kasubbag/Kasi"
                          value="{{ $item->name }}"
                          required
                        />
                      </div>
                      <!-- /.Nama Kabid/Kasubbag/Kasi -->  
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label>NIP</label>
                        <input
                          type="text"
                          name="nip"
                          class="form-control"
                          placeholder="NIP"
                          value="{{ $item->nip }}"
                          required
                        />
                      </div>
                      <!-- /.NIP -->             
                      <div class="form-group">
                        <label>Email</label>
                        <input
                          type="email"
                          name="email"
                          class="form-control"
                          placeholder="Email"
                          value="{{ $item->email }}"
                          required
                        />
                      </div>
                      <!-- /.Email -->             
                      <div class="form-group">
                        <label>Password</label> (<i><small>Kosongkan jika tidak ingin mengganti password</small></i>)
                        <input
                          type="password"
                          name="password"
                          class="form-control"
                          placeholder="Password"
                        />
                      </div>
                      <!-- /.Password -->  
                    </div>
                    <div class="col-md-12">
                      <div class="form-group">
                        <label>Icon Bidang</label> (<i><small>Kosongkan jika tidak ingin mengganti Icon</small></i>)
                        <div class="input-group">
                          <div class="custom-file">
                            <input
                              type="file"
                              class="custom-file-input"
                              name="photo"
                            />
                            <label
                              class="custom-file-label"
                              for="exampleInputFile"
                              >Pilih Icon Bidang</label
                            >
                          </div>
                        </div>
                      </div>
                      <!-- /.Nama Icon -->
                    </div>
                  </div>
                </div>

                <div class="card-footer text-right">
                  <a href="{{ route('user.index') }}" class="btn btn-default">Kembali</a>
                  <button type="submit" class="btn btn-primary">
                    Edit
                  </button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>
@endsection