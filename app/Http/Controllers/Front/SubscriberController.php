<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Mail\SubscribedMail;
use App\Models\subscriber;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Validator;

class SubscriberController extends Controller
{


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request->all());
        $valid = \Validator::make($request->all(), [
            'email' => 'required|email'
        ]);
        if ($valid->fails()) {
            // dd($valid->messages()->getMessages()['email'][0]);

            $request->session()->flash('error', $valid->messages()->getMessages()['email'][0]);
            return back();
        }
        $subscribe = new subscriber();

        $subscriber =   $subscribe->where('email', $request->email)->count();
        // dd($subscriber);
        if ($subscriber == 0) {
            $subscribe->email = $request->email;
            $subscribe->save();
            Mail::to($request->email)->send(new SubscribedMail());
            $request->session()->flash('success', 'Subscribed Successfully!');
        } else {
            $request->session()->flash('warning', 'This Email: '.$request->email.' Already Subscribed !');
        }

        return back();
    }
}
