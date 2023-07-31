<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\NewsGuest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Validator;

class NewsGuestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->get_web();
    }
    public function index(Request $request)
    {
        $guests = NewsGuest::orderBy('id', 'DESC')
        ->where('name', 'like', "%$request->keyword%")
        ->paginate();
        $data = [
            "pageTitle" => "Guest list",
            'guests' => $guests,
        ];
        return view('admin.guests.guest-list', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $data = [
            'guestInfo' => null,
            'pageTitle' => 'Add Guest',
        ];
        return view('admin.guests.guest-create', $data);
    }
    protected function newsValidate($newsInfo = null)
    {
        // dd($this->_website);
        if ($this->_website == 'Both') {
            $data = [
                "np_name" => "required|string|max:200",
                "en_name" => "required|string|max:200",
                "np_position" => "required|string",
                "en_position" => "required|string",
                "np_organization" => "required|string",
                "en_organization" => "required|string",
                "contact_no" => "nullable|max:10",
            ];
        } else if ($this->_website == 'Nepali') {
            $data = [
                "np_name" => "required|string|max:200",
                "np_position" => "required|string",
                "np_organization" => "required|string",
            ];
        } else if ($this->_website == 'English') {
            $data = [
                "en_name" => "required|string|max:200",
                "en_position" => "required|string",
                "en_organization" => "required|string",
            ];
        }
        // dd($data);
        $data['publish_status'] = "required|in:0,1";

        return $data;
    }
    protected function mapGuestData($request, $newsInfo = null)
    {
        $data = [
            "name" => [
                "np" => $request->np_name ?? $request->en_name,
                "en" => $request->en_name ?? $request->np_name,
            ],
            "position" => [
                "np" => $request->np_position ?? $request->en_position,
                "en" => $request->en_position ?? $request->np_position,
            ],
            "organization" => [
                "np" => $request->np_organization ?? $request->en_organization,
                "en" => $request->en_organization ?? $request->np_organization,
            ],
            "pubilsh_status" => $request->publish_status ?? '0',
            'slug_url' => Str::slug($request->en_name),
            'guest_description' => $request->guest_description,
            'address' => $request->address,
            'email' => $request->email,
            'slug' => $request->slug,
            'twitter' => $request->twitter,
            'facebook' => $request->facebook,
        ];
        // dd($data);
        if ($request->filepath && !empty($request->filepath)) {
            $image = getImageFromUrl($request->filepath);
            // dd($image);
            if ($image) {
                // dd($image);
                if (count($image)) {
                    $data['image'] = $image['image'];
                    $data['path'] = $image['path'];
                }
            }
        }
        // dd($data);
        return $data;
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request->all());
        $this->validate($request, $this->newsValidate());

        $data = $this->mapGuestData($request);
        // dd($data);
        DB::beginTransaction();
        try {
            $geust_info = NewsGuest::create($data);
            $request->session()->flash('success', 'Guest added successfully.');
            if ($request->wantsJson()) {
                $guests = NewsGuest::select('id', 'name')->orderBy('id', 'DESC')
                    ->where('publish_status', '1')
                    ->get();

                $guest_items = [];
                // dd($guest_items);
                foreach ($guests as $guest) {
                    $guest_items[$guest->id] = $guest->name[$this->locale];
                }

                $guest_html = view('admin.news.guest-option', compact('guest_items', 'geust_info'))->render();
                return response()->json([
                    'status' => true,
                    'html' => $guest_html,
                ]);
            }
            DB::commit();
            return redirect()->route('guests.index');
        } catch (\Exception $error) {
            $request->session()->flash('error', $error->getMessage());
            DB::rollback();
            return redirect()->back();
        }

    }
    public function addGuest(Request $request)
    {
        // dd($request->all());

        $validation  = Validator::make($request->all(), [
            "np_name" => "required|string|max:200",
            "email" => "required|string",
            "address" => "required|string",
            "contact_no" => "nullable|max:10",
        ]);
        if($validation->fails()){
            return response()
            ->json([
                'status' => false, 
                'message' =>mapErrorMessage($validation)
            ], 200);
        }

        $data = $this->mapGuestData($request);
        // dd($data);
        DB::beginTransaction();
        try {
            $geust_info = NewsGuest::create($data);
            // $request->session()->flash('success', 'Guest added successfully.');
            DB::commit();
            $guests = NewsGuest::select('id', 'name')->orderBy('id', 'DESC')
                ->where('publish_status', '1')
                ->get();

            $guest_items = [];
            // dd($guest_items);
            foreach ($guests as $guest) {
                $guest_items[$guest->id] = $guest->name[$this->locale];
            }

            $guest_html = view('admin.news.guest-option', compact('guest_items', 'geust_info'))->render();
            return response()->json([
                'status' => true,
                "message" => "Guest successfully added",
                'html' => $guest_html,
            ]);

        } catch (\Exception $error) {
            $request->session()->flash('error', $error->getMessage());
            DB::rollback();
            return response()->json([
                'status' => false,
                'message' => "Sorry! There was problem while adding new guest.",
            ], 502);
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
    public function edit(Request $request, $id)
    {
        //
        $guestInfo = NewsGuest::find($id);
        if (!$guestInfo) {
            $request->session()->flash('error', 'Invalid Guest information');
            return redirect()->route('guests.index');
        }
        $guestInfo->image_url = $guestInfo->image ? getFullImage($guestInfo->image, $guestInfo->path) : null;
        $guestInfo->image_thumb_url = $guestInfo->image ? getThumbImage($guestInfo->image, $guestInfo->path) : null;
        // dd($guestInfo);
        $data = [
            'guestInfo' => $guestInfo,
            'pageTitle' => 'Update Guest',
        ];
        return view('admin.guests.guest-create', $data);
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
        //
        $guestInfo = NewsGuest::find($id);
        if (!$guestInfo) {
            $request->session()->flash('error', 'Invalid Guest information');
            return redirect()->route('guests.index');
        }
        $this->validate($request, $this->newsValidate());
        $data = $this->mapGuestData($request);
        try {
            $guestInfo->fill($data)->save();
            $request->session()->flash('success', 'Guest updated successfully.');
            return redirect()->route('guests.index');
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
        //
        $guestInfo = NewsGuest::find($id);
        if (!$guestInfo) {
            $request->session()->flash('error', 'Invalid Guest information');
            return redirect()->route('guests.index');
        }

        try {
            $guestInfo->delete();
            $request->session()->flash('success', 'Guest information removed successfully.');
            return redirect()->route('guests.index');
        } catch (\Exception $error) {
            $request->session()->flash('error', $error->getMessage());
            return redirect()->back();
        }

    }
}
