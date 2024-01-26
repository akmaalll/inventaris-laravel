<?php

namespace App\Http\Controllers;

use App\Helpers\Custom;
use App\Models\DataPengajar;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class DataPengajarController extends Controller
{
    public function index()
    {
        if (request()->ajax()) {
            $result = DataPengajar::orderBy('nama', 'ASC');
            return DataTables::eloquent($result)
                ->addIndexColumn()
                ->addColumn('act', function ($data) {
                    return view('pages.data_pengajar.modal.action', compact('data'));
                })
                ->rawColumns(['act'])->make(true);
        }
        return view('pages.data_pengajar.index');
    }

    public function store(Request $request)
    {
        $validate = [
            'no_ktp'        => 'nullable',
            'nama'          => 'required',
            'jenis_kelamin' => 'required',
            'usia'          => 'required',
            'alamat'        => 'nullable',
            'jabatan'       => 'required'
        ];
        $validation = Validator::make($request->all(), $validate, Custom::messages());
        if ($validation->fails()) {
            return response()->json([
                'status'    => 'warning',
                'messages'  => $validation->errors()->first()
            ], 422);
        }

        DB::beginTransaction();
        try {
            $dataPengajar = DataPengajar::create([
                'no_ktp'        => $request->no_ktp,
                'nama'          => $request->nama,
                'jenis_kelamin' => $request->jenis_kelamin,
                'usia'          => $request->usia,
                'alamat'        => $request->alamat,
                'jabatan'        => $request->jabatan
            ]);

            return response()->json(['status' => 'success', 'messages' => 'Data Success Ditambahkan'], 201);
        } catch (QueryException $e) {
            DB::rollBack();
            return response()->json(['status' => 'error', 'messages' => $e->errorInfo], 500);
        } finally {
            DB::commit();
        }
    }

    public function edit($id)
    {
        $data = DataPengajar::find($id);
        return response()->json(['status' => 'success', 'messages' => 'Load Data', 'data' => $data], 201);
    }

    public function update(Request $request, $id)
    {
        $validate = [
            'no_ktp'        => 'nullable',
            'nama'          => 'required',
            'jenis_kelamin' => 'required',
            'usia'          => 'required',
            'alamat'        => 'nullable',
            'jabatan'       => 'required'
        ];

        $validation = Validator::make($request->all(), $validate, Custom::messages());
        if ($validation->fails()) {
            return response()->json([
                'status'    => 'warning',
                'messages'  => $validation->errors()->first()
            ], 422);
        }

        DB::beginTransaction();
        try {
            $data = [
                'no_ktp'        => $request->no_ktp,
                'nama'          => $request->nama,
                'jenis_kelamin' => $request->jenis_kelamin,
                'usia'          => $request->usia,
                'alamat'        => $request->alamat,
                'jabatan'        => $request->jabatan
            ];
            $dataPengajar = DataPengajar::find($id)->update($data);
            return response()->json(['status' => 'success', 'messages' => 'Data Berhasil Di Update'], 201);
        } catch (QueryException $e) {
            DB::rollBack();
            return response()->json(['status' => 'error', 'messages' => $e->errorInfo], 500);
        } finally {
            DB::commit();
        }
    }

    public function show($id)
    {
        $data = DataPengajar::find($id);
        return response()->json(['status' => 'success', 'messages' => 'Load Data', 'data' => $data], 201);
    }

    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $dataPengajar = DataPengajar::find($id)->delete();
            return response()->json(['status' => 'success', 'messages' => 'Data Telah Dihapus'], 201);
        } catch (QueryException $e) {
            DB::rollBack();
            return response()->json(['status' => 'error', 'messages' => $e->errorInfo], 500);
        } finally {
            DB::commit();
        }
    }
}
