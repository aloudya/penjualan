<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JualModel;

class JualController extends Controller
{
    protected $id_jual;
    protected $id_barang;
    protected $tanggal_jual;
    protected $jumlah_jual;
    protected $harga_jual_satuan;
    protected $total_harga_jual;
    protected $jualModel;

    public function __construct()
    {
        $this->jualModel = new JualModel();
    }

    public function index()
    {
        /* Menampilkan daftar barang yang ada pada table barang dan dikonversi ke dalam format table menggunakan template yang disediakan oleh data table. */
        $data = [
            'jualList' => $this->jualModel::all()
        ];

        /* Tampilkan $data ke dalam view file jual/list.blade.php */
        return view('jual.list', $data);
    }

    public function jual()
    {
        /* Method ini akan menampilkan form HTML untuk jual data barang. Data form akan dikirim ke Controller simpan */
    }
    public function simpan(Request $request)
    {
        /* Method ini akan menyimpan data yang dikirim dari method jual */
    }
    public function laporan(Request $request)
    {
        /*  */
    }
}
