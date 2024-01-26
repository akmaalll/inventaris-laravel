<script type="text/javascript">
    $(document).ready(function() {
        $('#datatable').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                "url": "{{ asset('tabungan') }}",
                "type": "get",
            },
            columns: [{
                    data: 'DT_RowIndex',
                    sClass: 'text-center',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'tanggal_transaksi',
                    sClass: 'text-center'
                },
                {
                    data: 'no_transaksi',
                    sClass: 'text-center'
                },
                {
                    data: 'keterangan',
                    sClass: 'text-center'
                },
                {
                    data: 'debet',
                    sClass: 'text-center'
                },
                {
                    data: 'kredit',
                    sClass: 'text-center'
                },
                {
                    data: 'saldo',
                    sClass: 'text-center'

                },
                {
                    data: 'act',
                    sClass: 'text-center',
                    orderable: false,
                    searchable: false
                },
            ],
            order: []
        });
    });


    // Create Data
    $('#data_form').on('submit', function(e) {
        e.preventDefault();
        var idata = new FormData($('#data_form')[0]);
        $.ajax({
            type: "POST",
            dataType: "json",
            url: "{{ asset('tabungan/store') }}",
            data: idata,
            processData: false,
            contentType: false,
            cache: false,
            beforeSend: function() {
                in_load();
            },
            success: function(data) {
                toastr.success('' + data.status + '', '' + data.messages + '', 'success');
                window.location.href = "{{ asset('tabungan') }}";
                out_load();
            },
            error: function(error) {
                error_detail(error);
                out_load();
            }
        });
    });

    //  Edit Data
    function edit_data(id) {
        var token = $("input[name=_token]").val();
        $('#swal-update-button').attr('data-id', id);
        $.ajax({
            type: "GET",
            dataType: "json",
            url: "{{ asset('tabungan/edit') }}/" + id,
            data: {
                id: id,
                _token: token
            },
            beforeSend: function() {
                in_load();
            },
            success: function(data) {
                $('#tanggal_transaksi_edit').val(data.data.tanggal_transaksi);
                $('#no_transaksi_edit').val(data.data.no_transaksi);
                $('#keterangan_edit').val(data.data.keterangan);
                $('#debet_edit').val(data.data.debet);
                $('#kredit_edit').val(data.data.kredit);
                $('#saldo_edit').val(data.data.saldo);
            },
            error: function(error) {
                error_detail(error);
                out_load();
            }
        });

        // Update Data
        $('#swal-update-button').click(function(e) {
            e.preventDefault();
            var id = $('#swal-update-button').attr('data-id');
            var token = $("input[name=_token]").val();
            $.ajax({
                type: "PUT",
                dataType: "json",
                url: "{{ asset('tabungan/update') }}/" + id,
                data: {
                    _token: token,
                    tanggal_transaksi: $('#tanggal_transaksi_edit').val(),
                    no_transaksi: $('#no_transaksi_edit').val(),
                    keterangan: $('#keterangan_edit').val(),
                    debet: $('#debet_edit').val(),
                    kredit: $('#kredit_edit').val(),
                    saldo: $('#saldo_edit').val()

                },
                cache: false,
                beforeSend: function() {
                    in_load();
                },
                success: function(data) {
                    toastr.success('' + data.status + '', '' + data.messages + '', 'success');
                    window.location.href = "{{ asset('tabungan') }}";
                    out_load();
                },
                error: function(error) {
                    error_detail(error);
                    out_load();
                }
            });
        });
    }

    //show data
    function show_data(id) {
        $.ajax({
            type: "GET",
            dataType: "json",
            url: "{{ asset('tabungan/show') }}/" + id,
            data: "_method=SHOW&_token=" + tokenCSRF,
            beforeSend: function() {
                in_load();
            },
            success: function(data) {
                console.log(data.data);
                $('#modalLabel').html("Show Data");
                $('#tanggal_transaksi_show').html(data.data.tanggal_transaksi);
                $('#no_transaksi_show').html(data.data.no_transaksi);
                $('#keterangan_show').html(data.data.keterangan);
                $('#debet_show').html(data.data.debet);
                $('#kredit_show').html(data.data.kredit);
                $('#saldo_show').html(data.data.saldo);
                $('#tabungan_show').modal('show');
                out_load();
            },
            error: function(error) {
                error_detail(error);
                out_load();
            }
        });
    }


    // Delete Data
    function delete_data(id) {
        swal({
            title: "Konfirmasi Hapus !",
            text: "Apakah anda yakin ingin menghapus Data ?",
            icon: "warning",
            buttons: {
                cancel: "Batal",
                confirm: "Ya, Hapus !",
            },
            dangerMode: true
        }).then((deleteFile) => {
            if (deleteFile) {
                $.ajax({
                    type: "POST",
                    dataType: "json",
                    url: "{{ url('/tabungan/destroy') }}/" + id,
                    data: "_method=DELETE&_token=" + tokenCSRF,
                    beforeSend: function() {
                        in_load();
                    },
                    success: function(data) {
                        toastr.success('' + data.status + '', '' + data.messages + '', 'success');
                        window.location.href = "{{ asset('tabungan') }}";
                        out_load();
                    },
                    error: function(error) {
                        error_detail(error);
                        out_load();
                    }
                });
            }
        });
    }
</script>

































































