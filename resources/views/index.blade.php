@extends('main')

@section('isidashboard')
    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header">
                    {{-- <h5>Data Belanja</h5> --}}
                </div>
                <h2 class="text-center my-5">Selamat datang di Sistem Informasi Pengajuan Dana</h2>
                <div class="container">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row align-items-center">
                                        <div class="col-8">
                                            <h4 class="text-c-yellow">{{ $jlh_aju }}</h4>
                                            <h6 class="text-muted m-b-0">Jumlah Pengajuan</h6>
                                        </div>
                                        <div class="col-4 text-right">
                                            <i class="fas fa-file-invoice icon-bar-chart-2 f-28"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer bg-c-yellow"></div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row align-items-center">
                                        <div class="col-8">
                                            <h4 class="text-c-green">{{ $jlh_aju_approve_direktur }}</h4>
                                            <h6 class="text-muted m-b-0">Jumlah Disetujui Direktur</h6>
                                        </div>
                                        <div class="col-4 text-right">
                                            <i class="fas fa-check-square icon-bar-chart-2 f-28"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer bg-c-blue"></div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row align-items-center">
                                        <div class="col-8">
                                            <h4 class="text-c-red">{{ $jlh_aju_approve_finance }}</h4>
                                            <h6 class="text-muted m-b-0">Jumlah Dicairkan Finance</h6>
                                        </div>
                                        <div class="col-4 text-right">
                                            <i class="fas fa-hand-holding-usd icon-bar-chart-2 f-28"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer bg-c-green"></div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row align-items-center">
                                        <div class="col-8">
                                            <h4 class="text-c-red">{{ $jlh_aju_tolak }}</h4>
                                            <h6 class="text-muted m-b-0">Jumlah Ditolak</h6>
                                        </div>
                                        <div class="col-4 text-right">
                                            <i class="fas fa-times-circle icon-bar-chart-2 f-28"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer bg-c-red"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Toastr -->
    <script src="{{ asset('dashboard/plugins/toastr/toastr.min.js') }}"></script>

    {{-- <script>
        let table = new DataTable('#table-belanja', {
            responsive: true,
            sort: true,
            processing: true,
            ajax: "{{ url('/belanja') }}",
            columnDefs: [{
                targets: 0,
                className: 'dt-body-center'
            }, {
                targets: 1,
                className: 'dt-body-center'
            }, {
                targets: 3,
                className: 'dt-body-right'
            }, {
                targets: 4,
                className: 'dt-body-center'
            }],
            columns: [{
                data: 'DT_RowIndex',
                name: 'DT_RowIndex',
                orderable: false,
                searchable: false
            }, {
                data: 'tanggal',
                name: 'Tanggal Transaksi'
            }, {
                data: 'kode_belanja',
                name: 'Invoice Transaksi',
                searchable: true
            }, {
                data: 'total',
                name: 'Total'
            }, {
                data: 'voucher',
                name: 'Voucher'
            }, {
                data: 'aksi',
                name: 'Aksi'
            }]
        });

        function tambah() {
            $("#frm_belanja").trigger("reset");
            $("#tampil").html('');
            $("#tampil_voucher").html('');
            $("#hasil_voucher").html('');
            localStorage.removeItem('belanja');
            $('#modal_belanja').modal({
                show: true,
                keyboard: false,
                backdrop: 'static'
            });
            $('#save_belanja').click(function(e) {
                e.preventDefault();
                $id = '';
                simpan($id);
            })
        }

        function add() {
            var item = document.getElementById("item");
            var harga = document.getElementById("harga");
            var tampung_array = JSON.parse(localStorage.getItem("belanja"));
            if (!tampung_array) {
                var tampung_array = [];
            }
            tampung_array.push({
                item: item.value,
                harga: harga.value
            });
            item.value = "";
            harga.value = "";
            var data_array = JSON.stringify(tampung_array);
            console.log(data_array);
            localStorage.setItem("belanja", data_array);
            insert_array_to_list_belanja(data_array);
            show();
            show_voucher();
        }

        function insert_array_to_list_belanja(data) {
            $("#list_belanja").val(data);
        }

        function show() {
            var html = "";
            var tampung_array = JSON.parse(localStorage.getItem("belanja"));
            if (tampung_array) {
                let sum = 0;
                tampung_array.map((dt, i) => {
                    // console.log(dt);
                    html +=
                        "<ul class='list-group my-1'><li class='list-group-item d-flex justify-content-between align-items-start'><div class='me-auto'>" +
                        dt.item + ' Rp.' + dt.harga +
                        "</div><a class='d-flex justify-content-end' style='margin-right: 8px;' onclick='remove(" +
                        i +
                        ");' href='#'><span class='badge bg-danger rounded-pill'><i class='fas fa-trash'></i></span></a></li></ul>";

                    sum += parseInt(dt.harga);

                    var total = document.getElementById("total");
                    total.value = sum;
                });
            }
            var tampil = document.getElementById("tampil");
            tampil.innerHTML = html;
        }

        function show_voucher() {
            var tampil_voucher = document.getElementById("tampil_voucher");
            tampil_voucher.innerHTML =
                "<label for='voucher' class='form-label'>Voucher</label><div class='form-group'><a class='badge bg-success position-absolute end-0 mt-2' name='cek_voucher' id='cek_voucher' onclick='cek_voucher();'>Cek Voucher</a><input type='text' class='form-control' id='invoice' name='invoice' placeholder='Invoice Transaksi' required></div>";
        }

        function remove(prg) {
            let c = confirm("Hapus Belanja?");
            if (c) {
                var tampung_array = JSON.parse(localStorage.getItem("belanja"));
                if (tampung_array) {
                    tampung_array.splice(prg, 1);
                    localStorage.setItem("belanja", JSON.stringify(tampung_array));
                    insert_array_to_list_belanja(JSON.stringify(tampung_array));
                    show();
                }
            }
        }

        function cek_voucher() {
            var kode = document.getElementById('invoice').value;

            $.ajax({
                url: '/belanja/' + kode,
                type: 'GET',
                dataType: "json",
                success: function(response) {
                    console.log(response.result);
                    var hasil_voucher = document.getElementById('hasil_voucher');
                    if (response.result != null) {
                        hasil_voucher.innerHTML =
                            "<div class='alert alert-success alert-dismissible fade show' role='alert'>Voucher berhasil digunakan. Anda mendapat potongan harga Rp. 10.000</div>";

                        var total = document.getElementById("total");
                        if (total.value >= 10000) {
                            total.value = total.value - 10000;
                        } else {
                            total.value = 0;
                        }
                    } else {
                        hasil_voucher.innerHTML =
                            "<div class='alert alert-danger alert-dismissible fade show' role='alert'>Voucher tidak tersedia !!!</div>";
                    }
                }
            });
        }

        function simpan(id) {
            if (id == '') {
                var ajax_type = 'POST';
                var ajax_url = '/belanja';
            } else {
                var ajax_type = 'POST';
                var ajax_url = '/belanja_edit/' + id;
            }

            var total = $('#total').val();
            var invoice = $('#invoice').val();

            var form_data = new FormData();
            form_data.append("total", total);
            form_data.append("invoice", invoice);

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
                    console.log(response.data);
                    toastr.success(response.message);
                    table.ajax.reload();
                    $("#modal_belanja").modal("hide");
                },
                error: function(response) {
                    // console.log(response.responseJSON.errors);
                    $.each(response.responseJSON.errors, function(key, value) {
                        $('.error').append(
                            '<div class="alert alert-danger alert-dismissible fade show" role="alert">' +
                            value +
                            '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>'
                        );
                    });
                }
            });
        }

        function detele(id) {
            Swal.fire({
                title: 'Yakin hapus Data Belanja?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, hapus data!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: '/belanja/' + id,
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
    </script> --}}
@endsection
