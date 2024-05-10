@extends('main')

@section('isidashboard')
    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header">
                    <h5>Table Pengajuan</h5>
                </div>
                @if (auth()->user()->status == 'Staff')
                    <div class="row">
                        <div class="col-md-2 col-xs-12 ml-3 mt-3">
                            <div class="form-group">
                                <a href="#" onclick="tambah()" class="btn btn-success btn-block tambah"><i
                                        class="fa fa-plus"></i>
                                    Tambah</a>
                            </div>
                        </div>
                    </div>
                @endif
                <div class="card-body table-border-style">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover display" id="table-pengajuan" width="100%">
                            <thead>
                                <tr>
                                    <th class="text-center">No</th>
                                    <th class="text-center">Tanggal</th>
                                    <th class="text-center">Jenis Pengajuan</th>
                                    <th class="text-center">Item</th>
                                    <th class="text-center">Jumlah (Rp)</th>
                                    <th class="text-center">Diajukan Oleh</th>
                                    <th class="text-center">Status</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- Modal Tambah --}}
    <div id="modal_pengajuan" class="modal fade" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal_pengajuanLabel">Data Pengajuan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                </div>
                <div class="error"></div>
                <div class="modal-body">
                    <form enctype="multipart/form-data" id="frm_pengajuan">
                        <div class="row">
                            <input type="hidden" class="form-control" id="aju_user_id" name="aju_user_id"
                                value="{{ auth()->user()->id }}" required>
                            <input type="hidden" class="form-control" id="aju_user" name="aju_user"
                                value="{{ auth()->user()->name }}" required>
                            <div class="mb-3">
                                <label for="aju_jenis_data">Jenis Data</label>
                                <select class="form-control" id="aju_jenis_data" name="aju_jenis_data" name="jenis_data"
                                    style="width:100%;" required>
                                    <option value="" selected>==Pilih Jenis Data==</option>
                                    <option value="Operasional">Operasional</option>
                                    <option value="Penyaluran">Penyaluran</option>
                                </select>
                            </div>
                            <div class="form-group mb-3">
                                <label>Rincian</label>
                                <textarea class="form-control" id="aju_item" rows="5"></textarea>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group mb-3">
                                    <label class="label" for="aju_tgl">Tanggal Pengajuan</label>
                                    <input type="date" class="form-control" id="aju_tgl" name="aju_tgl" required>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group mb-3">
                                    <label class="label" for="aju_jumlah">Jumlah</label>
                                    <input type="number" class="form-control" id="aju_jumlah" name="aju_jumlah" required>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn  btn-danger" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn  btn-success" id="save_pengajuan">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Toastr -->
    <script src="{{ asset('dashboard/plugins/toastr/toastr.min.js') }}"></script>
    <script src="{{ asset('dashboard/tinymce/js/tinymce/tinymce.min.js') }}"></script>

    <script>
        tinymce.init({
            selector: 'textarea',
            plugins: 'lists, link, image, media',
            toolbar: 'h1 h2 alignleft aligncenter alignright alignjustify bold italic strikethrough blockquote bullist numlist backcolor | link image media | removeformat help',
            menubar: false,
            setup: (editor) => {
                // Apply the focus effect
                editor.on("init", () => {
                    editor.getContainer().style.transition =
                        "border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out";
                });
                editor.on("focus", () => {
                    (editor.getContainer().style.boxShadow = "0 0 0 .2rem rgba(0, 123, 255, .25)"),
                    (editor.getContainer().style.borderColor = "#80bdff");
                });
                editor.on("blur", () => {
                    (editor.getContainer().style.boxShadow = ""),
                    (editor.getContainer().style.borderColor = "");
                });
            },
        });
    </script>

    <script>
        let table = new DataTable('#table-pengajuan', {
            responsive: true,
            sort: true,
            processing: true,
            ajax: "{{ url('/pengajuan/data') }}",
            columns: [{
                data: 'DT_RowIndex',
                name: 'DT_RowIndex',
                orderable: false,
                searchable: false
            }, {
                data: 'aju_tgl',
                name: 'Tanggal'
            }, {
                data: 'aju_jenis_data',
                name: 'Jenis Pengajuan'
            }, {
                data: 'item',
                name: 'Item'
            }, {
                data: 'aju_jumlah',
                name: 'Jumlah'
            }, {
                data: 'aju_user',
                name: 'Diajukan Oleh'
            }, {
                data: 'status',
                name: 'Status'
            }, {
                data: 'aksi',
                name: 'Aksi'
            }]
        });

        function setujui_ceklis(id) {
            Swal.fire({
                title: 'Yakin Penyetujui Pengajuan Ini?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, Setujui Pengajuan!'
            }).then((result) => {
                if (result.isConfirmed) {
                    var ajax_type = 'POST';
                    var ajax_url = '/approve_pengajuan/' + id;

                    $.ajax({
                        type: ajax_type,
                        url: ajax_url,
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        processData: false,
                        contentType: false,
                        success: function(response) {
                            toastr.success(response.message);
                            table.ajax.reload();
                        },
                        error: function(response) {
                            $.each(response.responseJSON.errors, function(key, value) {
                                $('.error').append(
                                    '<div class="alert alert-danger alert-dismissible fade show" role="alert">' +
                                    value +
                                    '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>'
                                );
                            });
                        }
                    });
                } else {
                    table.ajax.reload();
                }
            });
        }

        function tolak_ceklis(id) {
            Swal.fire({
                title: 'Yakin Menolak Pengajuan Ini?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, Tolak Pengajuan!'
            }).then((result) => {
                if (result.isConfirmed) {
                    var ajax_type = 'POST';
                    var ajax_url = '/tolak_pengajuan/' + id;

                    $.ajax({
                        type: ajax_type,
                        url: ajax_url,
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        processData: false,
                        contentType: false,
                        success: function(response) {
                            toastr.success(response.message);
                            table.ajax.reload();
                        },
                        error: function(response) {
                            $.each(response.responseJSON.errors, function(key, value) {
                                $('.error').append(
                                    '<div class="alert alert-danger alert-dismissible fade show" role="alert">' +
                                    value +
                                    '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>'
                                );
                            });
                        }
                    });
                } else {
                    table.ajax.reload();
                }
            });
        }

        function tambah() {
            $("#frm_pengajuan")[0].reset();
            $('#modal_pengajuan').modal({
                show: true,
                keyboard: false,
                backdrop: 'static'
            });
            $('#save_pengajuan').click(function(e) {
                e.preventDefault();
                tinymce.triggerSave();
                $id = '';
                simpan($id);
            })
        }

        function resetForm() {
            $("#frm_pengajuan")[0].reset();
        }

        function simpan(id) {
            if (id == '') {
                var ajax_type = 'POST';
                var ajax_url = 'api/pengajuan';
            } else {
                var ajax_type = 'POST';
                var ajax_url = '/pengajuan/' + id;
            }

            var aju_user_id = $('#aju_user_id').val();
            var aju_user = $('#aju_user').val();
            var aju_jenis_data = $('#aju_jenis_data').val();
            var aju_item = $('#aju_item').val();
            var aju_tgl = $('#aju_tgl').val();
            var aju_jumlah = $('#aju_jumlah').val();

            var form_data = new FormData();
            form_data.append("aju_user_id", aju_user_id);
            form_data.append("aju_user", aju_user);
            form_data.append("aju_jenis_data", aju_jenis_data);
            form_data.append("aju_item", aju_item);
            form_data.append("aju_tgl", aju_tgl);
            form_data.append("aju_jumlah", aju_jumlah);

            $.ajax({
                type: ajax_type,
                url: ajax_url,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                processData: false,
                contentType: false,
                data: form_data,
                success: function(response) {
                    toastr.success(response.message);
                    table.ajax.reload();
                    resetForm();
                    $("#modal_pengajuan").modal("hide");
                },
                error: function(response) {
                    $.each(response.responseJSON.error, function(key, value) {
                        $('.error').append(
                            '<div class="alert alert-danger alert-dismissible fade show" role="alert">' +
                            value +
                            '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>'
                        );
                    });
                }
            });
        }

        function edit(id) {
            $.ajax({
                url: '/pengajuan/' + id + '/edit',
                type: 'GET',
                success: function(response) {
                    $("#aju_user_id").val(response.result.aju_user_id);
                    $("#aju_user").val(response.result.aju_user);
                    $("#aju_jenis_data").val(response.result.aju_jenis_data);
                    $("#aju_tgl").val(response.result.aju_tgl);
                    $("#aju_jumlah").val(response.result.aju_jumlah);
                    tinymce.get("aju_item").setContent(response.result.aju_item);

                    $('#modal_pengajuan').modal({
                        show: true,
                        keyboard: false,
                        backdrop: 'static'
                    });
                    $('#save_pengajuan').click(function(e) {
                        e.preventDefault();
                        tinymce.triggerSave();
                        $id = id;
                        simpan($id);
                    })
                }
            });
        }

        function detele(id) {
            Swal.fire({
                title: 'Yakin hapus Data Pengajuan?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, hapus data!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: '/pengajuan/' + id,
                        type: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(response) {
                            toastr.success(response.message);
                            table.ajax.reload();
                        }
                    });
                }
            });
        }
    </script>
@endsection
