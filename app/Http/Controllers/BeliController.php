<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BeliModel;

class BeliController extends Controller
{
    protected $id_beli;
    protected $id_barang;
    protected $tanggal_beli;
    protected $jumlah_beli;
    protected $harga_beli_satuan;
    protected $total_harga_beli;
    protected $beliModel;

    public function __construct()
    {
        $this->beliModel = new BeliModel();
    }

    public function index()
    {
        /* Menampilkan daftar barang yang ada pada table barang dan dikonversi ke dalam format table menggunakan template yang disediakan oleh data table. */
        $data = [
            'beliList' => $this->beliModel::all()
        ];

        /* Tampilkan $data ke dalam view file beli/list.blade.php */
        return view('beli.list', $data);
    }

    public function beli()
    {
        /* Method ini akan menampilkan form HTML untuk beli data barang. Data form akan dikirim ke Controller simpan */
    }
    public function simpan(Request $request)
    {
        /* Method ini akan menyimpan data yang dikirim dari method beli */
    }
    public function laporan(Request $request)
    {
        /*  */
    }
}
