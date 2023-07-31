<?php

namespace App\Listeners;

use App\Models\NewsCategoryCounter;
use App\Models\TagCounter;
use Illuminate\Support\Facades\DB;
use Throwable;

class NewsTagCountListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public $tag_counter;
    public function __construct(TagCounter $tag_counter, NewsCategoryCounter $category)
    {
        //
        $this->tag_counter = $tag_counter;
        $this->category = $category;
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        //
        $news_detail = $event->news_detail;
        // dd($news_detail);
        $tags = $news_detail->tags;
        $category = $news_detail->category;
        if (count($tags)) {
            foreach ($tags as $tag) {
                // dd($tag);
                DB::beginTransaction();
                try {
                    $tag_count = $this->tag_counter
                        ->where('tagId', $tag)
                        ->where('newsId', $news_detail->id)
                        ->where('date', date('Y-m-d'))
                        ->first();
                    $data = [
                        'count' => @$tag_count->count + 1,
                        'date' => date('Y-m-d'),
                        'newsId' => $news_detail->id,
                        'tagId' => $tag,
                    ];
                    if ($tag_count) {
                        $tag_count->fill($data)->save();
                    } else {
                        $this->tag_counter->fill($data)->save();
                    }
                    DB::commit();
                } catch (Throwable $throwable) {
                    // dd($throwable);
                    continue;
                    // DB::rollback();
                }
            }
        }
        if (count($category)) {
            foreach ($category as $catId) {
                DB::beginTransaction();
                try {
                    $cat_count = $this->category
                        ->where('newsId', $news_detail->id)
                        ->where('categoryId', $catId)
                        ->where('date', date('Y-m-d'))
                        ->first();
                        $data  =[
                            "newsId" => $news_detail->id, 
                            "categoryId" => $catId, 
                            "date"=> date('Y-m-d'),
                            'count' => @$cat_count->count + 1,
                        ];
                    if ($cat_count) {
                        $cat_count->fill($data)->save();
                    } else {
                        $this->category->fill($data)->save();
                    }
                    DB::commit();
                } catch (Throwable $throwable) {

                }
            }
        }
    }
}
