<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class ClientController extends Controller
{
    public function __construct(Client $client)
    {
        $this->middleware(['permission:client-list|client-create|client-edit|client-delete'], ['only' => ['index', 'store']]);
        $this->middleware(['permission:client-create'], ['only' => ['create', 'store']]);
        $this->middleware(['permission:client-edit'], ['only' => ['edit', 'update']]);
        $this->middleware(['permission:client-delete'], ['only' => ['destroy']]);
        $this->client = $client;
    }

    protected function getclient($request)
    {
        $query = $this->client;
        if (isset($request->status)) {
            $query = $this->client->where('publish_status', $request->status);
        }
        if ($request->keyword) {
            $keyword = $request->keyword;
            $query = $query->where('title', 'LIKE', "%{$keyword}%");
        }
        return $query->orderBy('id', 'DESC')->paginate(20);
    }
    public function index(Request $request)
    {
        $data = $this->getclient($request);
        // dd($data);
        return view('admin/clients/list', compact('data'));
    }

    public function create(Request $request)
    {
        $client_info = null;
        $title = 'Add Client';
        return view('admin/clients/form', compact('client_info', 'title'));
    }

    public function store(Request $request)
    {
        // dd($request->all());
        $url = validate_url($request->url);
        // dd($url);
        if ($url) {
            $this->validate($request, $this->clientValidate($request));
            try {
                $data = $this->mapclientData($request);
                // dd($data);
                $this->client->fill($data)->save();
                $request->session()->flash('success', 'Client created successfully.');
                return redirect()->route('clients.index');
            } catch (\Exception $error) {
                $request->session()->flash('error', $error->getMessage());
                return redirect()->back();
            }
        } else {
            $request->session()->flash('error', "Invalid URL !!");
            return redirect()->back();
        }
    }

    protected function clientValidate($request)
    {
        $data = [
            'title' => 'required|string|min:3|max:190',
            'position' => 'required|numeric',
            'short_description' => 'nullable|max:191',
            'publish_status' => 'required|numeric|in:0,1',
        ];
        if ($request->isMethod('post')) {
            $data['image'] = 'required';
        }
        return $data;
    }
    protected function mapclientData($request)
    {
        $data = [
            'title' => $request->title,
            "slug" => $this->getSlug($request->title),
            'date' => $request->date,
            'client_name' => $request->client_name,
            'display_home' => $request->display_home,
            'meta_title' => $request->meta_title,
            'meta_keyword' => $request->meta_keyword,
            'meta_description' => $request->meta_description,
            'meta_keyphrase' => $request->meta_keyphrase,
            'short_description' => $request->short_description,
            'description' => $request->description,
            'develop_by' => $request->develop_by,
            'title' => $request->title,
            'title' => $request->title,
            'url' => $request->url,
            'publish_status' => $request->publish_status,
            'position' => $request->position,
        ];
        if ($request->isMethod('post')) {
            $data['created_by'] = Auth::user()->id;
        } elseif ($request->isMethod('put')) {
            $data['updated_by'] = Auth::user()->id;
        }
        if ($request->image) {
            $data['image'] = $request->image;
        }
        if ($request->logo) {
            $data['logo'] = $request->logo;
        }
        return $data;
    }

    public function edit(Request $request, $id)
    {
        $client_info = $this->client->find($id);
        if (!$client_info) {
            abort(404);
        }
        $title = 'Update Client';
        return view('admin/clients/form', compact('client_info', 'title'));
    }

    public function update(Request $request, $id)
    {
        $client_info = $this->client->find($id);
        if (!$client_info) {
            abort(404);
        }
        $this->validate($request, $this->clientValidate($request));
        try {
            $data = $this->mapclientData($request);
            $client_info->fill($data)->save();
            $request->session()->flash('success', 'Client updated successfully.');
            return redirect()->route('clients.index');
        } catch (\Exception $error) {
            $request->session()->flash('error', $error->getMessage());
            return redirect()->back();
        }
    }

    public function destroy(Request $request, $id)
    {
        $client_info = $this->client->find($id);
        if (!$client_info) {
            abort(404);
        }
        try {
            $client_info->updated_by = Auth::user()->id;
            $client_info->save();
            $client_info->delete();
            $request->session()->flash('success', 'Client deleted successfully.');
            return redirect()->route('clients.index');
        } catch (\Exception $error) {
            $request->session()->flash('error', $error->getMessage());
            return redirect()->back();
        }
    }
    protected function getSlug($title)
    {
        $slug = Str::slug($title);
        $find = $this->client->where('slug', $slug)->first();
        if (request()->isMethod('post')) {
            if ($find) {
                $slug = $slug . '-' . rand(1111, 9999);
            }
        }

        return $slug;
    }

    public function changeStatus(Request $request)
    {
        $this->client->find($request->id)->update(['publish_status' => $request->status]);
    }
    public function changedisplayhome(Request $request)
    {
        $this->client->find($request->id)->update(['display_home' => $request->status]);
    }
}
