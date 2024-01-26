<script type="text/javascript">
    $(document).ready(function() {
        $('#datatable').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                "url": "{{ asset('data_siswa') }}",
                "type": "get",
            },
            columns: [{
                    data: 'DT_RowIndex',
                    sClass: 'text-center',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'nama',
                    sClass: 'text-center'
                },
                {
                    data: 'tempat_tanggal_lahir',
                    sClass: 'text-center'
                },
                {
                    data: 'jenis_kelamin',
                    sClass: 'text-center'
                },
                {
                    data: 'pendidikan_terakhir',
                    sClass: 'text-center'
                },
                {
                    data: 'nama_ayah',
                    sClass: 'text-center'
                },
                {
                    data: 'nama_ibu',
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
            url: "{{ asset('data_siswa/store') }}",
            data: idata,
            processData: false,
            contentType: false,
            cache: false,
            beforeSend: function() {
                in_load();
            },
            success: function(data) {
                toastr.success('' + data.status + '', '' + data.messages + '', 'success');
                window.location.href = "{{ asset('data_siswa') }}";
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
            url: "{{ asset('data_siswa/edit') }}/" + id,
            data: {
                id: id,
                _token: token
            },
            beforeSend: function() {
                in_load();
            },
            success: function(data) {
                $("#nama_edit").val(data.data.nama);
                $("#tempat_tanggal_lahir_edit").val(data.data.tempat_tanggal_lahir);
                $("#jenis_kelamin_edit").val(data.data.jenis_kelamin);
                $("#pendidikan_terakhir_edit").val(data.data.pendidikan_terakhir);
                $("#nama_ayah_edit").val(data.data.nama_ayah);
                $("#nama_ibu_edit").val(data.data.nama_ibu);
                $("#pekerjaan_orangtua_edit").val(data.data.pekerjaan_orangtua);
                $("#alamat_edit").val(data.data.alamat);
                $("#tanggal_masuk_edit").val(data.data.tanggal_masuk);
                $("#tanggal_keluar_edit").val(data.data.tanggal_keluar);
                $("#status_edit").val(data.data.status);
                $("#keterangan_edit").val(data.data.keterangan);
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
                url: "{{ asset('data_siswa/update') }}/" + id,
                data: {
                    _token: token,
                    nama: $('#nama_edit').val(),
                    tempat_tanggal_lahir: $('#tempat_tanggal_lahir_edit').val(),
                    jenis_kelamin: $('#jenis_kelamin_edit').val(),
                    pendidikan_terakhir: $('#pendidikan_terakhir_edit').val(),
                    nama_ayah: $('#nama_ayah_edit').val(),
                    nama_ibu: $('#nama_ibu_edit').val(),
                    pekerjaan_orangtua: $('#pekerjaan_orangtua_edit').val(),
                    alamat: $('#alamat_edit').val(),
                    tanggal_masuk: $('#tanggal_masuk_edit').val(),
                    tanggal_keluar: $('#tanggal_keluar_edit').val(),
                    status: $('#status_edit').val(),
                    keterangan: $('#keterangan_edit').val()
                },
                cache: false,
                beforeSend: function() {
                    in_load();
                },
                success: function(data) {
                    toastr.success('' + data.status + '', '' + data.messages + '', 'success');
                    window.location.href = "{{ asset('data_siswa') }}";
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
            url: "{{ asset('data_siswa/show') }}/" + id,
            data: "_method=SHOW&_token=" + tokenCSRF,
            beforeSend: function() {
                in_load();
            },
            success: function(data) {
                console.log(data.data);
                $('#modalLabel').html("Show Data");
                $("#nama_show").html(data.data.nama);
                $("#tempat_tanggal_lahir_show").html(data.data.tempat_tanggal_lahir);
                var jenisKelaminText = (data.data.jenis_kelamin === 'L') ? 'Laki-laki' : 'Perempuan';
                $("#jenis_kelamin_show").html(jenisKelaminText);
                $("#pendidikan_terakhir_show").html(data.data.pendidikan_terakhir);
                $("#nama_ayah_show").html(data.data.nama_ayah);
                $("#nama_ibu_show").html(data.data.nama_ibu);
                $("#pekerjaan_orangtua_show").html(data.data.pekerjaan_orangtua);
                $("#alamat_show").html(data.data.alamat);
                $("#tanggal_masuk_show").html(data.data.tanggal_masuk);
                $("#tanggal_keluar_show").html(data.data.tanggal_keluar);
                $("#status_show").html(data.data.status);
                $("#keterangan_show").html(data.data.keterangan);
                $('#data_siswa_show').modal('show');
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
                    url: "{{ url('/data_siswa/destroy') }}/" + id,
                    data: "_method=DELETE&_token=" + tokenCSRF,
                    beforeSend: function() {
                        in_load();
                    },
                    success: function(data) {
                        toastr.success('' + data.status + '', '' + data.messages + '', 'success');
                        window.location.href = "{{ asset('data_siswa') }}";
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