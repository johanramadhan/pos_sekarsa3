@extends('layouts.admin')

@section('title')
    Edit Kategori Aset
@endsection

@section('content')
  <div class="content-wrapper">
  <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
            <h1 class="m-0">Edit Kategori</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active">Edit Data Kategori</li>
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
                <h3 class="card-title">Edit Kategori</h3>
              </div>
              <!-- /.card-header -->
              <form action="{{ route('category.update', $item->id) }}" method="POST" enctype="multipart/form-data">
                @method('PUT')
                @csrf
                <div class="card-body">
                  <div class="form-group">
                    <label>Nama Kategori</label>
                    <input
                      type="text"
                      name="name"
                      class="form-control"
                      value="{{ $item->name }}"
                      required
                    />
                  </div>
                  <!-- /.Nama Kategori -->             
                  <div class="form-group">
                    <label>Icon</label>
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
                          >Kosongkan jika tidak ingin mengganti icon</label
                        >
                      </div>
                    </div>
                  </div>
                  <!-- /.Nama Icon -->  
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