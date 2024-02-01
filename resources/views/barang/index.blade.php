@extends('template/template')
@section('title', 'Data Barang e-Grocery')

@section('content')
<div class="col-md-12">
    <div class="card">
        <div class="card-header">
            <btn class="btn btn-lg btn-success btnTambahBarang" data-bs-target='#modalForm' data-bs-toggle="modal" attr-href="{{route('barang.tambah')}}"><i class="bi bi-plus"></i>Tambah</btn>
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
    var table = $('.DataTable').DataTable({
        proceesing: true,
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
                    return "<btn class='btn btn-primary'><i class='bi bi-pencil-square'></i> Edit</btn> <btn class='btn btn-danger'><i class='bi bi-trash3'></i> Hapus</btn>";
                }
            },
        ]
    });

    $('.btnTambahBarang').on('click', function(a) {
        a.preventDefault();
        const modalForm = document.getElementById('modalForm');
        modalForm.addEventListener('shown.bs.modal', function(event) {
            event.preventDefault();
            event.stopImmediatePropagation();
            const link = event.relatedTarget.getAttribute('attr-href');
            const modalData = document.querySelector('#modalForm .modal-body');
            $(".modal-header .modal-title").html("Tambah data barang baru");

            axios.get(link).then(response => {
                $('#modalForm .modal-body').html(response.data);
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
        });
    });
</script>
@endsection