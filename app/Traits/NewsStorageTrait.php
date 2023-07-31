<?php

namespace App\Traits;

use App\Models\NewsGuest;
use App\Models\Tag;
use App\Models\User;
use App\Models\Reporter;
use Spatie\Async\Pool;
use URL;

/**
 *
 */
trait NewsStorageTrait
{
    protected function getQuery($request)
    {

        $userRole = request()->user()->roles->first()->name;

        $limit = 10;
        if ($request->limit && $request->limit > 0 && $request->limit < 150) {
            $limit = $request->limit;
        }

        if ($request->status == '1') {
            $news = $this->news->where('publish_status', '1');
        } elseif ($request->status == '0') {
            $news = $this->news->where('publish_status', '0');
        } else {
            $news = $this->news;
        }


        $news = $news
            // ->select('id', 'title', 'thumbnail', 'path', 'publish_status')
            ->when($request->keyword, function ($qr) use ($request, $userRole) {
                if ($userRole == 'Super Admin' || $userRole == 'Admin') {
                    return $qr->where('title', 'like', "%$request->keyword%")
                        ->orWhere('description', 'like', "%$request->keyword%")
                        ->orWhere('oldId', 'like', "%$request->keyword%");
                } else {
                    return $qr->where('created_by', auth()->user()->id)
                        ->where('title', 'like', "%$request->keyword%");
                    //     ->orWhere(function($query) use ($request) {
                    //         $query->where('title', 'like', "%$request->keyword%")
                    //               ->where('description', 'like', "%$request->keyword%");

                    //     })
                }
            })
            ->when($request->start_date, function ($qr) use ($request) {
                $start_date  = date('Y-m-d 00:00:00', strtotime(dateeng($request->start_date)));
                $end_date  = date('Y-m-d 23:59:59', strtotime(dateeng($request->end_date)));
                // dd($start_date);
                if ($request->end_date) {
                    return $qr->whereBetween('published_at', [$start_date, $end_date]);
                }
                return $qr;
            })
            ->with([
                'newsHasTags', 'getreporter:id,name',
                // 'newsHasCategories' => fn ($qr) => $qr->select('news_categories.id', 'menus.title', 'newsId', 'categoryId')
            ])
            ->where(function ($qr) use ($userRole) {
                // dd($userRole);
                if ($userRole != 'Super Admin' && $userRole != 'Admin') {
                    return $qr->where('created_by', auth()->user()->id);
                }
            })
            ->where('deleted_at', null)
            ->orderBy('id', 'DESC')
            ->orderBy('published_at', 'DESC')
            // ->orderBy('id', 'DESC')
            ->paginate($limit);
        // dd($news);


        $news->appends($request->all());
        return $news;
    }

    protected function getCategory()
    {
        $news_category = $this->menu->select('id', 'title', 'title')
            ->where('content_type', 'category')
            ->where('publish_status', '1')
            // ->orderBy('title')
            // ->get();

            ->get();
        $cat_items = [];
        foreach ($news_category as $category) {
            $cat_items[$category->id] = $category->title[$this->locale];
        }
        // dd($cat_items);

        return $cat_items;
    }

    protected function getTags()
    {
        $tags =  Tag::select('id', 'title')
            ->get();

        $tag_items = [];
        foreach ($tags as $tag) {
            $tag_items[$tag->id] = $tag->title[$this->locale];
        }
        return $tag_items;
        // ->pluck(app()->getLocale() . '_title', 'id');
    }
    protected function getGuest()
    {
        $guestlist = NewsGuest::select('id', 'name')
            ->where('publish_status', '1')
            ->get();
        $guest_items = [];
        foreach ($guestlist as $guest_item) {
            $guest_items[$guest_item->id] = $guest_item->name[$this->locale];
        }
        return $guest_items;

        // return $guestlist;
    }
    protected function getReporter()
    {
        // dd($reporters);

        $reporters = Reporter::select('id', 'name')->get();
        // ->pluck(app()->getLocale() . '_name', 'id');
        // dd($reporters);
        $data = [];
        if ($reporters) {
            foreach ($reporters as $report) {
                $data[$report->id] = $report->name[$this->locale];

                // dd( $report->getRoleNames()->toArray());
                // if (in_array('Reporter', $report->getRoleNames()->toArray()) && ($report->name[$this->locale])) {

                //     $data[$report->id] = $report->name[$this->locale];
                //     // [ => ];

                // }
                // if (!in_array('Reporter', $report->getRoleNames()->toArray()) || $report->np_name == null) {
                //     unset($report);
                // }

            }
        }
        // dd($data);
        return $data;
    }

