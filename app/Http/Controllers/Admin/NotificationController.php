<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Notification;
use App\Models\RidingRequestNotification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function dailyNotification(Request $request){
        $limit = 20; 

        if ($request->limit && $request->limit > 0 && $request->limit < 101) {
            $limit = $request->limit;
        }

        if($request->filter){
            $keyword = $request->keyword;
            $name = $request->name;

            $filterData = Notification::when($keyword, function ($query, $keyword) use ($request){
                return $query->where("title", "LIKE", "%$keyword%")
                // ->orWhere("description", "LIKE", "%$keyword%");
                ->whereBetween('created_at', [date('Y-m-d', strtotime($request->start_date)), date('Y-m-d', strtotime($request->end_date))]);
            })
            ->when($name, function ($query, $name) {
                $userList = User::where('users.name', "LIKE", "%$name%")->get();
                $arr = [];
                foreach ($userList as $data) {
                    array_push($arr, $data->id);
                }
                return $query->whereIn('notifications.user_id', $arr);
            })
            ->paginate($limit);

            $data = [
                'notifications' => $filterData
            ];

        }else{
            $query = Notification::whereBetween('created_at', [date('Y-m-d 00:00:00'), date('Y-m-d 23:59:59')]);

            $notifications  = $query->orderBy('id', 'DESC')->paginate($limit);
    
            $data = [
                'notifications' => $notifications
            ];
        }

        return view('admin/report/daily-notification',$data);
    }

    public function showDailyNotification($id){
        $notification_info = Notification::where('id',$id)->first();
        $notification_info->seen_status = '1';
        $notification_info->save();
        return view('admin.report.show-daily-notification',compact('notification_info'));
    }

    public function adminNotification(Request $request)
    {
        $limit = 20;

        if ($request->limit && $request->limit > 0 && $request->limit < 101) {
            $limit = $request->limit;
        }

        if($request->filter){
            $keyword = $request->keyword;
            $name = $request->name;

            $filterData = Notification::when($keyword, function ($query, $keyword) use ($request){
                return $query->where('user_type','admin')
                    ->where("title", "LIKE", "%$keyword%");
                    // ->whereBetween('created_at', [date('Y-m-d', strtotime($request->start_date)), date('Y-m-d', strtotime($request->end_date))]);
            })
            ->when($name, function ($query, $name) {
                $userList = User::where('users.name', "LIKE", "%$name%")->get();
                $arr = [];
                foreach ($userList as $data) {
                    array_push($arr, $data->id);
                }
                return $query->whereIn('notifications.user_id', $arr);
            })
            ->paginate($limit);

            $data = [
                'notifications' => $filterData
            ];

        }else{
            $adminNotifications = Notification::where('user_type','admin')->paginate($limit);

            $data = [
                'notifications' => $adminNotifications
            ];
        }

        return view('admin.report.admin-notification',$data);
    }

    public function ridingNotification(Request $request)
    {
        $limit = 20;

        if ($request->limit && $request->limit > 0 && $request->limit < 101) {
            $limit = $request->limit;
        }

        if($request->filter){
            $number = $request->number;
            $name = $request->name;

            $filterData = RidingRequestNotification::join('users as u1','u1.id','riding_request_notifications.customer_id')
                ->join('users as u2','u2.id','riding_request_notifications.rider_id')
                ->when($number, function ($query, $number){
                    return $query->where("u1.mobile", "LIKE", "%$number%")
                                ->orWhere("u2.mobile", "LIKE", "%$number%");
                })
                ->when($name, function ($query, $name){
                    return $query->where("u1.name", "LIKE", "%$name%")
                                ->orWhere("u2.name", "LIKE", "%$name%");
                })
                // ->toSql();
                ->paginate($limit);
                // dd($filterData);

            $data = [
                'notifications' => $filterData
            ];

        }else{
            $ridingRequestNotifications = RidingRequestNotification::paginate($limit);

            $data = [
                'notifications' => $ridingRequestNotifications
            ];
        }

        return view('admin.report.riding-notification',$data);

    }
}
