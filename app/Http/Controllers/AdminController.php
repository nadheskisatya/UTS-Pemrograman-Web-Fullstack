<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use Carbon\Carbon;

class AdminController extends Controller
{
    public function dashboard()
    {
        // Total hari ini
        $today = Transaksi::whereDate('created_at', today())
                          ->sum('total_harga');

        // 5 hari ke belakang (termasuk hari ini)
        $days = [];
        for ($i = 4; $i >= 0; $i--) {
            $date = Carbon::today()->subDays($i);
            $days[] = [
                'label'  => $date->format('d M'),
                'total'  => Transaksi::whereDate('created_at', $date)->sum('total_harga'),
            ];
        }

        return view('admin.dashboard', compact('today', 'days'));
    }
}
