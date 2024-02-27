@extends('template/template')
@section('title', 'Riwayat Pembelian Barang')

@section('content')
<div class="col-md-12">
    <div class="card">
        <div class="card-header">
            <btn class="btn btn-success btnBeliBarang" data-bs-title="Tambah Stok Barang" data-bs-target='#modalForm'
                data-bs-toggle="modal" attr-href="{{route('beli.tambah')}}"><i class="bi bi-plus"></i>Tambah Stok Barang
            </btn>
        </div>
        <div class="card-body">
            <table class="table DataTable table-hovered table-bordered">
                <thead>
                    <tr>
                        <th>Kode barang</th>
                        <th>Nama barang</th>
                        <th>Tanggal</th>
                        <th>Jumlah</th>
                        <th>Harga Satuan</th>
                        <th>Total</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
        </div>
        <div class="card-footer">

        </div>
    </div>

    <!-- Bagian Modal -->
    <div class="modal fade" id="modalForm" data-bs-backdrop="static" data-bs-keyboards="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel"></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="close">
                </div>
                <div class="modal-body">

                </div>
                <div class="modal-footer">
                    <btn class="btn btn-success btnSimpanBarang"><i class="bi bi-save2"></i> Simpan</btn>
                    <btn class="btn btn-default" data-bs-dismiss="modal"> Batal</btn>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('footer')
<script type="module">
    // const barangModal = document.querySelector('#modalForm');
    const modalInstance = document.querySelector('#modalForm');
    const modal = bootstrap.Modal.getOrCreateInstance(modalInstance);

    var table = $('.DataTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{!!route('beli.data')!!}",
        columns: [{
            render: function (data, type, row) {
                return row.barang.kode_barang;
            }
        },
        {
            render: function (data, type, row) {
                return row.barang.nama_barang;
            }
        },
        {
            data: 'tanggal_beli',
            name: 'tanggal_beli',
        },
        {
            data: 'jumlah_beli',
            name: 'jumlah_beli',
        },
        {
            data: 'harga_beli_satuan',
            name: 'harga_beli_satuan',
        },
        {
            data: 'total_harga_beli',
            name: 'total_harga_beli',
        },
        {
            render: function (data, type, row) {
                return "<btn class='btn btn-primary editBtn' data-bs-toggle='modal' data-bs-target='#modalForm' attr-href='{!!url('/barang/edit/" + row.id_barang + "')!!}'><i class='bi bi-pencil-square'></i> Edit</btn> <btn class='btn btn-danger btnHapusBarang' attr-id='" + row.id_barang + "' ><i class='bi bi-trash3'></i> Hapus</btn>";
            }
        },
        ]
    });

    // Hapus
    $('.DataTable tbody').on('click', '.btnHapusBarang', function (hapusEvent) {
        let idBarang = $(this).closest('.btnHapusBarang').attr('attr-id');

        Swal.fire({
            title: "Apakah kamu yakin?",
            text: "Data ini tidak bisa dikembalikan lho!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Ya",
            cancelButtonText: 'Batal'

        }).then((result) => {
            if (result.isConfirmed) {

                let hapusData = {
                    'id_barang': idBarang,
                    '_token': "{{ csrf_token() }}"
                };

                axios.post('{{ url("barang/hapus") }}', hapusData)
                    .then(response => {
                        if (response.data.status == 'success') {

                            modal.hide();
                            table.ajax.reload();

                            Swal.fire({
                                title: 'Berhasil!',
                                text: response.data.pesan,
                                icon: 'success'
                            });
                        }
                        Swal.fire({
                            title: "Terhapus!",
                            text: "Datamu sudah dihapus",
                            icon: "success"
                        });

                    });
            };
        });
    });

    // Edit
    $('.DataTable tbody').on('click', '.editBtn', function (event) {
        changeHTML('#modalForm', '.modal-title', 'Edit Data Barang');
        let modalForm = document.getElementById('modalForm');
        modalForm.addEventListener('shown.bs.modal', function (event) {
            event.preventDefault();
            event.stopImmediatePropagation();
            let link = event.relatedTarget.getAttribute('attr-href');

            axios.get(link).then(response => {
                $('#modalForm .modal-body').html(response.data);
            });

            $('.btnSimpanBarang').on('click', function (editSimpanEvent) {
                editSimpanEvent.preventDefault();
                editSimpanEvent.stopImmediatePropagation();

                let dataEdit = {
                    'id_barang': $('#idBarang').val(),
                    'nama_barang': $('#namaBarang').val(),
                    'kode_barang': $('#kodeBarang').val(),
                    'harga': $('#hargaBarang').val(),
                    '_token': "{{ csrf_token() }}"
                };

                axios.post('{{ url("barang/simpan") }}', dataEdit)
                    .then(response => {
                        if (response.data.status == 'success') {

                            modal.hide();
                            table.ajax.reload();

                            Swal.fire({
                                title: 'Berhasil!',
                                text: response.data.pesan,
                                icon: 'success'
                            });
                        } else {
                            Swal.fire({
                                title: 'Maaf, kamu gagal',
                                text: response.data.pesan,
                                icon: 'error'
                            });
                        };
                    });
            });

        });

        modalForm.addEventListener('hidden.bs.modal', function (closeEvent) {
            closeEvent.preventDefault();
            closeEvent.stopImmediatePropagation();

            $('#modalForm').removeData();
        });
    });

    // Tambah
    $('.btnTambahBarang').on('click', function (a) {
        changeHTML('#modalForm', '.modal-title', 'Tambah Data Barang');
        const modalForm = document.getElementById('modalForm');

        modalForm.addEventListener('shown.bs.modal', function (eventTambah) {
            eventTambah.preventDefault();
            eventTambah.stopImmediatePropagation();
            const link = eventTambah.relatedTarget.getAttribute('attr-href');

            axios.get(link).then(response => {
                $('#modalForm .modal-body').html(response.data);
            });

            $('.btnSimpanBarang').on('click', function (simpanEvent) {
                simpanEvent.preventDefault();
                simpanEvent.stopImmediatePropagation();

                let data = {
                    'nama_barang': $('#namaBarang').val(),
                    'kode_barang': $('#kodeBarang').val(),
                    'harga': $('#hargaBarang').val(),
                    '_token': "{{csrf_token()}}"
                }

                if (data.kode_barang !== '' && data.nama_barang !== '' && data.harga !== '') {
                    axios.post('{{url("/barang/simpan")}}', data)
                        .then(response => {
                            if (resp.data.status == 'success') {

                                modal.hide(); // Close the modal
                                table.ajax.reload(); // Reload the DataTable

                                // Tampilkan popup berhasil
                                Swal.fire({
                                    title: "Berhasil!",
                                    text: resp.data.pesan,
                                    icon: "success"
                                });
                            } else {
                                // Tampilkan popup gagal
                                Swal.fire({
                                    title: "Maaf, kamu gagal",
                                    text: resp.data.pesan,
                                    icon: "error"
                                });
                            }
                        });
                } else {
                    Swal.fire({
                        'title': 'Maaf, kamu gagal :(',
                        'text': 'Form tidak boleh kosong ya',
                        'icon': 'error'
                    });
                }

            });
        });
    });

</script>
@endsection