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
        if ($validated):
            if (isset($request->id_barang)):

                // Proses update
                $perintah = BarangModel::where('id_barang', $request->id_barang)->update($validated);
                if ($perintah):
                    $pesan = [
                        'status' => 'success',
                        'pesan' => 'Datamu berhasil diperbarui'
                    ];
                else:
                    $pesan = [
                        'status' => 'error',
                        'pesan' => 'Datamu gagal diperbarui'
                    ];
                endif;

            else:

                // Proses tambah data baru
                $perintah = BarangModel::create($validated);
                if ($perintah):
                    $pesan = [
                        'status' => 'success',
                        'pesan' => 'Data barang baru berhasil ditambahkan'
                    ];
                else:
                    $pesan = [
                        'status' => 'error',
                        'pesan' => 'Data barang baru gagal ditambahkan'
                    ];
                endif;
            endif;

        else:
            $pesan = [
                'status' => 'error',
                'pesan' => 'Proses validasi gagal'
            ];
        endif;
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
        $aksiHapus = BarangModel::where('id_barang', $request->id_barang)->delete();
        if ($aksiHapus):
            $pesan = [
                'status' => 'success',
                'pesan' => 'Data barang berhasil dihapus'
            ];
        else:
            $pesan = [
                'status' => 'error',
                'pesan' => 'Data barang gagal dihapus'
            ];
        endif;
        return response()->json($pesan);
    }

    public function dataBarang(Request $request)
    {
        /**
         * Method ini akan menjadi endpoint API untuk datatable serverside.
         */
        if ($request->ajax()):
            $data = $this->barangModel->with('stok')->get();
            return DataTables::of($data)->toJson();
        endif;
    }
}
