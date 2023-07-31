<?php

namespace App\Http\Livewire;

use App\Models\subscriber;
use  Validator;
use Livewire\Component;

class SubscribeNewsLetter extends Component
{
    public $email;
    public $message;
    public $message_class =  'alert-danger';
    public $footer_data;
    public function render()
    {
        return view('livewire.subscribe-news-letter');
    }

    public function subscribeMe()
    {
        //  $this->validate([
        //     'email' => "required|email|unique:users,email",
        // ]);
        $valid = Validator::make([
           "email" => $this->email
        ], [
            'email' => "required|email|unique:subscribers,email",
        ]);
        // dd($valid);
        if ($valid->fails()) {
            // dd($valid->messages()->getMessages()['email'][0]);
             $this->message = $valid->messages()->getMessages()['email'][0];
             $this->message_class = 'alert-danger';
            return ;    
        }
        $data = [
            'email' => $this->email,
        ];

        subscriber::create($data);
        $this->message_class = 'alert-success';

        $this->message = 'Newsletter notification has been subscribed successfully!';
        $this->email = '';
        // session()->flash('success', 'Newsletter notification has been subscribed successfully!');
        // $notification = array(
        //     'message' => 'subscribed successfully!',
        //     'alert-type' => 'success',
        // );
    }
}
