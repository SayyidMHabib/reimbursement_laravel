<?php

namespace App\Http\Controllers;

use App\Http\Resources\PengajuanResource;
use App\Models\Pengajuan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Auth;

class PengajuanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pengajuan = Pengajuan::all();
        if (auth()->user()->status == "Staff") {
            $pengajuan = Pengajuan::where('aju_user_id', auth()->user()->id)->get();
        }
        return DataTables::of($pengajuan)
            ->addIndexColumn()
            ->addColumn('item', fn ($pengajuan) => view('item')->with('data', $pengajuan))
            ->addColumn('status', fn ($pengajuan) => view('status')->with([
                'data' => $pengajuan,
                'user' => auth()->user()
            ]))
            ->addColumn('aksi', fn ($pengajuan) => view('aksi')->with('data', $pengajuan))
            ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'aju_user_id' => 'required',
            'aju_user' => 'required',
            'aju_jenis_data' => 'required',
            'aju_item' => 'required',
            'aju_tgl' => 'required',
            'aju_jumlah' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

        $data = Pengajuan::create([
            'aju_user_id' => $request->aju_user_id,
            'aju_user' => $request->aju_user,
            'aju_jenis_data' => $request->aju_jenis_data,
            'aju_item' => $request->aju_item,
            'aju_tgl' => $request->aju_tgl,
            'aju_jumlah' => $request->aju_jumlah,
        ]);
        return new PengajuanResource(true, 'Data Pengajuan Berhasil Ditambahkan', $data);
    }

    /**
     * Display the specified resource.
     */
    public function show(Pengajuan $pengajuan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $pengajuan = Pengajuan::find($id);
        return response()->json(['result' => $pengajuan]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'aju_user_id' => 'required',
            'aju_user' => 'required',
            'aju_jenis_data' => 'required',
            'aju_item' => 'required',
            'aju_tgl' => 'required',
            'aju_jumlah' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

        $data = [
            'aju_user_id' => $request->aju_user_id,
            'aju_user' => $request->aju_user,
            'aju_jenis_data' => $request->aju_jenis_data,
            'aju_item' => $request->aju_item,
            'aju_tgl' => $request->aju_tgl,
            'aju_jumlah' => $request->aju_jumlah,
        ];

        Pengajuan::where('id', $id)->update($data);

        return new PengajuanResource(true, 'Data Pengajuan Berhasil Diupdate', $data);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $data = Pengajuan::find($id);
        Pengajuan::where('id', $id)->delete();
        return new PengajuanResource(true, 'Data Pengajuan Berhasil Dihapus', $data);
    }

    public function approve_pengajuan(Request $request, string $id)
    {
        if (auth()->user()->status == "Direktur") {
            $data = [
                'aju_approve_direktur' => 1,
                'aju_tgl_approve_direktur' => date('Y-m-d H:i:s'),
                'aju_user_approve_direktur' => auth()->user()->name,
            ];
        }

        if (auth()->user()->status == "Finance") {
            $data = [
                'aju_approve_finance' => 1,
                'aju_tgl_approve_finance' => date('Y-m-d H:i:s'),
                'aju_user_approve_finance' => auth()->user()->name,
            ];
        }

        Pengajuan::where('id', $id)->update($data);

        return new PengajuanResource(true, 'Data Pengajuan Berhasil Diupdate', $data);
    }

    public function tolak_pengajuan(Request $request, string $id)
    {
        $data = [
            'aju_tolak' => 1,
            'aju_tgl_tolak' => date('Y-m-d H:i:s'),
            'aju_user_tolak' => auth()->user()->name,
        ];

        Pengajuan::where('id', $id)->update($data);

        return new PengajuanResource(true, 'Data Pengajuan Berhasil Diupdate', $data);
    }
}
