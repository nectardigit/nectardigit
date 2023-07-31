<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class WordpressBackupController extends Controller
{
    public function index()
    {
        // ini_set('memory_limit', '-1');
        // return view('admin/wordpressbackup/form');
    }
    
    public function create()
    {
        return view('admin/wordpressbackup/form');
    }

    public function store(Request $request)
    {
        // $this->validate($request, [
        //     'database' => 'required|mimes:sql'
        // ]);
        try {
            if($request->file('database')){
                $file = $request->file('database');
                $name = $request->file('database')->getClientOriginalName();
                $path = $request->file('database')->store('database');
                // dd($path);
            }
            $request->session()->flash('success', 'Database added successfully.');
            return redirect()->route('wordpressbackup.index');
        } catch (\Exception $error) {
            $request->session()->flash('error', $error->getMessage());
            return redirect()->back();
        }
    }
}