@extends('layouts.template')
@section('title', 'Data Pengajar')

@section('content')
<div class="section-header">
    <h1><i class="fa fa-users"></i> Data Pengajar PSAA Fajar Harapan</h1>
    <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active">Data Pengajar</div>
    </div>
</div>
<div class="section-body">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Data Pengajar</h4>
                    <div class="ml-auto">
                        <button type="button" class="btn btn-primary float-right mt-3 mx-3" data-toggle="modal" data-target="#data_pengajar_create">
                            <i class="fa fa-plus"></i> Tambah Data
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row px-3 py-3">
                        <div class="col-lg-12">
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover" id="datatable">
                                    <thead>
                                        <tr>
                                            <th scope="col">No</th>
                                            <th scope="col">No.KTP</th>
                                            <th scope="col">Nama</th>
                                            <th scope="col">Jenis Kelamin</th>
                                            <th scope="col">Usia</th>
                                            <th scope="col">Alamat</th>
                                            <th scope="col">Jabatan</th>
                                            <th scope="col">Action</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('js_internal')
@include('pages.data_pengajar.modal.create')
@include('pages.data_pengajar.modal.edit')
@include('pages.data_pengajar.modal.show')
@include('pages.data_pengajar._script')
@endpush