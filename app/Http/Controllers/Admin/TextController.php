<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Session;
use App\Models\Text;

class TextController extends Controller
{
    public function index()
    {
        $data = Text::select('*')->get();
        return view('admin.text.list', compact('data'));
    }

    public function update(Request $request)
    {
        // dd($request->all());
        $keys = $request->except('_token');
        foreach ($keys as $key => $value) {
            Text::set($key, $value);
        }
        $request->session()->flash('success', 'Text  updated successfully.');
        return redirect()->route('text.index');
    }
}
