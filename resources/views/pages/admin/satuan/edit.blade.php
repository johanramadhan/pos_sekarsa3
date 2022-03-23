@extends('layouts.admin')

@section('title')
    Edit Satuan Aset
@endsection

@section('content')
  <div class="content-wrapper">
  <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
            <h1 class="m-0">Edit Satuan</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active">Edit Data Satuan</li>
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
                <h3 class="card-title">Edit Satuan</h3>
              </div>
              <!-- /.card-header -->
              <form action="{{ route('satuan.update', $item->id) }}" method="POST" enctype="multipart/form-data">
                @method('PUT')
                @csrf
                <div class="card-body">
                  <div class="form-group">
                    <label>Nama Satuan</label>
                    <input
                      type="text"
                      name="name"
                      class="form-control"
                      value="{{ $item->name }}"
                      required
                    />
                  </div>
                  <!-- /.Nama Satuan -->  
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