<!-- Modal -->
<div class="modal fade" data-backdrop="static" data-keyword="false" id="excel" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Import Data</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-12">
                        <small>* Asal Perolehan dan Lokasi bersifat Case Sensitive. <br>
                            Pastikan Namanya Sesuai dengan Data Bos dan Data Ruangan di System</small> <br>
                        <a href="/template-realisasi-anggaran.xlsx" class="btn btn-primary mb-3">Download Template</a>
                    </div>
                    <div class="col-lg-12">
                        <form id="exform" action="{{ asset('realisasianggaran/import') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('POST')
                            <input type="file" name="file" id="file" class="form-control" required>
                            <button type="submit" class="btn btn-danger mt-3">Import</button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>
            </div>
        </div>
    </div>
</div>