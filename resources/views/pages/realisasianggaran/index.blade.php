@extends('layouts.template')
@section('title','Realisasi Anggaran')
@section('content')
<div class="section-header">
    <h1><i class="fas fa-columns"></i> Realisasi Anggaran</h1>
    <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active">Realisasi Anggaran</div>
    </div>
</div>
<div class="section-body">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Realisasi Anggaran</h4>
                    <div class="ml-auto">
                        <div class="row justify-content-center">


                            <form action="{{ route('realisasianggaran.print') }}" method="get" class="mr-2">
                                @csrf
                                <div class="form-row align-items-center">
                                    <div class="col-auto">
                                        <label class="sr-only" for="bulan">Bulan</label>
                                        <select class="form-control" id="bulan" name="bulan">
                                            <option value="1">Januari</option>
                                            <option value="2">Februari</option>
                                            <option value="3">Maret</option>
                                            <option value="4">April</option>
                                            <option value="5">Mei</option>
                                            <option value="6">Juni</option>
                                            <option value="7">Juli</option>
                                            <option value="8">Agustus</option>
                                            <option value="9">September</option>
                                            <option value="10">Oktober</option>
                                            <option value="11">November</option>
                                            <option value="12">Desember</option>
                                        </select>
                                    </div>
                                    <div class="col-auto">
                                        <label class="sr-only" for="tahun">Tahun</label>
                                        <!-- Ambil daftar tahun unik dari data -->
                                        @php
                                        $uniqueYears = App\Models\RealisasiAnggaran::distinct()->pluck('tahun')->filter();
                                        @endphp
                                        <!-- Gunakan daftar tahun dalam dropdown -->
                                        <select class="form-control" id="tahun" name="tahun">
                                            @foreach ($uniqueYears as $year)
                                            <option value="{{ $year }}">{{ $year }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-auto">
                                        <button type="submit" class="btn btn-danger ">Print</button>
                                    </div>
                                </div>
                            </form>
                            <div class="col-auto">
                                <button type="button" class="btn btn-primary mt-2" data-toggle="modal" data-target="#realisasianggaran_create">
                                    <i class="fa fa-plus"></i> Tambah
                            </div>
                            <div class="col-auto">
                                <button type="button" class="btn btn-success mt-2" data-toggle="modal" data-target="#excel">
                                    <i class="fas fa-fw fa-file-excel"></i>Import </button>
                            </div>
                            <div class="col-auto">
                                <a href="{{ asset('kaskecil/export') }}" class="btn btn-info mt-2 mr-3" data-toggle="tooltip" title="Export Excel">
                                    <i class="fa fa-file-csv"></i> Export</a>

                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row px-3 py-3">
                        <div class="col-lg-12">
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover" id="datatable" style="width: 100%;">
                                    <thead>
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">Kode</th>
                                            <th scope="col">Bulan</th>
                                            <th scope="col">Tahun</th>
                                            <th scope="col">Deskripsi</th>
                                            <th scope="col">Anggaran</th>
                                            <th scope="col">Realisasi </th>
                                            <th scope="col">Selisih </th>
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
@include('pages.realisasianggaran.modal.create')
@include('pages.realisasianggaran.modal.edit')
@include('pages.realisasianggaran.modal.show')
@include('pages.realisasianggaran.modal.import')
@include('pages.realisasianggaran._script')
@endpush