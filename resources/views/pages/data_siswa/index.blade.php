@extends('layouts.template')
@section('title', 'Data Siswa')

@section('content')
<div class="section-header">
    <h1><i class="fa fa-graduation-cap"></i> Data Siswa PSAA Fajar Harapan</h1>
    <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active">Data Siswa</div>
    </div>
</div>
<div class="section-body">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Data Siswa</h4>
                    <div class="ml-auto">
                        <button type="button" class="btn btn-primary float-right mt-3 mx-3" data-toggle="modal" data-target="#data_siswa_create">
                            <i class="fa fa-plus"></i> Tambah Data
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row px-3 py-3">
                        <div class="col-lg-12">
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover" id="datatable" style="width: 100%;">
                                    <thead>
                                        <tr>
                                            <th scope="col">No</th>
                                            <th scope="col">Nama</th>
                                            <th scope="col">TTL</th>
                                            <th scope="col">JK</th>
                                            <th scope="col">Pend. Terakhir</th>
                                            <th scope="col">Nama Ayah</th>
                                            <th scope="col">Nama Ibu</th>
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
@include('pages.data_siswa.modal.create')
@include('pages.data_siswa.modal.edit')
@include('pages.data_siswa.modal.show')
@include('pages.data_siswa._script')
@endpush