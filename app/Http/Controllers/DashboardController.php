<?php

namespace App\Http\Controllers;

use App\Models\Pengajuan;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        return view('index', [
            'title' => 'Dashboard',
            'active' => 'dashboard',
            'jlh_aju' => Pengajuan::count('id'),
            'jlh_aju_approve_direktur' => Pengajuan::whereNotNull('aju_approve_direktur')->count(),
            'jlh_aju_approve_finance' => Pengajuan::whereNotNull('aju_approve_finance')->count(),
            'jlh_aju_tolak' => Pengajuan::whereNotNull('aju_tolak')->count(),
        ]);
    }
}
