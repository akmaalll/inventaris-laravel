<?php

namespace App\Http\Controllers;

use App\Helpers\Custom;
use App\ExportsKasKecil\KasKecil\Excel\Export;
use App\Models\KasKecil;
use App\ImportsKasKecil\KasKecil\Excel\Import;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class KasKecilController extends Controller
{

    public function index()
    {
        if (request()->ajax()) {
            $result = KasKecil::orderBy('tanggal_transaksi', 'ASC');
            return DataTables::eloquent($result)
                ->addIndexColumn()
                ->addColumn('act', function ($data) {
                    return view('pages.kaskecil.modal.action', compact('data'));
                })
                ->rawColumns(['act'])->make(true);
        }
        return view('pages.kaskecil.index');
    }


    public function store(Request $request)
    {
        $validate = [
            'tanggal_transaksi' => 'required',
            'kode'     => 'required',
            'nama_transaksi'   => 'required',
            'debet'            => 'required',
            'kredit'           => 'required',
            'saldo'            => 'nullable',


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
            $kas_kecils = KasKecil::create([
                'tanggal_transaksi'           => $request->tanggal_transaksi,
                'kode'                => $request->kode,
                'nama_transaksi'              => $request->nama_transaksi,
                'debet'                       => $request->debet,
                'kredit'                      => $request->kredit,
                'saldo'                       => $request->saldo,
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
        $data = KasKecil::find($id);
        return response()->json(['status' => 'success', 'messages' => 'Load Data', 'data' => $data], 201);
    }


    //update
    public function update(Request $request, $id)
    {
        $validate = [
            'tanggal_transaksi' => 'required',
            'kode'     => 'required',
            'nama_transaksi'   => 'required',
            'debet'            => 'required',
            'kredit'           => 'required',
            'saldo'            => 'required',

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
                'tanggal_transaksi'           => $request->tanggal_transaksi,
                'kode'                => $request->kode,
                'nama_transaksi'              => $request->nama_transaksi,
                'debet'                       => $request->debet,
                'kredit'                      => $request->kredit,
                'saldo'                       => $request->saldo,
            ];
            $kas_kecils = KasKecil::find($id)->update($data);
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
        $data = KasKecil::find($id);
        return response()->json(['status' => 'success', 'messages' => 'Load Data', 'data' => $data], 201);
    }

    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $kas_kecils = KasKecil::find($id)->delete();
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
        $kas_kecils = KasKecil::all();
        if (count($kas_kecils) != 0) {
            return Excel::download(new Export, 'Daftar-Asset-' . date('d-m-Y') . '.xlsx');
        }
        toastr()->error('Tidak ada Data');
        return redirect()->back()->withInput();
    }

    public function import()
    {
        try {
            Excel::import(new Import, request()->file('file'));
            toastr()->success('Import Barang Berhasil');
            return redirect()->back();
        } catch (QueryException $e) {
            toastr()->error('Gagal, Pastikan Import Data anda sesuai');
            return redirect()->back();
        }
    }
}
