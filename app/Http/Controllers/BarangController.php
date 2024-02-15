<?php

namespace App\Http\Controllers;

use App\Http\Requests\BarangStoreRequest;
use Illuminate\Http\Request;
use App\Models\BarangModel;
use Yajra\DataTables\DataTables;
use Validator;

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
    public function simpan(BarangStoreRequest $request)
    {
        /* Method ini akan menyimpan data yang dikirim dari method tambah */
        $validated = $request->validated();
        if ($validated) {
            /**if (isset($request->id_barang)) {
                // Mengupdate data
                $perintah = BarangModel::where('id_barang', $request->id)->update($validated);
                if ($perintah) {
                    $pesan = [
                        'status' => 'success',
                        'pesan' => 'Data berhasil diupdate!'
                    ];
                } else {
                    $pesan = [
                        'status' => 'failed',
                        'pesan' => 'Data gagal diupdate!'
                    ];
                }
            } else {
                $pesan = [
                    'status' => 'success',
                    'pesan' => 'Data gagal ditambahkan, periksa form yang diinput'
                ];
            };
             */

            // Validate untuk menambah data barang
            $perintah = BarangModel::create($validated);

            if ($perintah) {
                $pesan = [
                    'status' => 'success',
                    'pesan' => 'Data berhasil dibuat!'
                ];
            } else {
                $pesan = [
                    'status' => 'failed',
                    'pesan' => 'Data gagal dibuat!'
                ];
            }
        } else {
            $pesan = [
                'status' => 'success',
                'pesan' => 'Data gagal ditambahkan, periksa form yang diinput'
            ];
        }
        return response()->json($pesan);
    }
    public function update(Request $request)
    {
        /**
         * Method ini akan menampilkan form update/ubah data
         * yang akan dikirim ke method simpan
         */
        $data = [
            'barangDetil' => BarangModel::where('id_barang', $request->id_barang)->first()
        ];
        return view('barang.edit', $data);
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
