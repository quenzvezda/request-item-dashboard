<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    public function getEmployeeData($nik)
    {
        $employee = Employee::where('nik', $nik)->first();
        return response()->json([
            'nama' => $employee->nama,
            'departemen' => $employee->department->nama_departmen
        ]);
    }
}
