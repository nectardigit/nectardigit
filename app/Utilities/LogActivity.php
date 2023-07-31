<?php
namespace App\Utilities;
use Illuminate\Support\Facades\Request;
use App\Models\LogActivity as LogActivityModel;

class LogActivity
{
    public static function addToLog($subject,$uid=null)
    {
        $log = [];
        $log['subject'] = $subject;
        $log['url'] = Request::fullUrl();
        $log['method'] = Request::method();
        $log['ip'] = Request::ip();
        $log['agent'] = Request::header('user-agent');
        if($uid){
            $log['user_id'] = $uid;
        }else{
            $log['user_id'] = auth()->check() ? auth()->user()->id : null;
        }
        LogActivityModel::create($log);
    }
    public static function logActivityLists()
    {
        return LogActivityModel::latest()->get();
    }

}