    protected function newsValidate($newsInfo = null)
    {
        // dd($this->_website);
        if ($this->_website == 'Both') {
            $old_route = app('router')->getRoutes()->match(app('request')->create(URL::previous()))->getName();
            if ($old_route == 'createNewsInNepali' || $old_route == 'editNewsInNepali') {
                $data = [
                    "np_title" => "required|string|max:200",

                    "np_description" => "required|string",

                ];
            } else if ($old_route == 'createNewsInEnglish' || $old_route == 'editNewsInEnglish') {
                $data = [

                    "en_title" => "required|string|max:200",

                    "en_description" => "required|string",
                ];
            } else {
                $data = [
                    "np_title" => "required|string|max:200",
                    "en_title" => "required|string|max:200",
                    "np_description" => "required|string",
                    "en_description" => "required|string",
                ];
            }
        } else if ($this->_website == 'Nepali') {
            $data = [
                "np_title" => "required|string|max:200",
                "en_title" => "nullable|string|max:200",
                "np_description" => "required|string",
                "en_description" => "nullable|string",
            ];
        } else if ($this->_website == 'English') {
            $data = [
                "en_title" => "nullable|string|max:200",
                "en_description" => "nullable|string",
            ];
        }
        //  dd($data);
        $data['publish_status'] = "nullable|in:0,1,2";
        $data['meta_title'] = "nullable|string|max:300";
        $data['meta_keyword'] = "nullable|string|max:300";
        $data['meta_keyphrase'] = "nullable|string|max:300";
        $data['category.*'] = "required|numeric|exists:menus,id";
        // dd(request()->all());
        if ($newsInfo) {
            // $data[''] =
        }
        return $data;
    }
    public function updateImage($request, $newsInfo)
    {
        $imagepath = getImageFromUrl($request->thumbnail);
        $path = explode('/uploads/', $request->thumbnail);
        //  dd(getExt(".".@$request->thumbnail));
        $imagedata = [
            'url' => $request->thumbnail,
            'path' => @$path[1],
            'folder_path' => $imagepath['path'],
            'contentId' => $newsInfo->id,
            'table' => 'news',
            // 'urls' => [''],
            'name' => str_replace("." . getExt(@$request->thumbnail), '', @$imagepath['image']),
            'extension' => getExt($request->thumbnail),
        ];
        // dd($imagedata);
        // dd($imagedata);
        $image = ProjectImage::where('contentId', $newsInfo->id)->where('table', 'news')->first();
        if ($image) {
            $image->fill($imagedata)->save();
        } else {
            ProjectImage::create($imagedata);
        }
    }
    protected function updateNewsTag($news, $request)
    {
        $news->newsHasTags()->sync($request->tags);
        // dd($request->all());
        // if (isset($request->tags) && count($request->tags)) {

        //     foreach ($request->tags as $tag) {

        //         // dd($cat);
        //         $cat_data = [
        //             'newsId' => $news->id,
        //             'tagId' => (int) $tag,
        //         ];
        //         // dd($cat_data);
        //         $tagInfo = $this->news_tag->where('newsId', $news->id)->where('tagId', (int) $tag)->first();
        //         if ($tagInfo) {
        //             $tagInfo->fill($cat_data)->save();
        //         } else {
        //             $this->news_tag->create($cat_data);
        //             //   dd($test);
        //         }
        //         // $news->categories()->sync([ "newsId" => $news->id, $request->category]);


        //     }

        //     // dd($news);
        //     $removable_tags = $this->news_tag
        //         ->where('newsId', $news->id)
        //         ->where(function ($qr) use ($request) {
        //             return $qr->whereNoTIn('tagId', $request->tags)
        //                 ->orWhere('tagId', null);
        //         })
        //         ->delete();
        // }
    }
    protected function updateCategory($news, $request)
    {

        $news->newsHasCategories()->sync($request->category);
        // if (isset($request->category) && count($request->category)) {
        //     foreach ($request->category as $cat) {

        //         $cat_data = [
        //             'newsId' => $news->id,
        //             'categoryId' => (int) $cat,
        //         ];
        //         // dd($cat_data);
        //         $cat_info = $this->news_category->where('newsId', $news->id)->where('categoryId', (int) $cat)->first();
        //         if ($cat_info) {
        //             $cat_info->fill($cat_data)->save();
        //         } else {
        //             $this->news_category->create($cat_data);
        //             //   dd($test);
        //         }
        //         // $news->categories()->sync([ "newsId" => $news->id, $request->category]);


        //     }

        //     $this->news_category
        //         ->where('newsId', $news->id)
        //         ->where(function ($qr) use ($request) {
        //             return $qr->whereNoTIn('categoryId', $request->category)
        //                 ->orWhere('categoryId', null);
        //         })
        //         ->delete();
        // }
    }
    protected function updateReporter($news, $request)
    {

        $news->newsHasReporter()->sync($request->reporters);
        // if (isset($request->reporters) && count($request->reporters)) {
        //     foreach ($request->reporters as $reporter) {
        // // dd($reporter);


        //         $reporter_data = [
        //             'newsId' => $news->id,
        //             'reporterId' => (int) $reporter,
        //         ];
        //         // dd($cat_data);
        //         $reporter_info = $this->news_reporter->where('newsId', $news->id)->where('reporterId', (int) $reporter)->first();
        //         // dd($reporter_info);
        //         if ($reporter_info) {
        //             $reporter_info->fill($reporter_data)->save();
        //         } else {
        //             $this->news_reporter->create($reporter_data);
        //         }
        //         // $news->categories()->sync([ "newsId" => $news->id, $request->category]);


        //     }

        //     $this->news_reporter
        //         ->where('newsId', $news->id)
        //         ->where(function ($qr) use ($request) {
        //             return $qr->whereNoTIn('reporterId', $request->reporters)
        //                 ->orWhere('reporterId', null);
        //         })
        //         ->delete();
        // }
    }
    protected function mapNewsData($request, $newsInfo = null)
    {

        $data = [
            "title" => [
                "np" => $request->np_title ?? $request->en_title,
                "en" => $request->en_title ?? $request->np_title,
            ],
            "description" => [
                'np' => htmlentities($request->np_description) ?? htmlentities($request->en_description),
                'en' => htmlentities($request->en_description) ?? htmlentities($request->np_description),
            ],
            "summary" => [
                'en' => htmlentities($request->en_summary) ?? htmlentities($request->np_summary),
                'np' => htmlentities($request->np_summary) ?? htmlentities($request->en_summary),
            ],

            "publish_status" => $request->publish_status ?? '0',
            "meta_title" => htmlentities($request->en_title ?? $request->np_title) ?? null,
            "meta_description" => htmlentities(str_limit($request->en_description, 180) ?? str_limit($request->en_description, 180)) ?? null,
            "meta_keyword" => htmlentities($request->en_title ?? $request->np_title) ?? null,
            "meta_keyphrase" => htmlentities($request->en_title ?? $request->np_title) ?? null,
            "category" => $request->category,
            "reporters" => $request->reporters,
            'tags' => $request->tags ? $request->tag : null,
            // banner position
            'text_position' => $request->text_position ?? 'full_banner',
            'published_at' => $request->published_at,
            'isBanner' => $request->isBreaking,
            'isBreaking' => $request->isBreaking,
            'isSpecial' => $request->isSpecial,
            'isFixed' => $request->isFixed,
            'image_show' => $request->image_show,
            'mobile_notification' => $request->mobile_notification,
            'tagLine' => $request->tagLine,
            'subtitle' => $request->subtitle,
            // "reporter" =>
            "updated_by" => auth()->id(),
            "guestId" => $request->guest ?? $newsInfo->guestId ?? null,
            "isVideo" => $request->isvideo ?? '0',
            "video" => $request->embed,
            'isPhotoFeature' => $request->isPhotoFeature,
        ];
        // dd($data);
        $userRole = request()->user()->roles->first()->name;
        if ($userRole == 'Super Admin' || $userRole == 'Admin') {
            $data['reporter'] = $request->reporter;
            $data['verified_at'] = ($newsInfo && $newsInfo->verified_at) ? $newsInfo->verified_at : now();
        }
        if ($userRole != 'Super Admin' && $userRole != 'Admin') {
            $data['reporter'] = auth()->user()->id;
        }

        // dd($request->all());
        if ($request->filepath && !empty($request->filepath)) {
            // $image = getImageFromUrl($request->filepath);
            // $data['thumbnail'] = $image ? $image['image'] : null;
            // $data['path'] = $image ? $image['path'] : null;
            $data['img_url'] = $request->filepath;
        }
        // if ($request->filepath && !empty($request->filepath)) {
        //     $imagepath = getImageFromUrl($request->filepath);
        //     if ($imagepath) {
        //         $path = explode('/uploads/', $request->filepath);
        //         //  dd(getExt(".".@$request->filepath));

        //         $data['img_url'] = $request->filepath;
        //         $data['img_name'] = str_replace("." . getExt(@$request->filepath), '', @$imagepath['image']);
        //         $data['img_extension'] = getExt($request->filepath);
        //         $data['img_path'] = @$path[1];
        //         $data['folder_path'] = $imagepath['path'];
        //     }

        // }
        $old_route = app('router')->getRoutes()->match(app('request')->create(URL::previous()))->getName();
        if ($old_route == 'createNewsInNepali' || $old_route == 'editNewsInNepali') {
            $data['news_language'] = 'np';
        } else if ($old_route == 'createNewsInEnglish' || $old_route == 'editNewsInEnglish') {
            $data['news_language'] = 'en';
        } else {
            $data['news_language'] = 'both';
        }
        // dd($data);
        return $data;
    }
    protected function updateAddToReadNews($news, $request)
    {
        if ($request->addtoreadnews && $request->addtoreadnews) {


            foreach ($request->addtoreadnews as $addtoread) {
                $data = [
                    'newsId' => $news->id,
                    'addedNewsId' => (int) $addtoread,
                ];
                // dd($cat_data);
                $addtoread_info = $this->add_to_read_news
                    ->where('newsId', $news->id)
                    ->where('addedNewsId', (int) $addtoread)
                    ->first();
                if ($addtoread_info) {
                    $addtoread_info->fill($data)->save();
                } else {
                    $this->add_to_read_news->create($data);
                    //   dd($test);
                }
            }
            $this->add_to_read_news
                ->where('newsId', $news->id)
                ->where(function ($qr) use ($request) {
                    return $qr->whereNoTIn('addedNewsId', $request->addtoreadnews)
                        ->orWhere('addedNewsId', null);
                })
                ->delete();
        } else {
            $this->add_to_read_news
                ->where('newsId', $news->id)
                ->delete();
        }
    }
}
