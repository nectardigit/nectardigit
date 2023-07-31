<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\News;
use App\Models\Reporter;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Str;

class ReporterController extends Controller
{

    public function __construct(News $news, Reporter $reporter, User $user)
    {
        $this->news = $news;
        $this->reporter = $reporter;
        $this->user = $user;
    }

    public function showReporterNews(Request $request, $id)
    {
        $reporter = User::where('id', $id)->withCount('reporterNews')->first();

        $news = $this->news
            ->select(
                'id',
                'slug',
                'title',
                'reporter',
                'publish_status',
                'img_url',
                'category',
                'tags'
            )
            ->where('reporter', $reporter->id)
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        $data = [
            'news' => $news,
            'pageTitle' => $reporter->name['en'] . " news",
            'reporter' => $reporter,
        ];
        return view('admin/news/news-list', $data);
    }

    protected function validateProfileForm($profile_info = null)
    {


        $data = [
            'en_name' => 'required|string|min:3|max:190',
            'np_name' => 'required|string|min:3|max:190',
            'email' => 'required|email|min:3|max:190|unique:users,email,' . $profile_info->user_id . '|unique:reporters,email,' . $profile_info->id,
            'phone' => 'nullable|string|min:3|max:190',
            'address' => 'nullable|string|min:3|max:190',
            'publish_status' => 'required|numeric|in:1,0',
            "facebook" => "nullable|string|max:190",
            "twitter" => "nullable|max:150",
            "designation" => "nullable|string|max:150",
            // 'user_type' => 'required|string|in:admin,reporter,receptionist,accountant'
        ];
        if (!$profile_info) {
            $password_data = [
                // 'password' => 'required|required_with:confirm_password|same:confirm_password|min:8|max:190',
                // 'confirm_password' => 'required',
            ];
            // $data = array_merge($password_data, $data);

        }
        return $data;
    }

    protected function getProfile($request)
    {
        $query = $this->reporter->orderBy('id', 'DESC');
        if ($request->keyword) {
            $keyword = $request->keyword;
            $query = $query->where('title', $keyword);
        }
        return $query->paginate(20);
    }
    public function index(Request $request)
    {

        $data = $this->getProfile($request);

        // $roles = Role::pluck('name', 'name')->all();
        // dd($data);
        // $data = [
        //     'data' => $data,
        //     'roles' => $roles,
        // ];

        return view('admin/profile/reporter-list', compact('data'));
    }

    public function create()
    {
        $title = 'Add Reporter ';
        $userRole = request()->user()->roles->first()->name;

        $data = [
            'title' => $title,
            'profile_info' => null,
        ];

        return view('admin/profile/reporter-form')->with($data);
    }
    protected function mapUserData($request, $user_info = null)
    {
        $slug = $this->checkUniqueSlug($request->en_name ?? $request->np_name, 'users');
        $data = [
            'name' => [
                'en' => $request->en_name ?? $request->np_name,
                'np' => $request->np_name ?? $request->en_name,
            ],
            'email' => $request->email,
            // 'password' => Hash::make($request->password),
            'publish_status' => $request->publish_status,
            'created_by' => auth()->id(),
            'slug' => $slug

        ];



        if (!$user_info) {
            $data['password'] = Hash::make($request->password);
        }
        return $data;
    }
    protected function mapProfileData($request, $user = null, $profileInfo = null)
    {
        // dd($request->all());
        $slug = $this->checkUniqueSlug($request->en_name ?? $request->np_name);
        $data = [
            'name' => [
                'en' => $request->en_name ?? $request->np_name,
                'np' => $request->np_name ?? $request->en_name,
            ],
            'email' => $request->email,
            'publish_status' => $request->publish_status,
            'phone' => $request->phone,
            'facebook' => $request->facebook,
            'twitter' => $request->twitter,
            'slug' => $slug,
            'slug_url' => $slug,
            'address' => $request->address,
            'designation' => $request->designation,
            'allow_to_login' => false,
        ];
        if ($user) {
            $data['user_id'] = @$user->id;
            $data['allow_to_login'] = true;
        }
        if (!$profileInfo) {
            $data['created_by'] = auth()->id();
        } else {
            $data['updated_by'] = auth()->id();
        }

        if ($request->profile_image_url && !empty($request->profile_image_url)) {
            $image = get_image_url($request->profile_image_url);
            $data['profile_image_url'] = $image ?? @$profileInfo->profile_image_url ?? null;
        }
        return $data;
    }

