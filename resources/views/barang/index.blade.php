@extends('template/template')
@section('title', 'Data Barang e-Grocery')

@section('content')
<div class="col-md-12">
    <div class="card">
        <div class="card-header">
            <btn class="btn btn-success btnTambahBarang" data-bs-target='#modalForm' data-bs-toggle="modal" attr-href="{{route('barang.tambah')}}"><i class="bi bi-plus"></i>Tambah</btn>
            Daftar barang
        </div>
        <div class="card-body">
            <table class="table DataTable table-hovered table-bordered">
                <thead>
                    <tr>
                        <th>Kode barang</th>
                        <th>Nama barang</th>
                        <th>Stok</th>
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
    <div class="modal fade" id="modalForm" data-bs-backdrop="static" data-bs-keyboards="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
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
    const barangModal = document.querySelector('#modalForm');
    const modal = bootstrap.Modal.getOrCreateInstance(barangModal);

    var table = $('.DataTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{!!route('barang.data')!!}",
        columns: [{
                data: 'kode_barang',
                name: 'kode_barang',
            },
            {
                data: 'nama_barang',
                name: 'nama_barang',
            },
            {
                render: function(data, type, row) {
                    return row.stok.jumlah;
                }
            },
            {
                render: function(data, type, row) {
                    return "<btn class='btn btn-primary editBtn' data-bs-toggle='modal' data-bs-target='#modalForm' attr-href='{!!url('/barang/edit/" + row.id_barang + "')!!}'><i class='bi bi-pencil-square'></i> Edit</btn> <btn class='btn btn-danger'><i class='bi bi-trash3'></i> Hapus</btn>";
                }
            },
        ]
    });

    // Edit
    $('.DataTable tbody').on('click', '.editBtn', function(event) {
        let modalForm = document.getElementById('modalForm');
        modalForm.addEventListener('shown.bs.modal', function(event) {
            event.preventDefault();
            event.stopImmediatePropagation();
            let link = event.relatedTarget.getAttribute('attr-href');

            axios.get(link).then(response => {
                $('#modalForm .modal-body').html(response.data);
                $('.modal-header .modal-title').html('Edit Data Barang');
            });

            $('.btnSimpanBarang').on('click', function(submitEvent) {
                submitEvent.stopImmediatePropagation();

                var data = {
                    'id_barang': $('#idBarang').val(),
                    'kode_barang': $('#kodeBarang').val(),
                    'nama_barang': $('#namaBarang').val(),
                    'harga': $('#hargaBarang').val(),
                    '_token': "{{csrf_token()}}"
                }

                if (data.kode_barang !== '' && data.nama_barang !== '' && data.harga !== '') {
                    axios.put('{{url("/barang/simpan")}}', data)
                        .then(resp => {
                            if (resp.data.status == 'success') {

                                modal.hide(); // Close the modal
                                table.ajax.reload(); // Reload the DataTable

                                // Tampilkan popup berhasil
                                Swal.fire({
                                    title: "Berhasil",
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
                    alert('Data tidak boleh kosong ya :(');
                }
            });
        });
    });

    // Tambah
    $('.btnTambahBarang').on('click', function(a) {
        changeHTML('#modalForm', '.modal-title', 'Tambah Data Barang');
        const modalForm = document.getElementById('modalForm');

        modalForm.addEventListener('shown.bs.modal', function(eventTambah) {
            eventTambah.preventDefault();
            eventTambah.stopImmediatePropagation();
            const link = eventTambah.relatedTarget.getAttribute('attr-href');

            axios.get(link).then(response => {
                $('#modalForm .modal-body').html(response.data);
            });

            $('.btnSimpanBarang').on('click', function(submitEvent) {
                submitEvent.stopImmediatePropagation();

                var data = {
                    'kode_barang': $('#kodeBarang').val(),
                    'nama_barang': $('#namaBarang').val(),
                    'harga': $('#hargaBarang').val(),
                    '_token': "{{csrf_token()}}"
                }

                if (data.kode_barang !== '' && data.nama_barang !== '' && data.harga !== '') {
                    axios.post('{{url("/barang/simpan")}}', data)
                        .then(resp => {
                            if (resp.data.status == 'success') {

                                modal.hide(); // Close the modal
                                table.ajax.reload(); // Reload the DataTable

                                // Tampilkan popup berhasil
                                Swal.fire({
                                    title: "Berhasil",
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
                    alert('Data tidak boleh kosong ya :(');
                }
            });
        });
    });
    /**
     * Contoh yang menggunakan ajax!
     $.ajax({
         url: link,
         method: 'GET',
         success: function(response) {
             $('#modalForm .modal-body').html(response);
         }
     });
     */

    function changeHTML(element, find, text) {
        $(element).find(find).html();
        return $(element).find(find).html(text).promise().done()
    }
</script>
@endsection