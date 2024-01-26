<?php

namespace App\Http\Controllers;

use App\Helpers\Custom;
use App\Models\Tabungan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Database\QueryException;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;
use App\ExportsTabungan\Tabungan\Excel\Export;
use App\ImportsTabungan\Tabungan\Excel\Import;

class TabunganController extends Controller
{
    public function index()
    {
        if (request()->ajax()) {
            $result = Tabungan::orderBy('tanggal_transaksi', 'ASC');
            return DataTables::eloquent($result)
                ->addIndexColumn()
                ->addColumn('act', function ($data) {
                    return view('pages.tabungan.modal.action', compact('data'));
                })
                ->rawColumns(['act'])->make(true);
        }
        return view('pages.tabungan.index');
    }

    public function store(Request $request)
    {
        $validate = [
            'tanggal_transaksi' => 'required',
            'no_transaksi'     => 'required',
            'keterangan'   => 'required',
            'debet'            => 'required',
            'kredit'           => 'required',
            'saldo'            => 'nullable'



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
            $tabungans = Tabungan::create([
                'tanggal_transaksi'           => $request->tanggal_transaksi,
                'no_transaksi'     => $request->no_transaksi,
                'keterangan'                => $request->keterangan,
                'nama_transaksi'              => $request->nama_transaksi,
                'debet'                       => $request->debet,
                'kredit'                      => $request->kredit,
                'saldo'                       => $request->saldo

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
        $data = Tabungan::find($id);
        return response()->json(['status' => 'success', 'messages' => 'Load Data', 'data' => $data], 201);
    }


    //update
    public function update(Request $request, $id)
    {
        $validate = [
            'tanggal_transaksi' => 'required',
            'no_transaksi'     => 'required',
            'keterangan'   => 'required',
            'debet'            => 'required',
            'kredit'           => 'required',
            'saldo'            => 'required'


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
                'no_transaksi'                => $request->no_transaksi,
                'keterangan'              => $request->keterangan,
                'debet'                       => $request->debet,
                'kredit'                      => $request->kredit,
                'saldo'                       => $request->saldo

            ];
            $tabungans = Tabungan::find($id)->update($data);
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
        $data = Tabungan::find($id);
        return response()->json(['status' => 'success', 'messages' => 'Load Data', 'data' => $data], 201);
    }

    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $tabungans = Tabungan::find($id)->delete();
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
        $tabungans = Tabungan::all();
        if (count($tabungans) != 0) {
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