    public function store(Request $request)
    {
        $this->validate($request, $this->validateProfileForm($this->reporter));
        // dd($request->all());
        if ($request->allow_to_login) {
            $user_data = $this->mapUserData($request);
        }
        DB::beginTransaction();
        try {
            $user = null;
            if ($request->allow_to_login) {
                $reporter_role = Role::where('name', 'Reporter')->first();
                // dd($reporter_role);
                $user = User::create($user_data);
                $user->assignRole([$reporter_role->id]);
            }
            $profile_data = $this->mapProfileData($request, $user);
            // $profile_data = array_merge($profile_data);
            $profile = Reporter::create($profile_data);
            DB::commit();
            $request->session()->flash('success', 'Profile created successfully.');
            return redirect()->route('reporters.index');
        } catch (\Exception $error) {
            DB::rollBack();
            $request->session()->flash('error', $error->getMessage());
            return redirect()->back();
        }
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $profile_info = $this->reporter->find($id);
        abort_if(!$profile_info, 404, 'Invalid reporter inforamtion or reporter not found.');

        $title = 'Update Reporter profile ';

        $data = [
            'title' => $title,
            'profile_info' => $profile_info,
        ];
        // dd($profile_info);

        return view('admin/profile/reporter-form')->with($data);
    }

    public function update(Request $request, $id)
    {
        // dd($request->all());
        $profile_info = $this->reporter->with('get_user')->find($id);
        if (!$profile_info) {
            abort(404);
        }
        $this->validate($request, $this->validateProfileForm($profile_info));
        $user_data = $this->mapUserData($request, $profile_info->get_user, $profile_info);
        if ($profile_info->user) {
            unset($user_data['email']);
        }
        DB::beginTransaction();
        try {
            if ($profile_info->user) {
                $profile_info->user->update($user_data);
            } elseif ($request->allow_to_login && !$profile_info->user) {

                $this->user->fill($user_data)->save();
            }
            $profile_data = $this->mapProfileData($request, $profile_info->user, $profile_info);
            // dd($profile_data);
            $profile_info->fill($profile_data)->save();

            DB::commit();
            $request->session()->flash('success', 'Reporter profile updated  successfully.');
            return redirect()->route('reporters.index');
        } catch (\Exception $error) {
            DB::rollBack();
            $request->session()->flash('error', $error->getMessage());
            return redirect()->back();
        }
    }

    public function destroy(Request $request, $id)
    {
        $profile_info = $this->reporter->find($id);
        if (!$profile_info) {
            abort(404);
        }
        DB::beginTransaction();
        try {
            if ($profile_info->allow_to_login == '1') {
                // dd('i am here');
                $user = $this->user->find($profile_info->user_id);
                if (!$user || $user->id == request()->user()->id) {
                    request()->session()->flash('error', 'Eror ! You Can Not Delete Your Self');
                    return redirect()->back();
                }
                $status = $user->delete();
                if ($status) {
                    request()->session()->flash('success', "Login crecedential also deleted");
                } else {
                    request()->session()->flash('error', "Sorry! Error While Deleting Login Crecendential");
                    return redirect()->back();
                }
            }

            $profile_info->delete();
            $request->session()->flash('success', 'Reporter removed successfully.');
            DB::commit();
        } catch (\Exception $error) {
            DB::rollBack();
            $request->session()->flash('error', $error->getMessage());
        }
        return redirect()->back();
    }

    public function newsByReporter(Request $request, $slug)
    {
        $news_user = $this->reporter->where('slug', $slug)->orWhere('slug_url', $slug)->first();
        abort_if(!$news_user, 404);
        // dd($reporter);
        $reporter_news = News::whereHas('newsHasReporter', function ($qr) use ($news_user) {
            return $qr->where('reporterId', $news_user->id);
        })
            ->paginate(10);
        // dd($reporter_news);
        $data =  [
            'news_user' => $news_user,
            'news_users_news' => $reporter_news,
        ];
        return view('admin.profile.reporter-news', $data);
    }
    protected function checkUniqueSlug($user, $table = 'reporters')
    {


        $slug = DB::table($table)->where('slug',  Str::slug($user))->first();
        if (!$slug) {
            return Str::slug($user);
        } else {
            return Str::slug($user) . '-' . Str::random(3);
        }
    }
}
