<?php

namespace App\Http\Controllers;

use App\Models\Checklist;
use App\Models\Panjikaran;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $countRegistered = $countVerified = $countApproved = 0;

        $countItem = Checklist::query()->whereNotNull('CreatedDate');

        $countRegistered = (clone $countItem)->count();
        $countVerified   = (clone $countItem)->where('Status', '1')->whereNotNull('VerifiedDate')->count();
        $countApproved   = (clone $countItem)->where('Status', '2')->whereNotNull('ApprovedDate')->count();
        $countPanjikaran = Panjikaran::count();


        return view('dashboard', compact('countRegistered', 'countVerified', 'countApproved', 'countPanjikaran'));
    }
}
