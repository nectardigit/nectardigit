<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;

class ProfileController extends Controller
{
    public function __construct(Profile $profile)
    {
        $this->middleware(['permission:profile-list|profile-create|profile-edit|profile-delete'], ['only' => ['index', 'store']]);
        $this->middleware(['permission:profile-create'], ['only' => ['create', 'store']]);
        $this->middleware(['permission:profile-edit'], ['only' => ['edit', 'update']]);
        $this->middleware(['permission:profile-delete'], ['only' => ['destroy']]);
        $this->profile = $profile;
    }
    protected function getProfile($request)
    {
        $query = $this->profile->orderBy('id', 'DESC');
        if ($request->keyword) {
            $keyword = $request->keyword;
            $query = $query->where('title', $keyword);
        }
        return $query->paginate(20);
    }
    protected function validateProfileForm($profile_info = null)
    {
        $data = [
            'en_name' => 'required|string|min:3|max:190',
            'np_name' => 'required|string|min:3|max:190',
            'email' => 'required|string|min:3|max:190',
            'phone' => 'required|string|min:3|max:190',
            'address' => 'required|string|min:3|max:190',
            'publish_status' => 'required|numeric|in:1,0',
            // 'user_type' => 'required|string|in:admin,reporter,receptionist,accountant'
        ];
        if (!$profile_info) {
            $password_data = [
                'password' => 'required|required_with:confirm_password|same:confirm_password|min:8|max:190',
                'confirm_password' => 'required',
            ];
            $data = array_merge($password_data, $data);

        }
        return $data;
    }
    public function index(Request $request)
    {

        $data = $this->getProfile($request);

        $roles = Role::pluck('name', 'name')->all();
        // dd($data);
        $data = [
            'data' => $data,
            'roles' => $roles,
        ];

        return view('admin/profile/list')->with($data);
    }

    public function create()
    {
        $profile_info = null;
        $title = 'Add User';
        $userRole = request()->user()->roles->first()->name;
        $roles = Role::pluck('name', 'name')->all();
        if ($userRole != 'Super Admin') {
            $roles = Role::whereNotIn('name', ['Super Admin'])->pluck('name', 'name')->all();
            // dd($roles);
        }
        $data = [
            'title' => $title,
            'profile_info' => $profile_info,
            'roles' => $roles,
        ];
        return view('admin/profile/form')->with($data);
    }
    protected function mapUserData($request, $user_info = null)
    {
        $data = [
            'name' => [
                'en' => $request->en_name ?? $request->np_name,
                'np' => $request->np_name ?? $request->en_name,
            ],
            'email' => $request->email,
            // 'password' => Hash::make($request->password),
            'publish_status' => $request->publish_status,
            'created_by' => auth()->id(),
        ];
        if(!$user_info){
            $data['password'] = Hash::make($request->password);
        }
        return $data;
    }
    protected function mapProfileData($request, $user, $profileInfo = null)
    {
        $data = [
            'user_id' => $user->id,
            // 'image' => $request->image_name ?? null,
            'phone' => $request->phone,
            'facebook' => $request->facebook,
            'twitter' => $request->twitter,
            'address' => $request->address,
            'designation' => $request->designation,
            'slug_url' => Str::slug($request->en_name),
        ];
        return $data;
    }

