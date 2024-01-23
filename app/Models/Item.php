<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    protected $fillable = [
        'kode_barang',
        'nama_barang',
        'lokasi',
        'stok',
        'satuan',
        'status'
    ];

    public function itemRequestDetails()
    {
        return $this->hasMany(ItemRequestDetail::class);
    }
}
