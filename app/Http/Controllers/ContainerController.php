<?php

namespace App\Http\Controllers;

use App\Models\Container;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ContainerController extends Controller
{
    public function __construct(Container $container)
    {
        $this->middleware(['permission:container-list|container-create|container-edit|container-delete'], ['only' => ['index', 'store']]);
        $this->middleware(['permission:container-create'], ['only' => ['create', 'store']]);
        $this->middleware(['permission:container-edit'], ['only' => ['edit', 'update']]);
        $this->middleware(['permission:container-delete'], ['only' => ['destroy']]);
        $this->container = $container;
    }

    public function index(Request $request)
    {

        $container = $this->container;

        if ($request->keyword) {
            $keyword = $request->keyword;
            $container = $container->where('title', 'LIKE', "%{$keyword}%");
        }
        $data = [
            'container' => $container->orderBy('id', 'DESC')->paginate(20),
        ];
        return  view('admin.container.container-list')->with($data);
    }



    public function create()
    {
        $container_info = null;
        $title = 'Add New Container';
        return view('admin.container.container-form', compact('container_info', 'title'));
    }

    protected function dataValidate($request)
    {
        $data = [
            'title' => 'required|string|min:3|max:190',
            'type' => 'required',
            'icon' => 'required',
            'position' => 'required|numeric',
            'publish_status' => 'required|numeric|in:0,1',
            'image' => 'nullable'
        ];
        return $data;
    }
    protected function mapdata($request)
    {
        $data = [

            'title' => $request->title,
            'type' => $request->type,
            'description' => $request->description,
            'icon' => $request->icon,
            'publish_status' => $request->publish_status,
            'position' => $request->position,
            'image'=>$request->image
        ];
        if ($request->isMethod('post')) {
            $data['created_by'] = Auth::user()->id;
        } elseif ($request->isMethod('put')) {
            $data['updated_by'] = Auth::user()->id;
        }
        if ($request->image) {
            $data['image'] = $request->image;
        }

        return $data;
    }

    public function store(Request $request)
    {
        // dd($request->all());
        $this->validate($request, $this->dataValidate($request));
        try {
            $data = $this->mapdata($request);
            $this->container->fill($data)->save();
            $request->session()->flash('success', 'Container created successfully.');
            return redirect()->route('container.index');
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
        $container_info = $this->container->find($id);
        if (!$container_info) {
            abort(404);
        }
        $title = 'Update Container';
        return view('admin.container.container-form', compact('container_info', 'title'));
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
        $container_info = $this->container->find($id);
        if (!$container_info) {
            abort(404);
        }
        $this->validate($request, $this->dataValidate($request));
        try {
            $data = $this->mapdata($request);
            $container_info->fill($data)->save();
            $request->session()->flash('success', 'Container updated successfully.');
            return redirect()->route('container.index');
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
        $container_info = $this->container->find($id);
        if (!$container_info) {
            abort(404);
        }
        try {
            $container_info->updated_by = Auth::user()->id;
            $container_info->save();
            $container_info->delete();
            $request->session()->flash('success', 'Container deleted successfully.');
            return redirect()->route('container.index');
        } catch (\Exception $error) {
            $request->session()->flash('error', $error->getMessage());
            return redirect()->back();
        }
    }
    public function changeStatus(Request $request)
    {
        $this->container->find($request->id)->update(['publish_status' => $request->status]);
    }
}
