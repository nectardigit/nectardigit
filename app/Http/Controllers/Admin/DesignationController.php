<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Designation;
use Illuminate\Http\Request;
use App\Traits\CacheTrait;
use Illuminate\Support\Facades\Auth;

class DesignationController extends Controller
{
    use CacheTrait;
    public $designation;

    public function __construct(Designation $designation)
    {
        $this->middleware(['permission:designation-list|designation-create|designation-edit|designation-delete'], ['only' => ['index', 'store']]);
        $this->middleware(['permission:designation-create'], ['only' => ['create', 'store']]);
        $this->middleware(['permission:designation-edit'], ['only' => ['edit', 'update']]);
        $this->middleware(['permission:designation-delete'], ['only' => ['destroy']]);
        $this->designation = $designation;
    }

    protected function getQuery($request)
    {
        $query = $this->designation->orderBy('position', 'Asc');
        if ($request->keyword) {
            $keyword = $request->keyword;
            $query = $query->where('title', 'LIKE', "%$keyword%");
        }
        return $query->paginate(20);
    }

    public function index(Request $request)
    {
        $data = $this->getQuery($request);
        return view('admin/designations/list', compact('data'));
    }

    public function create()
    {
        $designations_info = null;
        $title = 'Add Designation';
        return view('admin/designations/form', compact('designations_info', 'title'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required|string|min:3|max:190',
            'publish_status' => 'required|numeric|in:1,0'
        ]);


        $data = [
            'title' => [
                'en' => htmlentities($request->title),
                'np' => htmlentities($request->nepali_title),
            ],
            'publish_status' => $request->publish_status,
        ];
        $data['created_by'] = Auth::user()->id;
        try {
            Designation::create($data);
            $request->session()->flash('success', 'Designation created successfully.');
            $this->forgetTeamCache();
            return redirect()->route('designations.index');
        } catch (\Exception $error) {
            $request->session()->flash('error', $error->getMessage());
            return redirect()->back();
        }
    }

    public function edit(Request $request, $id)
    {
        $designations_info = $this->designation->find($id);
        if (!$designations_info) {
            abort(404);
        }
        $title = 'Update Designation';
        return view('admin/designations/form', compact('designations_info', 'title'));
    }

    public function update(Request $request, $id)
    {
        $designations_info = $this->designation->find($id);
        if (!$designations_info) {
            abort(404);
        }
        $this->validate($request, [
            'title' => 'required|string|min:3|max:190',
            'publish_status' => 'required|numeric|in:1,0'
        ]);
        $data = [
            'title' => [
                'en' => htmlentities($request->title),
                'np' => htmlentities($request->nepali_title),
            ],
            'publish_status' => $request->publish_status,
        ];
        $data['updated_by'] = Auth::user()->id;

        try {
            $designations_info->fill($data)->save();
            $request->session()->flash('success', 'Designation updated successfully.');
            $this->forgetTeamCache();
            return redirect()->route('designations.index');
        } catch (\Exception $error) {
            $request->session()->flash('error', $error->getMessage());
            return redirect()->back();
        }
    }

    public function destroy(Request $request, $id)
    {
        $designations_info = $this->designation->find($id);
        if (!$designations_info) {
            abort(404);
        }
        try {
            $designations_info->delete();
            $data['updated_by'] = Auth::user()->id;
            $request->session()->flash('success', 'Designation deleted successfully.');
            $this->forgetTeamCache();
            return redirect()->route('designations.index');
        } catch (\Exception $error) {
            $request->session()->flash('error', $error->getMessage());
            return redirect()->back();
        }
    }
    public function updateDesignationOrder(Request $request)
    {
        parse_str($request->sort, $arr);
        $order = 1;
        if (isset($arr['designationItem'])) {
            foreach ($arr['designationItem'] as $key => $value) {  //id //parent_id
                $this->designation->where('id', $key)
                    ->update(['position' => $order]);
                $order++;
            }
        }
        $this->forgetTeamCache();
        return true;
    }
    public function resetorder()
    {
        return redirect()->back();
    }
}
