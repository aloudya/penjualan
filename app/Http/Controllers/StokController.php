<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\StokModel;

class StokController extends Controller
{
    protected $id_stok;
    protected $id_barang;
    protected $jumlah;
    protected $stokModel;

    public function __construct()
    {
        $this->stokModel = new StokModel();
    }

    public function lihat()
    {
        /* Menampilkan daftar barang yang ada pada table barang dan dikonversi ke dalam format table menggunakan template yang disediakan oleh data table. */
        $data = [
            'stokList' => $this->stokModel::all()
        ];

        /* Tampilkan $data ke dalam view file jual/list.blade.php */
        return view('stok.list', $data);
    }
}
