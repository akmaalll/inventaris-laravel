<?php

namespace App\Http\Controllers;

use App\Helpers\Custom;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Database\QueryException;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;
use App\ExportsTabungan\Tabungan\Excel\Export;
use App\ImportsRealisasiAnggaran\RealisasiAnggaran\Excel\Import;
use App\Models\RealisasiAnggaran;

class RealisasiAnggaranController extends Controller
{
    public function index()
    {
        if (request()->ajax()) {
            $result = RealisasiAnggaran::orderBy('id', 'ASC');
            return DataTables::eloquent($result)
                ->addIndexColumn()
                ->addColumn('act', function ($data) {
                    return view('pages.realisasianggaran.modal.action', compact('data'));
                })
                ->rawColumns(['act'])->make(true);
        }
        return view('pages.realisasianggaran.index');
    }

    public function store(Request $request)
    {
        $validate = [
            'kode'      => 'required',
            'deskripsi' => 'required',
            'anggaran'  => 'required',
            'realisasi' => 'required',
            'bulan'     => 'required',
            'tahun'     => 'required'



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
            $realisasi_anggarans = RealisasiAnggaran::create([
                'kode'      => $request->kode,
                'deskripsi' => $request->deskripsi,
                'anggaran'  => $request->anggaran,
                'realisasi' => $request->realisasi,
                'bulan'     => $request->bulan,
                'tahun'     => $request->tahun
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
        $data = RealisasiAnggaran::find($id);
        return response()->json(['status' => 'success', 'messages' => 'Load Data', 'data' => $data], 201);
    }


    //update
    public function update(Request $request, $id)
    {
        $validate = [
            'kode'      => 'required',
            'deskripsi' => 'required',
            'anggaran'  => 'required',
            'realisasi' => 'required',
            'selisih'   => 'required',
            'bulan'     => 'required',
            'tahun'     => 'required'

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
                'kode'      => $request->kode,
                'deskripsi' => $request->deskripsi,
                'anggaran'  => $request->anggaran,
                'realisasi' => $request->realisasi,
                'selisih'   => $request->selisih,
                'bulan'     => $request->bulan,
                'tahun'     => $request->tahun
            ];
            $realisasi_anggarans = RealisasiAnggaran::find($id)->update($data);
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
        $data = RealisasiAnggaran::find($id);
        return response()->json(['status' => 'success', 'messages' => 'Load Data', 'data' => $data], 201);
    }

    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $realisasi_anggarans = RealisasiAnggaran::find($id)->delete();
            return response()->json(['status' => 'success', 'messages' => 'Data Telah Dihapus'], 201);
        } catch (QueryException $e) {
            DB::rollBack();
            return response()->json(['status' => 'error', 'messages' => $e->errorInfo], 500);
        } finally {
            DB::commit();
        }
    }


    public function export()
    {
        $realisasi_anggarans = RealisasiAnggaran::all();
        if (count($realisasi_anggarans) != 0) {
            return Excel::download(new Export, 'Tabungan-' . date('d-m-Y') . '.xlsx');
        }
        toastr()->error('Tidak ada Barang');
        return redirect()->back()->withInput();
    }

    public function import()
    {
        try {
            Excel::import(new Import, request()->file('file'));
            toastr()->success('Import Data Berhasil');
            return redirect()->back();
        } catch (QueryException $e) {
            toastr()->error('Gagal, Pastikan Import Data anda sesuai');
            return redirect()->back();
        }
    }
}
