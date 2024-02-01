<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JualModel extends Model
{
    use HasFactory;
    protected $table = 'jual';
    protected $primaryKey = 'id_jual';
    protected $fillable = ['id_barang', 'tanggal_jual', 'jumlah_jual', 'harga_jual_satuan', 'total_harga_jual'];
}
