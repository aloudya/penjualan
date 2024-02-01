<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BeliModel extends Model
{
    use HasFactory;
    protected $table = 'beli';
    protected $primaryKey = 'id_beli';
    protected $fillable = ['id_barang', 'tanggal_beli', 'jumlah_beli', 'harga_beli_satuan', 'total_harga_beli'];
}
