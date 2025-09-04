<?php

namespace App\Http\Controllers;

use App\Models\Checklist;
use App\Models\Panjikaran;
use App\Models\Renewal;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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

        // Renewal statistics - Get latest renewal for each panjikaran
        $today = Carbon::today();
        $oneMonthFromNow = Carbon::today()->addDays(30);

        // Get the latest renewal for each panjikaran using a subquery approach
        $latestRenewalsSubquery = DB::table('renewals')
            ->select('panjikaran_id', DB::raw('MAX(renew_date) as latest_renew_date'))
            ->groupBy('panjikaran_id');

        // Get the actual renewal records with expiry dates
        $latestRenewals = DB::table('renewals as r1')
            ->joinSub($latestRenewalsSubquery, 'r2', function ($join) {
                $join->on('r1.panjikaran_id', '=', 'r2.panjikaran_id')
                     ->on('r1.renew_date', '=', 'r2.latest_renew_date');
            })
            ->select('r1.panjikaran_id', 'r1.renew_expiry_date', 'r1.renew_date');

        // Count panjikarans with renewals expiring within 1 month (latest renewal only)
        $countExpiringRenewals = (clone $latestRenewals)
            ->whereBetween('r1.renew_expiry_date', [$today, $oneMonthFromNow])
            ->count();

        // Count panjikarans with expired renewals (latest renewal only)
        $countExpiredRenewals = (clone $latestRenewals)
            ->where('r1.renew_expiry_date', '<', $today)
            ->count();

        return view('dashboard', compact(
            'countRegistered',
            'countVerified',
            'countApproved',
            'countPanjikaran',
            'countExpiringRenewals',
            'countExpiredRenewals'
        ));
    }
}
