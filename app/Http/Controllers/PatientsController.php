<?php

namespace App\Http\Controllers;

use App\Models\Patients;
use Illuminate\Http\Request;

class PatientsController extends Controller
{
    public function index(Request $request) {
        $query = Patients::query();
    
        // Filtering berdasarkan 'name'
        if ($request->has('name')) {
            $query->where('name', 'like', '%' . $request->input('name') . '%');
        }
    
        // Filtering berdasarkan 'address'
        if ($request->has('address')) {
            $query->where('address', 'like', '%' . $request->input('address') . '%');
        }
    
        // Filtering berdasarkan 'status'
        if ($request->has('status')) {
            $status = $request->input('status');
            if (in_array($status, ['positif', 'sembuh', 'meninggal'])) {
                $query->where('status', $status);
            }
        }

        
        // Sorting
        $sortBy = $request->input('sort_by');
        $sortOrder = $request->input('sort_order', 'asc');

        if (in_array($sortBy, ['tanggal_masuk', 'tanggal_keluar', 'address'])) {
            $query->orderBy($sortBy, $sortOrder);
        }

        $patients = $query->get();

        if ($patients->isEmpty()) {
            return response()->json(['message' => 'Tidak ada data yang dapat ditampilkan', 'data' => []], 200);
        }
    
        $patients = $query->get();
    
        if($patients->isEmpty()){
            return response()->json(['message' => 'Tidak ada data yang dapat ditampilkan', 'data' => []], 200);
        }
    
        $data = [
            'message' => 'Ini Adalah Keseluruhan data Patient',
            'data' => $patients
        ];
    
        return response()->json($data, 200);
    }

    public function store(Request $request) {

        $request->validate([
            'name' => 'required',
            'phone' => 'required',
            'address' => 'required',
            'status' => 'required',
            'in_date_at' => 'required',
            'out_date_at' => 'required',
        ]);

        $patient = Patients::create([
            'name' => $request->input('name'),
            'phone' => $request->input('phone'),
            'address' => $request->input('address'),
            'status' => $request->input('status'),
            'in_date_at' => $request->input('in_date_at'),
            'out_date_at' => $request->input('out_date_at'),
        ]);

        if ($patient) {
            return response()->json(['message' => 'Data Patient Berhasil Ditambah', 'data' => $patient], 201);
        } else {
            return response()->json(['message' => 'Data Patient Gagal Ditambah', 'data' => []], 400);
        }
        
    }

    public function show($id) {
        $patient = Patients::find($id);
    
        if (!$patient) {
            return response()->json(['error' => 'Data Patient Tidak Ditemukan'], 404);
        }
    
        return response()->json(['message' => 'Ini detail dari Data Patient Dengan ID: '. $id , 'data' => $patient], 200);
    }

    public function update(Request $request, $id) {
        $patient = Patients::find($id);
    
        if (!$patient) {
            return response()->json(
                ['error' => 'Data Patient Yang Ingin Diubah Tidak Ditemukan'], 404
            );
        }
    
        $request->validate([
            'name' => 'required',
            'phone' => 'required',
            'address' => 'required',
            'status' => 'required',
            'in_date_at' => 'required',
            'out_date_at' => 'required',
        ]);
    
        $patient->update([
            'name' => $request->input('name'),
            'phone' => $request->input('phone'),
            'address' => $request->input('address'),
            'status' => $request->input('status'),
            'in_date_at' => $request->input('in_date_at'),
            'out_date_at' => $request->input('out_date_at'),
        ]);
    
        return response()->json(
            ['message' => 'Patient dengan ID: '. $id . ' Berhasil Diubah',
             'data' => $patient], 200
        );
    }

    public function destroy($id) {
        $patient = Patients::find($id);
    
        if (!$patient) {
            return response()->json(['error' => 'Patient not found'], 404);
        }
    
        $patient->delete();
    
        if ($deleted) {
            return response()->json(['message' => 'Data Patient dengan ID: '. $id . 'Berhasil dihapus', 'data' => ['id' => $id]], 200);
        } else {
            return response()->json(['message' => 'Gagal untuk menghapus data Patient', 'data' => []], 400);
        }

    }
}
