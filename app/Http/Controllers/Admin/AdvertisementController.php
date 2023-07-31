<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Advertisement;
use App\Traits\Admin\AdminAdvertiseTrait;
use App\Traits\CacheTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;

class AdvertisementController extends Controller
{
    use CacheTrait;
    use AdminAdvertiseTrait;

    public function __construct(Advertisement $advertisement)
    {
        $this->middleware(['permission:advertisement-list|advertisement-create|advertisement-edit|advertisement-delete'], ['only' => ['index', 'store']]);
        $this->middleware(['permission:advertisement-create'], ['only' => ['create', 'store']]);
        $this->middleware(['permission:advertisement-edit'], ['only' => ['edit', 'update']]);
        $this->middleware(['permission:advertisement-delete'], ['only' => ['destroy']]);
        $this->get_web();
        $this->advertisement = $advertisement;
    }

    public function index(Request $request)
    {
        $data = $this->getAd($request);
        // dd($data);
        return view('admin/advertisement/advertisement-list', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        // dd($this->_website);
        // dd($this->sharedPosition());
        $position = $this->getPosition();
        $section = $this->getSection();

        $data = [
            "show_on" => $this->show_on,
            'advertisement_info' => null,
            'title' => 'Add Advertisement',
            // "sharedPosition" => $this->sharedPosition(),
            // "specificPosition" => $this->specificPosition(),
            'position' => $position,
            'section' => $section,
            "pages" => $this->pages,
        ];

        return view('admin/advertisement/advertisement-form', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */

    public function store(Request $request)
    {
        // dd($request->all());
        // dd(auth());
        $this->validate($request, $this->validateAdvertiseForm());


        $data = $this->mapAdvertiseData($request);

        DB::beginTransaction();
        try {
            $advertisement_info = $this->advertisement->create($data);
            // $this->updateImage($request->filepath, $advertisement_info, "advertisements");
            DB::commit();
            $this->forgetAdvertisementCache();
            $request->session()->flash('success', 'Advertisement created successfully.');
            return redirect()->route('advertisement.index');
        } catch (\Exception $error) {
            DB::rollback();
            $request->session()->flash('error', $error->getMessage());
            return redirect()->back();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        $position = $this->getPosition();
        $section = $this->getSection();

        // dd($position);

        $advertisement_info = $this->advertisement->with(['get_position'])->find($id);
        abort_if(!$advertisement_info, 404);
        // if (!$advertisement_info) {
        //     $request->session()->flash('error', 'Advertisement not found.');
        //     return redirect()->route('advertisement.index');
        // }
        $advertisement_info->from_date = date('Y-m-d', strtotime($advertisement_info->from_date));
        $advertisement_info->to_date = date('Y-m-d', strtotime($advertisement_info->to_date));
        $from_date = $advertisement_info->from_date;
        $to_date = $advertisement_info->to_date;

        $title = 'Update Advertisement ';
        $data = [
            'advertisement_info' => $advertisement_info,
            'title' => $title,
            'from_date' => $from_date,
            'to_date' => $to_date,
            "show_on" => $this->show_on,
            "pages" => $this->pages,
            'position' => $position,
            'section' => $section,
        ];

        return view('admin/advertisement/advertisement-form', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $advertisement_info = $this->advertisement->find($id);
        abort_if(!$advertisement_info, 404);
        // if (!$advertisement_info) {
        //     $request->session()->flash('error', 'Advertisement not found.');
        //     return redirect()->route('advertisement.index');
        // }
        $this->validate($request, $this->validateAdvertiseForm());

        $data = $this->mapAdvertiseData($request, $advertisement_info);
        $this->forgetAdvertisementCache();
//        dd(Cache::get('advertise_positions'));
        DB::beginTransaction();
        try {
            $advertisement_info->fill($data)->save();

            DB::commit();
            $this->forgetAdvertisementCache();

            $request->session()->flash('success', 'Advertisement updated successfully.');
            return redirect()->route('advertisement.index');
        } catch (\Exception $error) {
            DB::rollback();
            $request->session()->flash('error', $error->getMessage());
            return redirect()->back();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $advertisement_info = $this->advertisement->find($id);
        abort_if(!$advertisement_info, 404);

        try {
            $advertisement_info->delete();
            $data['updated_by'] = Auth::user()->id;
            $this->forgetAdvertisementCache();

            $request->session()->flash('success', 'Advertisement deleted successfully.');
            return redirect()->route('advertisement.index');
        } catch (\Exception $error) {
            $request->session()->flash('error', $error->getMessage());
            return redirect()->back();
        }
    }
    public function changeAdStatus(Request $request, $id, $status){
        // dd($status );

        $advertisement_info = $this->advertisement->find($id);
        abort_if(!$advertisement_info, 404);
        if($status == '1'){
            $status = '0';
        }else {
            $status = '1';
        }
        try {
            $advertisement_info->publish_status = $status;
            $advertisement_info->updated_by = auth()->id();
            // $data['updated_by'] = Auth::user()->id;
            $advertisement_info->save();
            // dd($advertisement_info);
            $this->forgetAdvertisementCache();

            $request->session()->flash('success', 'Advertisement status changed successfully.');
            return redirect()->route('advertisement.index');
        } catch (\Exception $error) {
            $request->session()->flash('error', $error->getMessage());
            return redirect()->back();
        }
    }
}
