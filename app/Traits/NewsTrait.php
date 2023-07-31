<?php
namespace App\Traits;

use Illuminate\Http\Request;

/**
 *
 */
trait NewsTrait
{

    protected function getNewsCreatingData()
    {
        $news_category = $this->getCategory();
        $guestlist = $this->getGuest();
        $reporters = $this->getReporter();
        // dd($reporters);
        $data = [
            'newsInfo' => null,
            'pageTitle' => 'Add News',
            "reporters" => $reporters,
            // "tags" => $tags,
            "guestlist" => $guestlist,
            "news_category" => $news_category,

        ];
        return $data;
    }

    public function createNewsInEnglish(Request $request)
    {

        // dd($guestlist);
        $data = $this->getNewsCreatingData();
        $data['newsRoute'] = "createNewsInEnglish";
        $data['banner_type'] = $this->banner_type;

        return view('admin/news/english-nepali-news-form', $data);
    }

    public function createNewsInNepali(Request $request)
    {
        $data = $this->getNewsCreatingData();
        $data['newsRoute'] = "createNewsInNepali";
        $data['banner_type'] = $this->banner_type;

        return view('admin/news/english-nepali-news-form', $data);
    }

    public function editNewsInEnglish(Request $request, $id)
    {

    }
    public function editNewsInNepali(Request $request)
    {

    }

    public function getNewsByAdminSearch(Request $request)
    {

        if (!isset($request->keyword) || empty($request->keyword)) {
            return response()->json([
                'status' => false,
                "message" => "News Title is required.",
            ]);
        }
        $news_items = $this->news
            ->select('id', 'title', 'created_at')
            ->where('publish_status', '1')
            ->where(function ($qr) use ($request) {
                return $qr->where('title', 'like', "%$request->keyword%");
            })
            ->orderBy('id', 'DESC')
            ->paginate(10)->appends($request->all());
        $html = view('admin.news.news-title-list', compact('news_items'))->render();
        return response()->json([
            'status' => true,
            'html' => $html,
        ]);
    }

    
}
