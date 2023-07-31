<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\subscriber;
use Illuminate\Http\Request;

class SubscriberBackEndController extends Controller
{
    public function __construct(subscriber $subscriber)
    {
        $this->middleware(['permission:subscriber-list|subscriber-create|subscriber-edit|subscriber-delete'], ['only' => ['index', 'store']]);
        $this->middleware(['permission:subscriber-create'], ['only' => ['create', 'store']]);
        $this->middleware(['permission:subscriber-edit'], ['only' => ['edit', 'update']]);
        $this->middleware(['permission:subscriber-delete'], ['only' => ['destroy']]);
        $this->get_web();
        $this->subscriber = $subscriber;
        cache()->forget('subscriber');
    }

    public function index(Request $request)
    {
        if ($request->keyword) {
            $data = subscriber::orderby('id', 'desc')->where('email', 'like', '%' . $request->keyword . '%')->paginate(20);
        } else {
            $data = subscriber::orderby('id', 'desc')->paginate(20);
        }
        return view('admin.Subscriber.subscriber-list', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        subscriber::find($id)->delete();
        return redirect(route('subscriber.index'));
    }
}
