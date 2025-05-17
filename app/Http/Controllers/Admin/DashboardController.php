<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Rapat;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $rapats = Rapat::whereDate('tanggal_rapat', '>=', now())
            ->orderBy('tanggal_rapat', 'asc')
            ->get();

        return view('partials.admin.dashboard', compact('rapats'));
    }
}
