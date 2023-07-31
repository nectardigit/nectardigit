<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Designation;
use App\Models\Team;
use App\Traits\CacheTrait;
use App\Traits\NewsTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use function GuzzleHttp\Promise\all;
use Illuminate\Support\Str;


class TeamController extends Controller
{
    public $team;
    use NewsTrait;
    use CacheTrait;
    public function __construct(Team $team, Designation $designation)
    {
        $this->middleware(['permission:team-list|team-create|team-edit|team-delete'], ['only' => ['index', 'store']]);
        $this->middleware(['permission:team-create'], ['only' => ['create', 'store']]);
        $this->middleware(['permission:team-edit'], ['only' => ['edit', 'update']]);
        $this->middleware(['permission:team-delete'], ['only' => ['destroy']]);
        $this->team = $team;
        $this->designation = $designation;
    }

    protected function getTeam($request)
    {
        // dd($request->status);
        $query = $this->team->orderBy('id', 'DESC')
            ->with('designation')
            ->when(($request->status == '1'), function ($qr) {
                return $qr->where('publish_status', '1');
            })
            ->when(($request->status == '0'), function ($q) {
                return $q->where('publish_status', '0');
            })
            ->when($request->keyword, function ($qur) {
                return $qur->where('full_name', 'LIKE', "%" . request()->keyword . "%");
            });

        return $query->paginate(20);
    }

    protected function getDesignation()
    {
        $designations = Designation::select('id', 'title')
            ->where('publish_status', '1')
            ->get()
            ->mapWithKeys(function ($designation) {
                return [$designation->id => $designation->title['en']];
            });

        return $designations;
    }
    public function index(Request $request)
    {
        $data = $this->getTeam($request);
        return view('admin/team/list', compact('data'));
    }

    public function create(Request $request)
    {
        $team_info = null;
        $title = 'Add Team';
        $designations = $this->getDesignation();
        return view('admin/team/form', compact('team_info', 'title', 'designations'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'en_full_name' => 'string|min:3|max:190',
            'np_full_name' => 'string|min:3|max:190',
            'publish_status' => 'required|numeric|in:1,0',
            "show_footer" => "required|boolean"
        ]);
        $data = [
            'full_name' => [
                'en' => htmlentities($request->en_full_name),
                'np' => htmlentities($request->np_full_name),
            ],
            'phone' => $request->phone,
            'address' => $request->address,
            'email' => $request->email,
            'facebook' => $request->facebook,
            'twitter' => $request->twitter,
            'youtube' => $request->youtube,
            'instagram' => $request->instagram,
            'publish_status' => $request->publish_status,
            'description' => [
                'en' => htmlentities($request->en_description),
                'np' => htmlentities($request->np_description),
            ],
            "show_footer" => $request->show_footer ? true : false,
            'created_by' => Auth::user()->id,
            'designation_id' => $request->designation_id == 0 ? null : $request->designation_id,
            'image' => $request->filepath ?? null,
            "slug" => $this->getSlug($request->en_full_name) ?? $this->getSlug($request->np_full_name),

        ];


        try {
            $this->team->fill($data)->save();
            //            dd($data);
            $request->session()->flash('success', 'Team created successfully.');
            $this->forgetTeamCache();
            return redirect()->route('team.index');
        } catch (\Exception $error) {
            $request->session()->flash('error', $error->getMessage());
            return redirect()->back();
        }
    }

    public function edit(Request $request, $id)
    {
        $team_info = $this->team->find($id);
        $designations = $this->getDesignation();
        if (!$team_info) {
            abort(404);
        }
        // dd($designations);
        $title = 'Update Team';
        return view('admin/team/form', compact('team_info', 'title', 'designations'));
    }

    public function update(Request $request, $id)
    {
        // dd($request->all());

        $team_info = $this->team->find($id);
        if (!$team_info) {
            abort(404);
        }
        $this->validate($request, [
            'en_full_name' => 'string|min:3|max:190',
            'np_full_name' => 'string|min:3|max:190',
            'publish_status' => 'required|numeric|in:1,0',
            "show_footer" => "required|boolean",
        ]);
        $data = [
            'full_name' => [
                'en' => htmlentities($request->en_full_name),
                'np' => htmlentities($request->np_full_name),
            ],
            'phone' => $request->phone,
            'address' => $request->address,
            'email' => $request->email,
            'facebook' => $request->facebook,
            'twitter' => $request->twitter,
            'youtube' => $request->youtube,
            'instagram' => $request->instagram,
            'publish_status' => $request->publish_status,
            'description' => [
                'en' => htmlentities($request->en_description),
                'np' => htmlentities($request->np_description),
            ],
            "show_footer" => $request->show_footer ? true : false,
            'created_by' => Auth::user()->id,
            'designation_id' => $request->designation_id,
            "slug" => $this->getSlug($request->en_full_name) ?? $this->getSlug($request->np_full_name),
        ];
        // dd($data);
        if ($request->filepath && $request->filepath) {
            $data['image'] = $request->filepath;
        }


        try {
            $team_info->fill($data)->save();
            $request->session()->flash('success', 'Team updated successfully.');
            $this->forgetTeamCache();
            return redirect()->route('team.index');
        } catch (\Exception $error) {
            $request->session()->flash('error', $error->getMessage());
            return redirect()->back();
        }
    }

    public function destroy(Request $request, $id)
    {
        $team_info = $this->team->find($id);
        if (!$team_info) {
            abort(404);
        }
        try {
            $team_info->delete();
            $data['updated_by'] = Auth::user()->id;
            $request->session()->flash('success', 'Team deleted successfully.');
            cache()->forget('app_members');
            $this->forgetTeamCache();

            return redirect()->route('team.index');
        } catch (\Exception $error) {
            $request->session()->flash('error', $error->getMessage());
            return redirect()->back();
        }
    }
    protected function getSlug($title)
    {
        $slug = Str::slug($title);
        $find = $this->team->where('slug', $slug)->first();
        if (request()->isMethod('post')) {
            if ($find) {
                $slug = $slug . '-' . rand(1111, 9999);
            }
        }
        return $slug;
    }
    public function changeStatus(Request $request)
    {
        $this->team->find($request->id)->update(['publish_status' => $request->status]);
    }
}
