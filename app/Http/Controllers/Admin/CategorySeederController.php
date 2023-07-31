<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CategorySeederController extends Controller
{
    public function index(Request $request)
    {   
        /* php artisan migrate */
        \Artisan::call('db:seed', array('--class' => "MenuSeeder"));
        $request->session()->flash('success', 'Category seedding successfully.');
        return back();
    }
}
