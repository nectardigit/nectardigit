<?php

namespace App\Http\Controllers;

use App\Models\Notice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class NoticeController extends Controller
{
    public function __construct(Notice $notice)
    {
        $this->middleware(['permission:notice-list|notice-create|notice-edit|notice-delete'], ['only' => ['index', 'store']]);
        $this->middleware(['permission:notice-create'], ['only' => ['create', 'store']]);
        $this->middleware(['permission:notice-edit'], ['only' => ['edit', 'update']]);
        $this->middleware(['permission:notice-delete'], ['only' => ['destroy']]);
        $this->notice = $notice;
    }

    protected function getQuery($request)
    {
        $query = $this->notice->orderBy('id', 'DESC');
        if ($request->keyword) {
            $keyword = $request->keyword;
            $query = $query->where('title', 'LIKE', "%{$keyword}%");
        }
        return $query->paginate(20);
    }
    public function index(Request $request)
    {
        $data = $this->getQuery($request);
        return view('admin.Notice.notice-list', compact('data'));
    }
    public function create(Request $request)
    {
        $notice_info = null;
        $title = 'Add Notice';
        return view('admin.Notice.notice-form', compact('notice_info', 'title'));
    }
    protected function noticeValidate($request)
    {
        $data = [
            "title" => "required|string|max:200",
            "description" => "required|string",
        ];
        return $data;
    }
    protected function mapNoticeData($request, $newsInfo = null)
    {
        $data = [
            "title" => $request->title,
            "position" => $request->position,
            "description" => htmlentities($request->description),
            "publish_status" => $request->publish_status ?? '0',

        ];

        if ($request->image) {
            $data['image'] = $request->image;
        }

        return $data;
    }
    public function store(Request $request)
    {
        // dd($request->tags);
        $this->validate($request, $this->noticeValidate($request));
        try {

            DB::beginTransaction();
            $data = $this->mapNoticeData($request);

           $notice = Notice::create($data);
            $request->session()->flash('success', 'Notice created successfully.');
            DB::commit();
            return redirect()->route('notice.index');
        } catch (\Exception $error) {
            DB::rollBack();
            $request->session()->flash('error', $error->getMessage());
            return redirect()->to(url()->previous());
        }
    }

    public function edit(Request $request, $id)
    {
        $notice_info = $this->notice->find($id);
        if (!$notice_info) {
            abort(404);
        }
        $title = 'Update notice';

        return view('admin.Notice.notice-form', compact('notice_info', 'title'));
    }

    public function update(Request $request, $id)
    {
        $notice_info = $this->notice->find($id);
        if (!$notice_info) {
            abort(404);
        }
        $this->validate($request, $this->noticeValidate($request));
        try {
            DB::beginTransaction();
            $data = $this->mapNoticeData($request);
            $notice_info->fill($data)->save();

            $request->session()->flash('success', 'Notice updated successfully.');
            DB::commit();
            return redirect()->route('notice.index');
        } catch (\Exception $error) {
            DB::rollback();
            $request->session()->flash('error', $error->getMessage());
            return redirect()->back();
        }
    }

    public function destroy(Request $request, $id)
    {
        $notice_info = $this->notice->find($id);
        if (!$notice_info) {
            abort(404);
        }
        try {
            $notice_info->delete();
            $request->session()->flash('success', 'Notice deleted successfully.');
            return redirect()->route('notice.index');
        } catch (\Exception $error) {
            $request->session()->flash('error', $error->getMessage());
            return redirect()->back();
        }
    }


    public function changeStatus(Request $request)
    {
        $this->notice->find($request->id)->update(['publish_status' => $request->status]);
    }
}
