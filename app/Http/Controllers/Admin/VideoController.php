<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Video;
use App\Traits\CacheTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class VideoController extends Controller
{
    use CacheTrait;
    public function __construct(Video $video)
    {
        $this->get_web();
        $this->middleware(['permission:video-list|video-create|video-edit|video-delete'], ['only' => ['index', 'store']]);
        $this->middleware(['permission:video-create'], ['only' => ['create', 'store']]);
        $this->middleware(['permission:video-edit'], ['only' => ['edit', 'update']]);
        $this->middleware(['permission:video-delete'], ['only' => ['destroy']]);
        $this->Video = $video;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    protected function getVideo($request)
    {
        $query = $this->Video->orderBy('id', 'DESC');
        if ($request->keyword) {
            $keyword = $request->keyword;
            $query = $query->where('title','like', "%{$keyword}%");
        }
        return $query->paginate(20);
    }

    protected function mapVideoData($request, $videoInfo = null)
    {
        $data = [

            'title' => [
                'en' => $request->en_title ?? $request->np_title,
                'np' => $request->np_title ?? $request->en_title,
            ],
            'description' => [
                'en' => htmlentities($request->en_description) ?? htmlentities($request->np_description),
                'np' => htmlentities($request->np_description) ?? htmlentities($request->en_description),
            ],
            "publish_status" => $request->publish_status,
            'display_home'=>$request->display_home,
            'position'=>$request->position,
            'url' => $request->url,
            'created_by' => Auth::user()->id,
            'origin' => $this->getOrigin($request->url),
            'videoId' => $this->getVideoId($request->url),

        ];
        // dd($request->all());
        if ($request->image && !empty($request->image)) {
            $data['image'] = $request->image;
        }
        return $data;
    }
    protected function get_validator()
    {

        // dd($this->_website);
        if ($this->_website == 'Nepali') {
            return [
                'np_title' => "required|string|max:100",
                "np_description" => "nullable|string|",
                'publish_status' => "required|numeric|in:1,0",
                'image'=>"required",
                "url" => "required|url"
            ];
        } else if ($this->_website == 'English') {
            return [
                'en_title' => "required|string|max:100",
                'en_description' => "nullable|string",
                "publish_status" => "required|numeric|in:1,0",
                'image'=>"required",
                "url" => "required|url"

            ];
        } else if ($this->_website == 'Both') {
            return [
                'np_title' => "required|string|max:100",
                "en_title" => "required|string|max:100",
                "np_description" => "required|string",
                'en_description' => "required|string",
                "publish_status" => "required|numeric|in:1,0",
                'image'=>"required",

                "url" => "required|url"
            ];
        }
    }


    public function index(Request $request)
    {
        $data = $this->getVideo($request);
        return view('admin/video/list', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $video_info = null;
        $title = 'Add video';

        return view('admin/video/form', compact('video_info', 'title'));
    }



    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $this->validate($request, $this->get_validator());
        if (!$this->getVideoId($request->url)) {
            return redirect()->back()->with('error', 'Please provide video links');
        }
        $data = $this->mapVideoData($request);

        // dd($this->Video);
        // dd($data);
        try {
            $this->Video->fill($data)->save();
            $request->session()->flash('success', 'video added successfully.');
            $this->forgetVideoCache();
            return redirect()->route('video.index');
        } catch (\Exception $error) {
            $request->session()->flash('error', $error->getMessage());
            return redirect()->back();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Video  $video
     * @return \Illuminate\Http\Response
     */
    public function show(Video $video)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Video  $video
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        $video_info = $this->Video->find($id);
        if (!$video_info) {
            abort(404);
        }
        $title = 'Update videos';
        return view('admin/video/form', compact('video_info', 'title'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Video  $video
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $video_info = $this->Video->find($id);
        if (!$video_info) {
            abort(404);
        }
        $this->validate($request, $this->get_validator());
        if (!$this->getVideoId($request->url)) {
            return redirect()->back()->with('error', 'Please provide video links');
        }
        $data = $this->mapVideoData($request, $video_info);

        try {
            $data['updated_by'] = Auth::user()->id;
            $video_info->fill($data)->save();
            $request->session()->flash('success', 'video added successfully.');
            $this->forgetVideoCache();
            return redirect()->route('video.index');
        } catch (\Exception $error) {
            $request->session()->flash('error', $error->getMessage());
            return redirect()->back();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Video  $video
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $video_info = $this->Video->find($id);
        if (!$video_info) {
            abort(404);
        }
        try {
            $video_info->delete();

            $video_info->update(array('updated_by' => Auth::user()->id));
            $this->forgetVideoCache();
            $request->session()->flash('success', 'Video deleted successfully.');
            return redirect()->route('video.index');
        } catch (\Exception $error) {
            $request->session()->flash('error', $error->getMessage());
            return redirect()->back();
        }
    }

    public function getOrigin($url)
    {
        if (getYoutubeVideoId($url)) {
            $origin = 'youtube';
        } else if (getFacebookVideoId($url)) {
            $origin = 'facebook';
        } else {
            $origin = null;
        }

        return $origin;
    }

    public function getVideoId($url)
    {
        if (getYoutubeVideoId($url)) {
            $videoId = getYoutubeVideoId($url);
        } else if (getFacebookVideoId($url)) {
            $videoId = getFacebookVideoId($url);
        } else {
            $videoId[1] = null;
        }

        return $videoId[1];
    }

    public function changeStatus(Request $request)
    {
        $this->Video->find($request->id)->update(['publish_status'=>$request->status]);

    }
    public function changedisplayhome(Request $request)
    {
        $this->Video->find($request->id)->update(['display_home'=>$request->status]);

    }
}
