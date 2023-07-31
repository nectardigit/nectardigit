<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AppSetting;
use App\Models\SmsSetting;
use App\Traits\Admin\AppSettingTrait;
use App\Traits\CacheTrait;
use App\Traits\Shared\AdminSharedTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AppSettingController extends Controller
{
    protected $appSetting;
    protected $smsSetting;
    use AdminSharedTrait;
    use CacheTrait;
    use AppSettingTrait;
    public function __construct(AppSetting $appSetting, SmsSetting $smsSetting)
    {
        $this->middleware(['role:Super Admin|Admin']);
        $this->appSetting = $appSetting;
        $this->smsSetting = $smsSetting;
        cache()->forget('sitesetting');
    }
    public function websiteContentFormat(Request $request)
    {
        $appsetting = $this->appSetting->first();
        // dd($appsetting);
        if (!$appsetting) {
            $appsetting = $this->appSetting->create();
        }
        return view('admin/setting/websiteContentFormat', compact('appsetting'));
    }
    public function setupWebsiteContentFormat(Request $request)
    {
        // dd($request->all());
        // dd( $this->appSetting);
        $appsetting = $this->appSetting->first();
        // dd($appsetting);
        if (!$appsetting) {
            $appsetting = $this->appSetting->create();
        }
        $this->validate($request, [
            'website_content_format' => 'required|string|in:English,Nepali,Other,Both',
        ]);
        try {
            // dd($appsetting);

            $appsetting->fill(['website_content_format' => $request->website_content_format])->save();
            $this->resetAppsetting();
            $request->session()->flash('success', 'Website content format setup has been updated successfully.');
            return redirect()->route('websiteContentFormat');
        } catch (\Exception $error) {
            $request->session()->flash('error', $error->getMessage());
            return redirect()->back();
        }
    }

    public function websiteContent()
    {
        $appsetting = $this->appSetting->first();
        $data = [
            'appsetting' => $appsetting,
            "website_content_item" => $appsetting->website_content_item,
            "website_available_content" => $this->website_available_content,
        ];
        return view('admin/setting/websiteContent', $data);
    }
    public function updateWebsiteContent(Request $request)
    {
        // dd($request->all());
        $appsetting = $this->appSetting->first();
        if (!$appsetting) {
            $appsetting = $this->appSetting->create();
        }
        $appsetting->website_content_item = $request->content;
        try {
            $appsetting->save();
            $request->session()->flash('success', 'Website content updated successfully.');
            $this->resetAppsetting();
            return redirect()->route('websiteContent');
        } catch (\Exception $error) {
            $request->session()->flash('error', $error->getMessage());
            return redirect()->route('websiteContent');
        }
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if ($this->appSetting) {
            $this->appSetting = $this->appSetting->orderBy('created_at', 'desc')->first();
        } else {
            $this->appSetting = [];
        }

        return view('admin.setting.app-setting')->with('site_detail', $this->appSetting);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    public function store(Request $request)
    {

        $this->validate($request, [
            'name' => 'nullable|string|min:3|max:190',
        ]);

        $data = $this->mapAppSettingData($request);

        try {
            $this->appSetting->fill($data)->save();
            $this->forgetSiteSettingCache();
            $request->session()->flash('success', 'Settings saved successfully.');
            return redirect()->route('setting.index');
        } catch (\Exception $error) {
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
        //
    }

    public function update(Request $request, $id)
    {

        $appSetting = $this->appSetting->first();
        if (!$appSetting) {
            abort(404);
        }
        // dd($request->all());
        $this->validate($request, [
            'name' => 'nullable|string|min:3|max:190',
            'address' => 'nullable|string|min:3|max:190',
            'email' => 'nullable|email|min:3|max:190',
        ]);
            $data = $this->mapAppSettingData($request, $appSetting);
        DB::beginTransaction();
        try {
            $appSetting->update($data);
            DB::commit();
            $this->forgetSiteSettingCache();
            $request->session()->flash('success', 'Settings saved successfully.');
            return redirect()->route('setting.index');
        } catch (\Exception $error) {
            DB::rollback();
            $request->session()->flash('error', $error->getMessage());
            return redirect()->back();
        }
    }

    public function editAdvertisemntDetail(Request $request){
        $appSetting = $this->appSetting->first();
        if (!$appSetting) {
            abort(404);
        }
        return view('admin.setting.update-advertisement-contact')->with('site_detail', $this->appSetting);
    }
    public function updateAdvertisemntDetail(Request $request){

    }

    public function destroy($id)
    {
        //
    }

   
}
