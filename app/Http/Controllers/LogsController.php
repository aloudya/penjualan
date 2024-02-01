<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LogsModel;

class LogsController extends Controller
{
    protected $id_logs;
    protected $pesan;
    protected $tanggal;
    protected $logsModel;

    public function __construct()
    {
        $this->logsModel = new LogsModel();
    }

    public function lihat()
    {
        /* Menampilkan daftar barang yang ada pada table barang dan dikonversi ke dalam format table menggunakan template yang disediakan oleh data table. */
        $data = [
            'logsList' => $this->logsModel::all()
        ];

        /* Tampilkan $data ke dalam view file logs/list.blade.php */
        return view('logs.list', $data);
    }

    public function bersihkan()
    {
        /*  */
    }
}
