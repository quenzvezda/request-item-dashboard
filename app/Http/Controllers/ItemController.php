<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    public function getItem(Request $request)
    {
        $term = $request->input('term');
        $barang = Item::where('nama_barang', 'LIKE', '%' . $term . '%')
            ->orWhere('kode_barang', 'LIKE', '%' . $term . '%')
            ->get();
        return response()->json($barang);
    }
}