<!-- <script type="text/javascript">
    $(document).ready(function() {
        $('#datatable').DataTable({
            processing: true,
            serverSide: true,
            language: {
                "Processing": "Processing...Please wait"
            },
            ajax: {
                type: "GET",
                url: "{{ asset('kaskecil') }}" // Menggunakan url() untuk menghasilkan URL lengkap
            },
            columns: [{
                    data: 'DT_RowIndex',
                    sClass: 'text-center',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'tanggal_transaksi',
                    sClass: 'text-center'
                },
                {
                    data: 'no_transaksi',
                    sClass: 'text-center'
                },
                {
                    data: 'nama_transaksi',
                    sClass: 'text-center'
                },
                {
                    data: 'debet',
                    sClass: 'text-center'
                },
                {
                    data: 'kredit',
                    sClass: 'text-center'
                },
                {
                    data: 'saldo',
                    sClass: 'text-center'
                },
                {
                    data: 'act',
                    sClass: 'text-center',
                    orderable: false,
                    searchable: false
                }
            ],
            order: []
        });

        // Create Data
        $('#data_form').on('submit', function(e) {
            e.preventDefault();
            idata = new FormData($('#data_form')[0]);
            $.ajax({
                type: "POST",
                dataType: "json",
                url: "{{ asset('kaskecil/store') }}", // Menggunakan url() untuk menghasilkan URL lengkap
                data: idata,
                processData: false,
                contentType: false,
                cache: false,
                beforeSend: function() {
                    in_load();
                },
                success: function(data) {
                    toastr.success('' + data.status + '', '' + data.messages + '', 'success');
                    window.location.href = "{{ asset('kaskecil') }}"; // Menggunakan url() untuk menghasilkan URL lengkap
                    out_load();
                },
                error: function(error) {
                    error_detail(error);
                    out_load();
                }
            });
        });

        // Edit Data
        function edit_data(id) {
            let token = $('input[name=_token]').val();
            $('#swal-update-button').attr('data-id', id);
            $.ajax({
                type: "GET",
                url: "{{ asset('kaskecil/edit') }}/" + id,
                data: {
                    id: id,
                    _token: token
                },
                beforeSend: function() {
                    in_load();
                },
                success: function(data) {
                    console.log(data.data);
                    $('#tanggal_transaksi_edit').val(data.data.tanggal_transaksi);
                    $('#no_transaksi_edit').val(data.data.no_transaksi);
                    $('#nama_transaksi_edit').val(data.data.nama_transaksi);
                    $('#debet_edit').val(data.data.debet);
                    $('#kredit_edit').val(data.data.kredit);
                    $('#saldo_edit').val(data.data.saldo);
                    $('#keterangan_edit').val(data.data.keterangan);
                },
                error: function(error) {
                    error_detail(error);
                    out_load();
                }
            });

            // Update Data
            // Update Data
            $('#form_edit').on('submit', function(e) {
                e.preventDefault();
                let id = $('#swal-update-button').attr('data-id');
                let token = $('input[name=_token]').val();
                $.ajax({
                    type: "PUT",
                    dataType: "json",
                    url: "{{ asset('kaskecil/update') }}/" + id,
                    data: {
                        _token: token,
                        tanggal_transaksi: $('#tanggal_transaksi_edit').val(),
                        no_transaksi: $('#no_transaksi_edit').val(),
                        nama_transaksi: $('#nama_transaksi_edit').val(),
                        debet: $('#debet_edit').val(),
                        kredit: $('#kredit_edit').val(),
                        saldo: $('#saldo_edit').val(),
                        keterangan: $('#keterangan_edit').val(),
                    },
                    cache: false,
                    beforeSend: function() {
                        in_load();
                    },
                    success: function(data) {
                        toastr.success('' + data.status + '', '' + data.messages + '', 'success');
                        window.location.href = "{{ asset('kaskecil') }}"
                        out_load();
                    },
                    error: function(error) {
                        error_detail(error);
                        out_load();
                    }
                });
            });
        }

        function show_data(id) {
            $.ajax({
                type: "GET",
                dataType: "json",
                url: "{{ asset('/kaskecil/show') }}/" + id,
                data: "_method=SHOW&_token=" + tokenCSRF,
                beforeSend: function() {
                    in_load();
                },
                success: function(data) {
                    console.log(data.data);
                    $('#modalLabel').html("Show Data");
                    $('#tanggal_transaksi_show').val(data.data.tanggal_transaksi);
                    $('#no_transaksi_show').html(data.data.no_transaksi);
                    $('#nama_transaksi_show').html(data.data.nama_transaksi);
                    $('#debet_show').val(data.data.debet);
                    $('#kredit_show').val(data.data.kredit);
                    $('#saldo_show').val(data.data.saldo);
                    $('#keterangan_show').html(data.data.keterangan);
                },
                error: function(error) {
                    error_detail(error);
                    out_load();
                }
            });
        }

        // Delete Data
        function delete_data(id) {
            swal({
                title: "Konfirmasi Hapus !",
                text: "Apakah anda yakin ingin menghapus Data ?",
                icon: "warning",
                buttons: {
                    cancel: "Batal",
                    confirm: "Ya, Hapus !",
                },
                dangerMode: true
            }).then((deleteFile) => {
                if (deleteFile) {
                    $.ajax({
                        type: "POST",
                        dataType: "json",
                        url: "{{ asset('kaskecil/destroy') }}/" + id,
                        data: "_method=DELETE&_token=" + tokenCSRF,
                        beforeSend: function() {
                            in_load();
                        },
                        success: function(data) {
                            toastr.success('' + data.status + '', '' + data.messages + '', 'success');
                            window.location.href = "{{ asset('kaskecil') }}"; // Menggunakan url() untuk menghasilkan URL lengkap
                            out_load();
                        },
                        error: function(error) {
                            error_detail(error);
                            out_load();
                        }
                    });
                }
            });
        }
    });
</script> -->