<?php
namespace App\Http\View\Composers;
use App\Models\Notification;
use Illuminate\View\View;
class NotificationComposer
{
    public function compose(View $view)
    {
        // $notification =  Notification::select('id', 'type', 'title')->where('user_type', 'admin')
        // ->where('seen_status', '0')->latest()->take(5)->get();
        // $view->with([
        //     'notification' => $notification,
        // ]);
    }
}