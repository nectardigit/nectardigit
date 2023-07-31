<?php

namespace App\Http\Controllers;

use App\Models\Counter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CounterController extends Controller
{
    public function __construct(Counter $counter )
    {
        $this->middleware(['permission:counter-list|counter-create|counter-edit|counter-delete'], ['only' => ['index','store']]);
        $this->middleware(['permission:counter-create'], ['only' => ['create','store']]);
        $this->middleware(['permission:counter-edit'], ['only' => ['edit','update']]);
        $this->middleware(['permission:counter-delete'], ['only' => ['destroy']]);
        $this->counter = $counter;
    }

    public function index(Request $request)
    {

        $counter_info = $this->counter->first();
        $title = 'Counter';
        // dd($counter_info);
        return view('admin.counter.counter-form', compact('counter_info', 'title'));

    }



    public function create()
    {
      return redirect(route('counter.index'));
    }

    protected function dataValidate($request)
    {
        $data = [

            'publish_status' => 'required|numeric|in:0,1',
        ];
        return $data;
    }
    protected function mapdata($request)
    {
        // dd($request->all());
        $happy_client=[
            'value'=>$request->happy_client_value,
            'icon'=>$request->happy_client_icon,
        ];

        $skil_export=[
            'value'=>$request->skil_export_value,
            'icon'=>$request->skil_export_icon,
        ];
        $finesh_project=[
            'value'=>$request->finesh_project_value,
            'icon'=>$request->finesh_project_icon,
        ];
        $media_post=[
            'value'=>$request->media_post_value,
            'icon'=>$request->media_post_icon,
        ];

        $data = [

            'happy_client' => $happy_client,
            'skil_export'=>$skil_export,
            'finesh_project' => $finesh_project,
            'publish_status' => $request->publish_status,
            'media_post' => $media_post,
        ];
        if ($request->isMethod('post')) {
            $data['created_by'] = Auth::user()->id;
        } elseif ($request->isMethod('put')) {
            $data['updated_by'] = Auth::user()->id;
        }

        return $data;
    }

    public function store(Request $request)
    {
        // dd($request->all());
        $this->validate($request, $this->dataValidate($request));
        try {
            $data = $this->mapdata($request);
            $this->counter->fill($data)->save();
            $request->session()->flash('success', 'counter created successfully.');
            return redirect()->route('counter.index');
        } catch (\Exception $error) {
            $request->session()->flash('error', $error->getMessage());
            return redirect()->back();
        }
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
        return redirect(route('counter.index'));
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
        $counter_info = $this->counter->find($id)->first();
        if (!$counter_info) {
            abort(404);
        }
        $this->validate($request, $this->dataValidate($request));
        try {
            $data = $this->mapdata($request);
            $counter_info->fill($data)->save();
            $request->session()->flash('success', 'counter updated successfully.');
            return redirect()->route('counter.index');
        } catch (\Exception $error) {
            $request->session()->flash('error', $error->getMessage());
            return redirect()->back();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $counter_info = $this->counter->find($id);
        if (!$counter_info) {
            abort(404);
        }
        try {
            $counter_info->updated_by = Auth::user()->id;
            $counter_info->save();
            $counter_info->delete();
            $request->session()->flash('success', 'counter deleted successfully.');
            return redirect()->route('counter.index');
        } catch (\Exception $error) {
            $request->session()->flash('error', $error->getMessage());
            return redirect()->back();
        }
    }
}
