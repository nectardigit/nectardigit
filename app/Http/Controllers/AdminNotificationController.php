<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;

class AdminNotificationController extends Controller
{
    public function __invoke(Request $request)
    {
        $notification =  Notification::select('id', 'title')->where('user_type', 'admin')->where('seen_status', '0')->latest()->take(5)->get();
        foreach ($notification as $key => $value) {
            $noti[] = [
                'id' => $value->id,
                'title' => $value->title,
                'link' => route("dailyNotification.show", ['id' => $value->id ]),
            ];
        }
        // dd($noti);
        return response()->json([
            'status' => true,
            'status_code' => 200,
            'message' => "Notification found.",
            'data' => $notification
        ], 200);
        //    dd($request->all());
    }
}
