@extends('main')

@section('isidashboard')
    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header">
                    <h5>Table User</h5>
                </div>
                <div class="row">
                    <div class="col-md-2 col-xs-12 ml-3 mt-3">
                        <div class="form-group">
                            <a href="#" onclick="tambah()" class="btn btn-success btn-block tambah"><i
                                    class="fa fa-plus"></i>
                                Tambah</a>
                        </div>
                    </div>
                </div>
                <div class="card-body table-border-style">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover display" id="table-user" width="100%">
                            <thead>
                                <tr>
                                    <th class="text-center">No</th>
                                    <th class="text-center">NIP</th>
                                    <th class="text-center">Nama</th>
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
    <div id="modal_user" class="modal fade" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal_userLabel">Data user</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                </div>
                <div class="error"></div>
                <div class="modal-body">
                    <form enctype="multipart/form-data" id="frm_user">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group mb-3">
                                    <label class="floating-label" for="nip">NIP</label>
                                    <input type="number" class="form-control" id="nip" name="nip" required>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group mb-3">
                                    <label class="floating-label" for="name">Nama</label>
                                    <input type="text" class="form-control" id="name" name="name" required>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group mb-3">
                                    <label class="floating-label" for="email">Email</label>
                                    <input type="email" class="form-control" id="email" name="email" required>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group mb-3">
                                    <label class="floating-label" for="password">Password</label>
                                    <input type="password" class="form-control" id="password" name="password" required>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label for="status">Status</label>
                                    <select class="form-control" id="status" name="status" onkeypress="myKeyPress(e)"
                                        style="width:100%;" required>
                                        <option value="0" selected>==Pilih Status==</option>
                                        <option value="Direktur">Direktur</option>
                                        <option value="Finance">Finance</option>
                                        <option value="Staff">Staff</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn  btn-danger" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn  btn-success" id="save_user">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Toastr -->
    <script src="{{ asset('dashboard/plugins/toastr/toastr.min.js') }}"></script>

    <script>
        let table = new DataTable('#table-user', {
            responsive: true,
            sort: true,
            processing: true,
            ajax: "{{ url('api/user') }}",
            columns: [{
                data: 'DT_RowIndex',
                name: 'DT_RowIndex',
                orderable: false,
                searchable: false
            }, {
                data: 'nip',
                name: 'NIP'
            }, {
                data: 'name',
                name: 'Nama'
            }, {
                data: 'status',
                name: 'Status'
            }, {
                data: 'aksi',
                name: 'Aksi'
            }]
        });

        function tambah() {
            $("#frm_user")[0].reset();
            $('#modal_user').modal({
                show: true,
                keyboard: false,
                backdrop: 'static'
            });
            $('#save_user').click(function(e) {
                e.preventDefault();
                $id = '';
                simpan($id);
            })
        }

        function resetForm() {
            $("#frm_user")[0].reset();
        }

        function simpan(id) {
            if (id == '') {
                var ajax_type = 'POST';
                var ajax_url = 'api/user';
            } else {
                var ajax_type = 'POST';
                var ajax_url = '/user/' + id;
            }

            var nip = $('#nip').val();
            var name = $('#name').val();
            var email = $('#email').val();
            var password = $('#password').val();
            var status = $('#status').val();

            var form_data = new FormData();
            form_data.append("nip", nip);
            form_data.append("name", name);
            form_data.append("email", email);
            form_data.append("password", password);
            form_data.append("status", status);

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
                    $("#modal_user").modal("hide");
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
                url: '/user/' + id + '/edit',
                type: 'GET',
                success: function(response) {
                    $("#nip").val(response.result.nip);
                    $("#name").val(response.result.name);
                    $("#email").val(response.result.email);
                    $("#status").val(response.result.status);

                    $('#modal_user').modal({
                        show: true,
                        keyboard: false,
                        backdrop: 'static'
                    });
                    $('#save_user').click(function(e) {
                        e.preventDefault();
                        $id = id;
                        simpan($id);
                    })
                }
            });
        }

        function detele(id) {
            Swal.fire({
                title: 'Yakin hapus Data user?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, hapus data!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: '/user/' + id,
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
