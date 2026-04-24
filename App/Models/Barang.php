<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    protected $table = 'barang';
    protected $primaryKey = 'kode_barang';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;        // ← tambahkan baris ini

    protected $fillable = [
        'kode_barang',
        'nama_barang',
        'harga_barang',
    ];

    public function transaksis()
    {
        return $this->hasMany(Transaksi::class, 'kode_barang', 'kode_barang');
    }
}