<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Video;
use App\Models\AppSetting;
use App\Traits\NewsDetailTrait;
use App\Traits\SharedTrait;
use Illuminate\Http\Request;

class VideoController extends Controller
{

    use NewsDetailTrait;
    use SharedTrait;
    public function __construct(Video $video)
    {
        $this->video = $video;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function getVideo()
    {
        $meta = $this->getMetaData();
        $mainVideo = $this->video
            ->where('publish_status', true)
            // ->where('featured', '1')
            ->orderBy('created_at', 'desc')
            ->orderBy('featured', 'DESC')
            ->first();
        // dd($mainVideo);
        $videos = $this->video
            ->where('publish_status', true)
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get();
        $videoId = $videos->pluck('id');
        if ($mainVideo) {
            $videoId->push($mainVideo->id);
        }
        $videoId = $videoId->toArray() ?? [];
        // $videoId = $videos->count() ? $videos->pluck('id')->push($mainVideo->id ?)->toArray() : [];
        return view('website.video', compact('meta', 'videos', 'mainVideo', 'videoId'));
    }
    public function videoDetail(Request $request, $videoId)
    {
        $video_detail = $this->video
            ->where('publish_status', true)
            ->where('videoId', $videoId)
            ->orderBy('created_at', 'desc')
            ->orderBy('featured', 'DESC')
            ->first();
        if (!$video_detail) {
            return redirect()->route('frontendVideo');
        }


        // $this->news->where('slug',$slug)->increment('view_count');
        // dd($news_detail);
        // if($news_detail){
        //     $this->news->where('slug',$slug)->increment('view_count');
        // }

        $advertisements = $this->getNewsDetailAdvertisement();
        // dd($advertisements);
        $data['news_detail']  = $video_detail;

        $data = array_merge($data, $advertisements);

        $html = view('layouts.news-inner-advertise')->with("inside_content_ad", $data['inside_content_ad'])->render();


        // dd($add_to_read_news);

        // dd($news_detail->description['np']);
        $website = cache()->remember('setting', now()->addMinutes(20), function(){
            return AppSetting::select('*')->orderBy('created_at', 'desc')->first();
        });
        // dd($video_detail);
        $data =  [
            'title' => @$video_detail->title['np'],
            'news_detail' => $video_detail,
            'meta' => [
                'meta_title' =>  @$video_detail->title['np'] ?? 'capital Nepal',
                'meta_keyword' => @$video_detail->title['np'] ?? 'Capital Nepal Videos ',
                'meta_description' =>  parse_description($video_detail, false, 200) ?? @$website->meta_description ?? null,
                'meta_keyphrase' => @$video_detail->meta->title['np'] ?? 'capital-keyphrase',
                'og_image' => create_image_url(@$video_detail->image, 'banner') ?? 'capital-og_image',
                'og_url' => route('videoDetail', $video_detail->videoId),
                'og_site_name' => $website->name,
            ]
        ];
        $content = $this->injectAdvertisementInsideContent($video_detail, $html);

        $data['content'] = $content;
        $data['meta'] = $this->getMetaData($video_detail);
        // $meta = [
        //     'meta_title' =>  @$website->meta_title ?? 'capital Nepal',
        //     'meta_keyword' => @$website->meta_keyword ?? 'Capital Nepal Videos ',
        //     'meta_description' =>   @$website->meta_description ?? 'capital-description',
        //     'meta_keyphrase' => @$website->meta->keyphrase ?? 'capital-keyphrase',
        //     'og_image' => create_image_url(@$website->og_image, 'banner') ?? 'capital-og_image',
        //     'og_url' => route('frontendVideo'),
        //     'og_site_name' => $website->name,
        // ];
        
        return view('website.video-detail', $data);
    }
    protected function getMetaData()
    {
        $website = AppSetting::select('*')->orderBy('created_at', 'desc')->first();
        // dd($website);

        $meta = [
            'meta_title' =>  @$website->meta_title ?? 'capital Nepal',
            'meta_keyword' => @$website->meta_keyword ?? 'Capital Nepal Videos ',
            'meta_description' =>   @$website->meta_description ?? 'capital-description',
            'meta_keyphrase' => @$website->meta->keyphrase ?? 'capital-keyphrase',
            'og_image' => create_image_url(@$website->og_image, 'banner') ?? 'capital-og_image',
            'og_url' => route('frontendVideo'),
            'og_site_name' => $website->name,
        ];

        return $meta;
    }
    protected function injectAdvertisementInsideContent($news_detail, $ad_html, $add_to_read_html = null)
    {
        $content = html_entity_decode($news_detail->description['np']);
        // dd($content);
        $content = explode("</p>", $content);
        $paragraphAfter = 1; //display after the first paragraph
        foreach ($content as $key => $content_data) {
            if ($key == $paragraphAfter) {
                $content[$key] = $content_data . "</p><p>" . $ad_html;
            } else {
                $content[$key] = $content_data;
            }
            if ($key == 3 && $add_to_read_html) {
                $content[$key] = $content_data . "</p><p>" . $add_to_read_html;
            }
            // dd($content_data);
        }
        $content = implode("</p>", $content);
        // dd($content);
        return $content;
    }
}
