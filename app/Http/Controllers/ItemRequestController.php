<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Item;
use App\Models\ItemRequest;
use App\Models\ItemRequestDetail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ItemRequestController extends Controller
{
    public function store(Request $request)
    {
        // Validasi data request
        $validator = Validator::make($request->all(), [
            'nik' => 'required|exists:employees,nik',
            'tanggalPermintaan' => 'required|date',
            'item_id' => 'required|array',
            'item_id.*' => 'required|exists:items,id',
            'kuantiti' => 'required|array',
            'kuantiti.*' => 'required|numeric|min:1',
            'keterangan' => 'array',
            'keterangan.*' => 'string|nullable'
        ]);

        // Jika validasi gagal, kembalikan error
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Mulai transaksi
        DB::beginTransaction();

        try {
            // Temukan Employee berdasarkan NIK
            $employee = Employee::where('nik', $request->nik)->firstOrFail();

            $superAdminUser = User::where('role', 'super_admin')->first();
            if (!$superAdminUser) {
                return response()->json(['message' => 'Super admin user not found'], 404);
            }

            // Buat ItemRequest baru
            $itemRequest = new ItemRequest([
                'employee_id' => $employee->id,
                'user_id' => $superAdminUser->id,
                'tanggal_permintaan' => $request->tanggalPermintaan,
                // Anda bisa menambahkan field lain jika perlu
            ]);
            $itemRequest->save();

            // Proses item request details dan kurangi stok barang
            foreach ($request->item_id as $index => $itemId) {
                $kuantiti = $request->kuantiti[$index];
                $keterangan = $request->keterangan[$index] ?? null; // Gunakan null sebagai default

                $item = Item::findOrFail($itemId);

                // Cek jika stok cukup
                if ($item->stok < $kuantiti) {
                    throw new \Exception("Stok barang tidak cukup untuk item dengan ID: $itemId");
                }

                // Kurangi stok barang
                $item->stok -= $kuantiti;
                $item->save();

                $itemRequestDetail = new ItemRequestDetail([
                    'item_request_id' => $itemRequest->id,
                    'item_id' => $itemId,
                    'kuantitas' => $kuantiti,
                    'keterangan' => $keterangan,
                ]);
                $itemRequestDetail->save();
            }

            DB::commit(); // Commit transaksi

            return response()->json(['message' => 'Permintaan barang berhasil disimpan'], 200);

        } catch (\Exception $e) {
            DB::rollback(); // Rollback transaksi jika terjadi error

            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $itemRequest = ItemRequest::with('employee')->get();
        return view('item_requests', ['itemRequest' => $itemRequest]);
    }

    public function show($id)
    {
        $itemRequest = ItemRequest::with(['employee', 'itemRequestDetails'])->findOrFail($id);
        return view('item_request_detail', ['itemRequest' => $itemRequest]);
    }
}
