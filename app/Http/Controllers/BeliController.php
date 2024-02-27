<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BeliModel;
use App\Http\Requests\StoreRequestBeli;
use Yajra\DataTables\DataTables;
use Validator;

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

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = BeliModel::with('barang')->get();
            return DataTables::of($data)->toJson();

        }
        return view('beli.index');
    }

    public function tambah()
    {
        // Menampilkan form tambah
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
