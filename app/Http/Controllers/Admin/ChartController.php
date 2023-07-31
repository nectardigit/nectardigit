<?php

namespace App\Http\Controllers\Admin;

use App\Models\Rider;
use App\Models\RidingPayment;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ChartController extends Controller
{
    public function monthlyRiderChart()
    {

        $riders = Rider::selectRaw('monthname(created_at) month, MONTH(created_at) monthid, count(*) data')
            ->groupBy('month','monthid')
            ->orderBy('monthid', 'asc')
            ->limit(12)
            ->get();
            // dd($riders);

        $page_title = 'Monthly Rider Bar Graph';
        return view('admin/charts/monthly-rider',compact('page_title','riders'));
    }

    public function totalRidingPayments()
    {
        $yearlyPayments = RidingPayment::selectRaw('YEAR(created_at) year, sum(total_amount) data')
            ->groupBy('year')
            ->orderBy('year', 'asc')
            ->limit(12)
            ->get();
            // dd($yearlyPayments);

        $monthlyPayments = RidingPayment::selectRaw('monthname(created_at) month, MONTH(created_at) monthid, sum(total_amount) data')
            ->groupBy('month','monthid')
            ->orderBy('monthid', 'asc')
            ->limit(12)
            ->get();
            // dd($monthlyPayments);

        $page_title = 'Riding Payment Bar Graph';
        return view('admin/charts/riding-payment',compact('page_title','yearlyPayments','monthlyPayments'));
    }
}