    public function store(Request $request)
    {
        // dd($request->all());
        $this->validate($request, $this->validateProfileForm());
        // dd($request->all());
        $user_data = $this->mapUserData($request);
 
        $data = [];
        if ($request->filepath && !empty($request->filepath)) {
            $imagepath = getImageFromUrl($request->filepath);

            if ($imagepath) {
                $path = explode('/uploads/', $request->filepath);
                //  dd(getExt(".".@$request->filepath));

                $data['img_url'] = $request->filepath;
                $data['img_name'] = str_replace("." . getExt(@$request->filepath), '', @$imagepath['image']);
                $data['img_extension'] = getExt($request->filepath);
                $data['img_path'] = @$path[1];
                $data['folder_path'] = $imagepath['path'];
            }
        }
        // dd($data);

        DB::beginTransaction();
        try {
            $user = User::create($user_data);
            $profile_data = $this->mapProfileData($request, $user);
            $profile_data = array_merge($profile_data, $data);
            $profile = Profile::create($profile_data);
            $user->assignRole($request->input('roles'));
            DB::commit();
            $request->session()->flash('success', 'Profile created successfully.');
            return redirect()->route('profile.index');
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
        $profile_info = $this->profile->find($id);
        if (!$profile_info) {
            abort(404);
        }
        $title = 'Edit User';
        $roles = Role::pluck('name', 'name')->all();
        $userRole = $profile_info->get_user->roles->pluck('name', 'name')->all();
        $data = [
            'title' => $title,
            'profile_info' => $profile_info,
            'roles' => $roles,
            'userRole' => $userRole,
        ];

        return view('admin/profile/form')->with($data);
    }

    public function update(Request $request, $id)
    {
        // dd($request->image_name);
        $profile_info = $this->profile->with('get_user')->find($id);
        if (!$profile_info) {
            abort(404);
        }
        // dd($profile_info);
        $this->validate($request, $this->validateProfileForm($profile_info->get_user));
        $user_data = $this->mapUserData($request, $profile_info->get_user);
        // dd($user_data);
        // $profile_info->phone = htmlentities($request->phone);
        // $profile_info->address = htmlentities($request->address);
        // $profile_info->designation = htmlentities($request->designation);
        // $profile_info->facebook = htmlentities($request->facebook);
        // $profile_info->twitter = htmlentities($request->twitter);
        $profile_info->get_user->name = [
            'en' => htmlentities($request->en_name),
            'np' => htmlentities($request->np_name),
        ];
        $profile_info->get_user->email = htmlentities($request->email);
    
        $data = [];
        if ($request->filepath && !empty($request->filepath)) {
            $imagepath = getImageFromUrl($request->filepath);
            // dd($imagepath);
            if ($imagepath) {
                $path = explode('/uploads/', $request->filepath);
                //  dd(getExt(".".@$request->filepath));

                $data['img_url'] = $request->filepath;
                $data['img_name'] = str_replace("." . getExt(@$request->filepath), '', @$imagepath['image']);
                $data['img_extension'] = getExt($request->filepath);
                $data['img_path'] = @$path[1];
                $data['folder_path'] = $imagepath['path'];
            }
        }
        DB::beginTransaction();
        try {

            // dd($data);
            $profile_data = $this->mapProfileData($request, $profile_info->get_user);
            $profile_data = array_merge($profile_data, $data);
            $profile_info->fill($profile_data)->save();
        




            $user_data = User::find($profile_info->user_id);
            $user_data->name = [
                'en' => htmlentities($request->en_name),
                'np' => htmlentities($request->np_name),
            ];
            $user_data->email = htmlentities($request->email);
            $user_data->publish_status = htmlentities($request->publish_status);
            $user_data->updated_by = auth()->id();
            $user_data->save();
            $user_data->assignRole($request->input('roles'));

            DB::commit();
            $request->session()->flash('success', 'Profile created successfully.');
            return redirect()->route('profile.index');
        } catch (\Exception $error) {
            DB::rollBack();
            $request->session()->flash('error', $error->getMessage());
            return redirect()->back();
        }
    }

    public function destroy(Request $request, $id)
    {
        $profile_info = $this->profile->find($id);
        if (!$profile_info) {
            abort(404);
        }
        DB::beginTransaction();
        try {
            $user = User::find($profile_info->user_id);
            $profile_info->phone = $profile_info->phone . '-' . time();
            $user->email = $user->email . '-' . time();
            $user->save();
            $profile_info->save();

            $profile_info->delete();
            $user->delete();
            $request->session()->flash('success', 'User removed successfully.');
            DB::commit();
        } catch (\Exception $error) {
            DB::rollBack();
            $request->session()->flash('error', $error->getMessage());
        }
        return redirect()->back();
    }
}
