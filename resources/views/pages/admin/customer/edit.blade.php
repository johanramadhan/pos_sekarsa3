@extends('layouts.admin')

@section('title')
    Edit Customer Aset
@endsection

@section('content')
  <div class="content-wrapper">
  <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
            <h1 class="m-0">Edit Customer</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active">Edit Data Customer</li>
            </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-6">
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Edit Customer</h3>
              </div>
              <!-- /.card-header -->
              <form action="{{ route('customer.update', $item->id) }}" method="POST" enctype="multipart/form-data">
                @method('PUT')
                @csrf
                <div class="card-body">
                  <div class="form-group">
                    <label>Nama Customer*</label>
                    <input
                      type="text"
                      name="name"
                      class="form-control"
                      placeholder="Nama Customer"
                      value="{{ $item->name }}"
                      required
                    />
                  </div>
                  <!-- /.Nama Kategori -->   
                  <div class="form-group">
                    <label>Jenis Kelamin</label>
                    <select name="gender" class="form-control select2" required>
                      @if (($item->gender) === 1)
                        <option>-- Tidak diganti (Laki-laki) --</option>
                      @elseif(($item->gender) === 2)
                        <option>-- Tidak diganti (Perempuan) --</option>
                      @endif                       
                      <option value="1">Laki-laki</option>
                      <option value="2">Perempuan</option>
                    </select>                            
                  </div>
                  <!-- /.Jenis Kelamin -->           
                  <div class="form-group">
                    <label>Email*</label>
                    <input
                      type="email"
                      name="email"
                      class="form-control"
                      placeholder="Email"
                      value="{{ $item->email }}"
                      required
                    />
                  </div>
                  <!-- /.email -->             
                  <div class="form-group">
                    <label>No. HP/WA*</label>
                    <input
                      type="number"
                      name="phone"
                      class="form-control"
                      placeholder="No. HP/WA"
                      value="{{ $item->phone }}"
                      required
                    />
                  </div>
                  <!-- /.No. HP/WA -->             
                  <div class="form-group">
                    <label>Address*</label>
                    <textarea class="form-control" name="address" rows="2" placeholder="Address/Alamat" required>{{ $item->address }}</textarea>
                  </div>
                  <!-- /.Address -->            
                  <div class="form-group">
                    <label>Keterangan</label>
                    <textarea class="form-control" name="description" rows="2" placeholder="Keterangan">{{ $item->description }}</textarea>
                  </div>
                  <!-- /.Description -->
                </div>

                <div class="card-footer text-right">
                  <a href="{{ route('category.index') }}" class="btn btn-default">Kembali</a>
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