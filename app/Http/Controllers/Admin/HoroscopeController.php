<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Horoscope;
use App\Traits\CacheTrait;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HoroscopeController extends Controller
{
    use CacheTrait;
    public $months = [
        '01' => "बैशाख",
        '02' => "जेष्ठ",
        '03' => "असार",
        '04' => "साउन",
        '05' => "भदौ",
        '06' => "असोज",
        '07' => "कार्तिक",
        '08' => "मङ्सिर",
        '09' => "पुष",
        '10' => "माघ",
        '11' => "फागुन",
        '12' => "चैत",
    ];
    public function years()
    {
        $years = [];
        foreach (range(2076, 2099) as $year) {
            $years[$year] = $year;
        }
        return $years;
    }
    public $horoscope_types = ['daily' => 'daily', 'weekly' => 'weekly', 'monthly' => 'monthly', 'yearly' => 'yearly'];
    public function __construct(Horoscope $Horoscope)
    {
        $this->middleware(['permission:horoscope-list|horoscope-create|horoscope-edit|horoscope-delete'], ['only' => ['index', 'store']]);
        $this->middleware(['permission:horoscope-create'], ['only' => ['create', 'store']]);
        $this->middleware(['permission:horoscope-edit'], ['only' => ['edit', 'update']]);
        $this->middleware(['permission:horoscope-delete'], ['only' => ['destroy']]);
        $this->Horoscope = $Horoscope;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $horoscopes = Horoscope::select('*')
        // where('publish_status', true)
        ->orderBy('created_at', 'desc')
        ->paginate(20);
        $pageTitle = 'Horsocope';
        // $allHoroscope = Horoscope::first()->toArray();
        // $horoscopes = array_splice($allHoroscope, 2, 12);
        $data = [
            'months' => $this->months,
            'pageTitle' => $pageTitle,
            'horoscopes' => $horoscopes,
        ];
        return view('admin.horoscope.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = 'Add Horoscope Type';
        $data = new Horoscope();
        $allColumns = \DB::getSchemaBuilder()->getColumnListing('horoscopes');
        $columns = array_splice($allColumns, 2, 12);
        $months = $this->months;
        $years = $this->years();
        $horoscope_types = $this->horoscope_types;
        return view('admin.horoscope.form', compact('title', 'columns', 'months', 'years', 'horoscope_types'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $this->mapHoroscopeData($request);

        try {
            $this->Horoscope->fill($data)->save();
            $request->session()->flash('success', 'Horoscope created successfully.');
            $this->forgetHoroscopeCache();
            return redirect()->route('horoscope.index');
        } catch (\Exception $error) {
            $request->session()->flash('error', $error->getMessage());
            return redirect()->back();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Horoscope  $horoscope
     * @return \Illuminate\Http\Response
     */
    public function show(Horoscope $horoscope)
    {
        $data = $horoscope;
        $allColumns = \DB::getSchemaBuilder()->getColumnListing('horoscopes');
        $columns = array_splice($allColumns, 2, 12);
        $pageTitle = 'Horsocope';
        $allHoroscope = Horoscope::first()->toArray();
        $horoscopes = array_splice($allHoroscope, 2, 12);
        return view('admin.horoscope.list', compact('data', 'pageTitle', 'columns', 'horoscopes'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Horoscope  $horoscope
     * @return \Illuminate\Http\Response
     */
    public function edit(Horoscope $horoscope)
    {
        $title = 'Add Horoscope Type';
        $data = $horoscope;
        // dd($data);
        $allColumns = \DB::getSchemaBuilder()->getColumnListing('horoscopes');
        $columns = array_splice($allColumns, 2, 12);
        $months = $this->months;
        $years = $this->years();
        if ($horoscope->type == 'daily') {
            $horoscope->published_at = datenep($horoscope->published_at);

        }
        $horoscope_types = $this->horoscope_types;
        return view('admin.horoscope.form', compact('title', 'columns', 'horoscope', 'months', 'years', 'horoscope_types'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Horoscope  $horoscope
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Horoscope $horoscope)
    {
        $data = $this->mapHoroscopeData($request);
        try {
            $horoscope->fill($data)->save();
            $request->session()->flash('success', 'horoscope updated successfully.');
            $this->forgetHoroscopeCache();
            return redirect()->route('horoscope.index');
        } catch (\Exception $error) {
            $request->session()->flash('error', $error->getMessage());
            return redirect()->back();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Horoscope  $horoscope
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Horoscope $horoscope)
    {
        try {
            $horoscope->delete();
            $request->session()->flash('success', 'horoscope deleted successfully.');
            $this->forgetHoroscopeCache();
            return redirect()->route('horoscope.index');
        } catch (\Exception $error) {
            $request->session()->flash('error', $error->getMessage());
            return redirect()->back();
        }
    }
    public function mapHoroscopeData($request)
    {
        // dd($request->all());
        $data = [
            'type' => $request->type,
            'mesh' => $request->mesh,
            'vrish' => $request->vrish,
            'mithun' => $request->mithun,
            'karkat' => $request->karkat,
            'simha' => $request->simha,
            'kanya' => $request->kanya,
            'tula' => $request->tula,
            'vrishchik' => $request->vrishchik,
            'dhanu' => $request->dhanu,
            'makara' => $request->makara,
            'kumba' => $request->kumba,
            'meen' => $request->meen,
            "publish_status" => $request->publish_status,
            // "published_at" => carbon::parse($request->published_at)->toDateTimeString(),
            'created_by' => Auth::user()->id,
        ];
        if ($request->type == 'daily') {
            $data['published_at'] = dateeng($request->published_at);
        }
        if($request->type == 'yearly'){
            $data['year'] = intval($request->year);
        }
        if($request->type == 'monthly'){
            $data['month'] = $request->month;
            $data['year'] = $request->year;
        }
        if($request->type == 'weekly'){
            $data['startWeekDay']  = $request->startWeekDay;
            $data['endWeekDay']  = date('Y-m-d 23:23:59', strtotime($request->endWeekDay));
        }
        // dd($request->all());
        // dd($data);
        return $data;
    }

    protected function get_validator()
    {
    }
}
