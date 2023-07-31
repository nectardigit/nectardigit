<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Contact;

class ContactController extends Controller
{
    public function __construct(Contact $contact)
    {
        $this->middleware(['permission:contact-list|contact-view|contact-edit'], ['only' => ['index','show']]);
        $this->middleware(['permission:contact-view'], ['only' => ['show']]);
        $this->contact = $contact;
    }

    protected function getQuery($request)
    {
        $query = $this->contact->orderBy('id','DESC');
        if ($request->keyword) {
            $keyword = $request->keyword;
            $query = $query->where('title',$keyword);
        }
        return $query->paginate(20);
    }
    public function index(Request $request)
    {
        $data = $this->getQuery($request);
        return view('admin/contacts/list',compact('data'));
    }

    public function view($id)
    {
        $title = 'View Contact Detail';

        $contact_info = Contact::where('id', $id)->first();
        $contact_info->view_status = '1';
        $contact_info->save();

        return view('admin/contacts/page',compact('contact_info'));
    }
}
