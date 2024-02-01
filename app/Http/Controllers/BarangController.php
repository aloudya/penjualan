<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BarangModel;
use Yajra\DataTables\DataTables;

class BarangController extends Controller
{
    protected $id_barang;
    protected $nama_barang;
    protected $kode_barang;
    protected $harga;
    protected $barangModel;

    public function __construct()
    {
        $this->barangModel = new BarangModel();
    }

    public function index()
    {
        /** 
         * Menampilkan daftar barang yang ada pada table barang dan dikonversi ke dalam format table menggunakan template yang disediakan oleh data table.
         * Menampilkan data barang dari database menggunakan datatables serverside.
         * endpoint untuk API data barang ada pada function/method dataBarang()
         * 
         * 
         */

        return view('barang.index');
    }

    public function tambah()
    {
        /**
         * Method ini akan menampilkan form HTML untuk input data barang. Data form akan dikirim ke Controller simpan
         * 
         */
        return view('barang.tambah');
    }
    public function simpan(Request $request)
    {
        /* Method ini akan menyimpan data yang dikirim dari method tambah */
    }
    public function update(Request $request)
    {
        /* Method ini hanya bisa diakses dengan HTTP Method GET */
    }
    public function delete(Request $request)
    {
        /* Method ini hanya bisa diakses dengan HTTP Method POST */
    }

    public function dataBarang(Request $request)
    {
        /**
         * Method ini akan menjadi endpoint API untuk datatable serverside.
         */
        if ($request->ajax()) :
            $data = $this->barangModel->with('stok')->get();
            return DataTables::of($data)->toJson();
        endif;
    }
}
