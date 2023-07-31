<?php

namespace App\Http\Controllers\Admin;

use App\Models\LogActivity;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserLogController extends Controller
{
    protected $logactivity=null;
    public function __construct(LogActivity $logActivity)
    {
        $this->middleware(['role:Super Admin']);
        $this->middleware(['role:Super Admin']);
        $this->middleware(['role:Super Admin']);
        $this->middleware(['role:Super Admin']);
        $this->logactivity=$logActivity;
    }
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $visible=array(10=>'10', 20=>'20', 50=>'50', 100=>'100');
        if($request->q != null){
            $this->logactivity=$this->logactivity->where('subject', 'LIKE', '%' . $request->q . '%')->orWhere('ip', 'LIKE', '%' . $request->q . '%');
        }
        $this->logactivity=$this->logactivity->with('log_by')->orderBy('id','DESC')->paginate(($request->visible)?$request->visible:20);
        $this->logactivity->appends(['q'=>$request->q,'visible'=>$request->visible]);
        return view('admin.userlog.log',compact('visible'))->with('data',$this->logactivity);
    }

    public function ClearAll(){
        $status=$this->logactivity->truncate();
        if($status){
            request()->session()->flash('success', 'User-Log Cleared successfully');
        }else{
            request()->session()->flash('error', 'There was problem while deleting User Log');
        }
     return redirect(route('user-log.index'));
     }
}
