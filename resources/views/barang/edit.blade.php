<div class="row">
    <div class="col-lg-12">
        <div class="form-group">
            <label>Kode Barang</label>
            <input type="hidden" name="id_barang" id="idBarang" value="{{$barangDetil->id_barang}}">
            <input class="form-control" type="text" name="kode_barang" id="kodeBarang"
                value="{{$barangDetil->kode_barang}}" />
        </div>
        <div class="form-group">
            <div class="form-group">
                <label>Nama Barang</label>
                <input type="text" class="form-control" name="nama_barang" id="namaBarang"
                    value="{{$barangDetil->nama_barang}}" />
            </div>
        </div>
        <div class="form-group">
            <label>Harga Barang</label>
            <input type="number" class="form-control" name="harga" id="hargaBarang" value="{{$barangDetil->harga}}" />
        </div>
    </div>
</div>