<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CareerRequest;
use App\Models\Application;
use App\Models\Career;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CareerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Career::paginate(10);
        return view('admin.career.list', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $career = new Career();
        $title = 'create Career';
        return view('admin.career.form', compact('career', 'title'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CareerRequest $request)
    {
        $data = $request->validated();
        try {
            Career::create($data);
            request()->session()->flash('success', 'The career has been created successfully');
            return redirect()->route('career.index');
        } catch (\Error $er) {
            request()->session()->flash('error', $er->getMessage());
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
        $career = Career::findorfail($id);
        $title = 'update ' . $career->title;
        return view('admin.career.form', compact('career', 'title'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CareerRequest $request, $id)
    {
        $career = Career::findorfail($id);
        $data = $request->validated();
        try {
            $career->update($data);
            request()->session()->flash('success', 'The career has been created successfully');
            return redirect()->route('career.index');
        } catch (\Error $er) {
            request()->session()->flash('error', $er->getMessage());
            return redirect()->back();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $career = Career::findorfail($id);
        DB::beginTransaction();
        try {
            $career->delete();
            DB::commit();
            request()->session()->flash('success', 'The career has been deleted successfully');
            return redirect()->route('career.index');
        } catch (\Throwable $th) {
            DB::rollback();
            request()->session()->flash('error', 'The career cannot be deleted now');
            return redirect()->back();
        }
    }
}
