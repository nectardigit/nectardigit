<?php

namespace App\Http\Controllers;

use App\Mail\RepalyMessage;
use App\Models\AppSetting;
use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactBakEndController extends Controller
{
    public function __construct(Contact $contact)
    {
        $this->get_web();
        $this->contact = $contact;
        cache()->forget('contact');
    }
    public function show()
    {
        $data = $this->contact->where('isDeleted', '0')->orderby('id', 'DESC')->paginate();
        return view('admin.message.message-list', compact('data'));
    }

    public function delete($id)
    {
        $data = $this->contact->findorFail($id);
        $data->update(['isDeleted' => '1']);
        return redirect(route('message.show'));
    }
    public function repaly($id)
    {
        $title = 'Message Repaly';
        $data = $this->contact->findorFail($id);
        // dd($data->email);
        return view('admin.message.message-repaly', compact('data', 'title'));
    }
    public function sendrepaly(Request $request,$id)
    {
        // dd($request->all());
        $repaly=$this->contact->findorFail($id);
        $logo = AppSetting::pluck('logo_url')->first();
        $this->validate($request, [
            'repaly_message' => 'required',
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'subject' => $request->subject,
            'repaly_message' => $request->repaly_message,
            'logo' => $logo ?? env('APP_URL') . '/images/logo.png',
            'image'=> @$repaly->image,
        ];
        if ($request->image) {
            if (validate_url($request->image)) {
                $data['image'] = $request->image;
                $repaly->update(['image'=>$request->image]);

            } else {
                $request->session()->flash('error', 'Image invalid!!');

                return back();
            }
        }
        try {
            $repaly->update(['repaly_message'=>$data['repaly_message']]);

            Mail::to($request->email)->send(new RepalyMessage($data));

            $request->session()->flash('success', 'Repaly Sucessfull!!');

            return redirect(route('message.show'));
        } catch (\Throwable $th) {
            $request->session()->flash('error', $th);
            return redirect(route('message.show'));
        }
    }
}
