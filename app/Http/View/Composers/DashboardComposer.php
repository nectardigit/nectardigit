<?php
namespace App\Http\View\Composers;

use App\Models\RidingPayment;
use App\Models\RidingRequest;
use Illuminate\View\View;

class DashboardComposer
{
    public function compose(View $view)
    {
 
        // dd($hourlyRidingRequests);
  
 

        $view->with([
            // 'allRidingRequests' => $allRidingRequests,
            // 'hourlyRidingRequests' => $hourlyRidingRequests,
            // 'totalTransaction' => $totalTransaction,
            // 'todaysOrders' => $todaysOrders,
            // 'totalOrders' => $totalOrders,
            // 'cancelledOrders' => $cancelledOrders,
            // 'todaysCancelledOrders' => $todaysCancelledOrders,
            // 'todaysTotalTransaction' => $todaysTotalTransaction,
        ]);
    }
}
