<!-- Modal -->
<div class="modal fade" id="realisasianggaran_create" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Tambah Data</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="data_form">
                    @csrf
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label for="kode">Kode</label>
                                <input type="number" name="kode" id="kode" class="form-control">
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label for="bulan">Bulan</label>
                                <select class="form-control" name="bulan" id="bulan">
                                    @for ($i = 1; $i <= 12; $i++) <option value="{{ \Carbon\Carbon::create()->month($i)->format('F') }}">{{ \Carbon\Carbon::create()->month($i)->format('F') }}</option>
                                        @endfor
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label for="tahun">Tahun</label>
                                @php
                                $currentYear = date('Y');
                                @endphp

                                <select class="form-control" name="tahun" id="tahun">
                                    <option value="{{ $currentYear }}">{{ $currentYear }}</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label for="deskripsi">Deskripsi</label>
                                <input type="text" name="deskripsi" id="deskripsi" class="form-control">
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label for="anggaran">Anggaran</label>
                                <input type="number" name="anggaran" id="anggaran" class="form-control">
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label for="realisasi">Realiasi</label>
                                <input type="number" name="realisasi" id="realisasi" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>
                        <button type="submit" class="btn btn-primary"><i class="fa fa-check-square"></i> Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>