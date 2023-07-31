<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\News;
use App\Models\User;
use App\Models\Reporter;
use App\Models\Advertisement;
use App\Utilities\LogActivity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Str;


class UserController extends Controller
{
    protected $user;
    public function __construct(User $user, Reporter $reporter)
    {
        /* 'role:Super Admin', */
        $this->middleware(['role:Super Admin|Admin', 'permission:user-list|user-create|user-edit|user-delete'], ['only' => ['index', 'store']]);
        $this->middleware(['role:Super Admin|Admin', 'permission:user-create'], ['only' => ['create', 'store']]);
        $this->middleware(['role:Super Admin|Admin', 'permission:user-edit'], ['only' => ['edit', 'update']]);
        $this->middleware(['role:Super Admin|Admin', 'permission:user-delete'], ['only' => ['destroy']]);
        $this->user = $user;
        $this->reporter = $reporter;
        $this->get_web();
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $userRole = request()->user()->roles->first()->name;
        // if ($userRole != 'Super Admin') {
        //     return $user->hasRole('Super Admin');
        // }
        if ($userRole == 'Super Admin') {
            $all_users = $this->user

                ->with(['roles'])
                ->orderBy('id', 'ASC')
                ->paginate();
        }
        if ($userRole == 'Admin') {
            $all_users = $this->user
                ->whereHas('roles', function ($query) {
                    $query->where('name', '!=', 'Super Admin');
                })
                ->with(['roles'])
                // ->whereDoesntHave('roles')
                ->orderBy('id', 'ASC')
                ->paginate();
        }
        if ($userRole == 'Reporter') {
            $all_users = $this->user
                ->whereHas('roles', function ($query) {
                    $query->where('name', '!=', 'Super Admin')->where('name', '!=', 'Admin');
                })
                ->with(['roles'])
                // ->whereDoesntHave('roles')
                ->orderBy('id', 'ASC')
                ->paginate();
        }
        if ($request->type == 'admin') {
            $all_users = $this->user
                ->whereHas('roles', function ($query) {
                    $query->where('name', '=', 'Admin');
                })
                ->orderBy('id', 'ASC')
                ->paginate();
        }


        // $all_users = $all_users->reject(function ($user, $key) use ($userRole) {
        //     if ($userRole != 'Super Admin') {
        //         return $user->hasRole('Super Admin');
        //     }
        // });
        // $users = \App\User::with('roles')->get();
        // $nonmembers = $users->reject(function ($user, $key) {
        //     return $user->hasRole('Member');
        // });
        // foreach ($all_users as $user) {
        //     if ($userRole != 'Super Admin') {
        //         if (in_array('Super Admin', $user->getRoleNames()->toArray())) {
        //             dd($user->getRoleNames()->toArray());
        //             unset($user);
        //         }
        //     }
        // }
        return view('admin.users.user-list')->with('data', $all_users, 'userRole', $userRole);
    }
    protected function getRoleList()
    {
        $userRole = request()->user()->roles->first()->name;
        $roles = Role::pluck('name', 'name')->all();
        // dd($userRole);
        if ($userRole != 'Super Admin') {
            $roles = Role::whereNotIn('name', ['Super Admin'])->pluck('name', 'name')->all();
            // dd($roles);
            // dd($roles);
        }
        return $roles;
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = $this->getRoleList();

        return view('admin.users.user-form', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {


        $rules = $this->user->getRules();

        $request->validate($rules);
        $data = [
            'name' => [
                'en' => $request->en_name ?? $request->np_name,
                'np' => $request->np_name ?? $request->en_name,
            ],
            'publish_status' => $request->publish_status,
            'email' => $request->email,
        ];
        $data['slug'] = $this->checkUniqueSlug($request->en_name ?? $request->np_name);
        $data['password'] = Hash::make($request->password);
        $data['type'] = 'admin';
        // dd($data);
        $this->user->fill($data);
        $status = $this->user->save();
        // dd($this->user);
        if (in_array('Reporter', $request->roles)) {
            $profile_data = [
                'name' => [
                    'en' => $request->en_name ?? $request->np_name,
                    'np' => $request->np_name ?? $request->en_name,
                ],
                'email' => $request->email,
                'slug' => $this->checkUniqueSlug($request->en_name ?? $request->np_name),
                'slug_url' => $this->checkUniqueSlug($request->en_name ?? $request->np_name),
                'allow_to_login' => '1',
                'user_id' => $this->user->id,
                'publish_status' => $request->publish_status
                // 'user_id' =>
            ];
            $profile = Reporter::create($profile_data);
        }
        if ($status) {
            $this->user->assignRole($request->input('roles'));
            //$this->user->sendEmailVerificationNotification();
            $request->session()->flash('success', "User Created Successfully");
        } else {
            $request->session()->flash('error', "Sorry! Error While Adding the new user");
        }
        return redirect()->route('users.index');
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
    public function edit($id)
    {
        $this->user = $this->user->find($id);
        if (!$this->user) {
            request()->session()->flash('error', 'Error ! User Not Found');
            return redirect()->back();
        }
        $roles = $this->getRoleList();
        $userRole = $this->user->roles->pluck('name', 'name')->all();
        return view('admin.users.user-form', compact('roles', 'userRole'))->with('user_detail', $this->user);
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

        $this->user = $this->user->find($id);
        if (!$this->user) {
            request()->session()->flash('error', 'Eror ! User Not Found');
            return redirect()->back();
        }
        $rules = $this->user->getRules('update', $id);
        $request->validate($rules);
        $data = [
            'name' => [
                'en' => $request->en_name ?? $request->np_name,
                'np' => $request->np_name ?? $request->en_name,
            ],
            'publish_status' => $request->publish_status,
        ];
        // dd($data);
        if (isset($request->change_password)) {
            $data['password'] = Hash::make($request->password);
        } else {
            $data['password'] = $this->user->password; //if password comes blank set old password
        }
        if (!$this->user->slug) {
            $data['slug'] = $this->checkUniqueSlug($request->en_name ?? $request->np_name);
        }
        $this->user->fill($data);

        $this->updateReporter($request, $this->user);

        $status = $this->user->save();
        if ($status) {
            DB::table('model_has_roles')->where('model_id', $id)->delete();
            $this->user->assignRole($request->input('roles'));
            $request->session()->flash('success', "User Updated Successfully");
        } else {
            $request->session()->flash('error', "Sorry! Error While Updating the user");
        }
        return redirect()->route('users.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->user = $this->user->find($id);
        if (!$this->user || $this->user->id == request()->user()->id) {
            request()->session()->flash('error', 'Eror ! You Can Not Delete Your Self');
            return redirect()->back();
        }
        $status = $this->user->delete();
        if ($this->user->reporter) {
            $this->user->reporter->delete();
        }
        if ($status) {
            request()->session()->flash('success', "User Deleted Successfully");
        } else {
            request()->session()->flash('error', "Sorry! Error While Deleting the new user");
        }
        return redirect()->route('users.index');
    }

    /**
     * update profile
     *
     * @return void
     */
    public function profiledetail()
    {
        $userRole = request()->user()->roles->first()->name;

        $news = News::where('created_by', auth()->user()->id)->count();
        $advertisement = Advertisement::where('created_by', auth()->user()->id)->count();
        // if($userRole == 'Reporter'){
        //     dd(Reporter::where('id', auth()->user()->id))->first();
        // }

        // dd($advertisement);
        return view('admin.auth.profile', compact('news', 'advertisement'));
    }

    /**
     * Undocumented function
     *
     * @param Request $request
     * @param [type] $id
     * @return void
     */

    public function updatePassword(Request $request, $id)
    {
        $this->validate($request, [
            'current_password' => 'required',
            'password_confirmation' => 'required',
            'password' => 'required|string|min:8|confirmed|different:current_password|regex:' . $this->user->regex(),
        ]);
        $this->user = $this->user->find($id);
        if (!$this->user) {
            $request->session()->flash('error', 'User not found');
            return redirect(route('users.index'));
        }
        $data = $request->except('name');
        // dd($data);
        if (!Hash::check($data['current_password'], auth()->user()->password)) {
            return back()->with('warning', 'Current Password Not Matched.');
        } else {
            $data['password'] = Hash::make($request->password);
            $this->user->fill($data);
            $status = $this->user->save();
            if ($status) {
                LogActivity::addToLog("Password Changed Successfully");
                $request->session()->flash('success', 'Password Updated Successfully');
            } else {
                $request->session()->flash('error', 'Sorry! Error While Updating the Password');
            }
            Auth::logout();
            return redirect()->route('dashboard.index');
        }
    }

    /**
     *  logout user
     * @param Request $request
     * @return void
     */

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->flush();
        $request->session()->regenerate();
        return redirect('/login');
    }

    /**
     * 2FA Recovery function
     *
     * @return void
     */

    public function recovery()
    {
        return view('admin.auth.two-factor-recovery');
    }
    public function ban($id)
    {
        User::where('id', $id)->update(['status' => '2']);
        return redirect()->back();
    }
    public function unban($id)
    {
        User::where('id', $id)->update(['status' => '1']);
        return redirect()->back();
    }
    public function usersNews(Request $request, $slug)
    {
        $news_user =  $this->user->where('id', $slug)
            // ->orWhere('slug', $slug)
            ->first();
        // dd($news_user);
        abort_if(!$news_user, 404);
        $news_users_news  = News::where('userId', $news_user->id)
            ->with('newsHasCategories')
            ->paginate(10);
        // dd($news_users_news);
        $data =  [
            'news_user' => $news_user,
            'news_users_news' => $news_users_news,
        ];
        return view('admin.profile.reporter-news', $data);
    }

    protected function checkUniqueSlug($user)
    {

        $slug = User::where('slug',  Str::slug($user))->first();
        if (!$slug) {
            return Str::slug($user);
        } else {
            return Str::slug($user) . '-' . Str::random(3);
        }
    }

    protected function updateReporter($request, $user)
    {
        if (in_array('Reporter', $request->roles)) {
            $profile_data = [
                'name' => [
                    'en' => $request->en_name ?? $request->np_name,
                    'np' => $request->np_name ?? $request->en_name,
                ],
                'email' => $user->email,
                'slug' => $this->checkUniqueSlug($request->en_name ?? $request->np_name),
                'slug_url' => $this->checkUniqueSlug($request->en_name ?? $request->np_name),
                'allow_to_login' => '1',
                'user_id' => $user->id,
                'publish_status' => $request->publish_status
                // 'user_id' =>
            ];
            $user->reporter ? $user->reporter->update($profile_data) : $this->reporter->fill($profile_data)->save();
        } elseif (!in_array('Reporter', $request->roles) && $user->roles->pluck('name')->contains('Reporter')) {
            DB::table('reporters')->where('user_id', $user->id)->delete();
        }


        return true;
    }
}
