<?php

namespace App\Traits;

use App\Models\Advertisement;
use App\Models\AdvertisementPosition;
use App\Models\Menu;
use Validator;

trait SharedTrait
{
    public $current_route;
    public $advertise_positions;
    // public function advertisement_position_items()
    // {
    //     // cache()->forget('advertise_positions');
    //     $advertise_positions = cache()->remember('advertise_positions', 60 * 60 * 24, function () {
    //         return AdvertisementPosition::get();
    //     });
    //     // foreach($advertise_positions as $adItems){
    //     //     $adItems->advertisements =
    //     // }
    //     // dd($advertise_positions);
    //     return $this->advertise_positions = $advertise_positions;
    // }

    public function getMenus()
    {

        cache()->forget('app_menu');
        return $menus = cache()->remember('app_menu', 60 * 60 * 24, function () {
            return Menu::select('id', 'title', 'slug', 'show_on', 'content_type', 'external_url')
                ->where('publish_status', '1')
                ->with([
                    'child_menu' => function ($qr) {
                        return $qr->select('id', 'title', 'slug', 'show_on', 'parent_id', 'content_type');
                    },
                ])

                ->orderBy('position', 'ASC')
                ->where('parent_id', null)
                ->get();
        });
    }
    public function homepageSections()
    {
        $menus = $this->getMenus();
        $homepagesection = [];
        foreach ($menus as $menuItem) {
            // dd($menus);

            if ($menuItem->show_on) {
                if (in_array('homepage', $menuItem->show_on)) {
                    $homepagesection[] = $menuItem;
                }
            }
        }
        return $homepagesection;
    }

    // all shared advertisements section
    // all shared advertisements section
    // all shared advertisements section
    // all shared advertisements section

    protected function getHeaderPositions()
    {
        $all_header = @$this->advertisement_position_items()->where('key', 'ALL_HEADER')->first();
        $all_header = $all_header ? $all_header->id : null;
        $header = null;
        // dd($this->current_route);
        if ($this->current_route == 'newsDetail') {
            $header = @$this->advertisement_position_items()->where('key', 'CONTENT_HEADER')->first()->id;
        } else if ($this->current_route == 'newsCategory') {
            $header = @$this->advertisement_position_items()->where('key', 'CATEGORY_HEADER')->first()->id;
        } else if ($this->current_route == 'index') {
            $header = @$this->advertisement_position_items()->where('key', 'HOMEPAGE_HEADER')->first()->id;
        }
        return [$all_header ?? null, $header ?? null];
    }

    protected function getMenuPositions()
    {
        $all = @$this->advertisement_position_items()->where('key', 'AFTER_ALL_HEADER')->first();
        $all = $all ? $all->id : null;
        $page_type = null;
        if ($this->current_route == 'newsDetail') {
            $page_type = @$this->advertisement_position_items()->where('key', 'AFTER_CONTENT_HEADER')->first()->id;
        } else if ($this->current_route == 'newsCategory') {
            $page_type = @$this->advertisement_position_items()->where('key', 'AFTER_CATEGORY_HEADER')->first()->id;
        } else if ($this->current_route == 'index') {
            $page_type = @$this->advertisement_position_items()->where('key', 'AFTER_HOMEPAGE_HEADER')->first()->id;
            // dd($page_type);
        }
        return [$all ?? null, $page_type ?? null];
    }

    protected function getSkipPositions()
    {
        $all = @$this->advertisement_position_items()->where('key', 'SKIP')->first();
        $all = $all ? $all->id : null;
        $page_type = null;
        if ($this->current_route == 'newsDetail') {
            $page_type = @$this->advertisement_position_items()->firstWhere('key', 'CONTENT_BLOCK')->id;
        } else if ($this->current_route == 'newsCategory') {
            $page_type = @$this->advertisement_position_items()->where('key', 'CATEGORY_BLOCK')->first()->id;
        } else if ($this->current_route == 'index') {
            $page_type = @$this->advertisement_position_items()->where('key', 'ROAD_BLOCK')->first()->id;
        }
        return [$all ?? null, $page_type ?? null];
    }

    protected function getHomepageSectionAds($sectionKey)
    {
        $all = @$this->advertisement_position_items()->where([['section', $sectionKey], ['page', 'homepage']])->first();
        $all = $all ? $all->id : null;
        $page_type = null;
        $content_ads = Advertisement::select('id', 'title', 'organization', 'url', 'position', 'columnType')
            ->where('publish_status', '1')
            ->where([['page', 'homepage'], ['section', $sectionKey]])
            ->get();

        if ($content_ads->count()) {
            $limiter = $this->advertisement_position_items()->where('id', $content_ads->first()->position)->first();
            $content_ads = $content_ads->take($limiter->quantity);
        }
        return $content_ads ? $content_ads : null;
    }

    protected function getBottomAdPositions()
    {
        $all = @$this->advertisement_position_items()->where('key', 'BOTTOM_BLOCK')->first();
        $all = $all ? $all->id : null;
        $page_type = null;
        if ($this->current_route == 'newsDetail') {
            $page_type = @$this->advertisement_position_items()->where('key', 'CONTENT_BOTTOM_ALERT')->first()->id;
        } else if ($this->current_route == 'newsCategory') {
            $page_type = @$this->advertisement_position_items()->where('key', 'CATEGORY_BOTTOM_ALERT')->first()->id;
        } else if ($this->current_route == 'index') {
            $page_type = @$this->advertisement_position_items()->where('key', 'HOMEPAGE_BOTTOM_ALERT')->first()->id;
        }
        return [$all ?? null, $page_type ?? null];
    }

    public function getAllHeaderAndMenuAds($type = 'header')
    {

        cache()->forget('header_advertisement');
        $header_ads = cache()->remember('header_advertisement', 60 * 60, function () {
            $headerIds = $this->getHeaderPositions();
            // dd($headerIds);
            $menuIds = $this->getMenuPositions();
            // dd($menuIds);
            $skip = $this->getSkipPositions();
            // dd($skip);
            $bottom_ad = $this->getBottomAdPositions();
            $positions = array_merge($headerIds, $menuIds, $skip, $bottom_ad);
            // $positions = array_filter($positions, function ($item) {
            //     // dd($item);
            //     if ($item) {return $item;}
            // });
            // dd($positions);
            return Advertisement::select(
                'advertisements.id',
                'advertisements.title',
                'advertisements.organization',
                'advertisements.url',
                'advertisements.position',
                'advertisements.columnType',
                'advertisements.img_url',
                'advertisements.show_on',
                'advertisements.img_url_app'
                )
                ->where('advertisements.publish_status', '1')
                // ->join('advertisement_positions', 'advertisement_positions.id', 'advertisements.position')
                // ->where('advertisement_positions.id', '')
                ->whereIn('advertisements.position', $positions)
                // ->with(['get_position' => fn($qr) => $qr->select('id', 'key', 'title', 'page', 'quantity')])
                // ->whereHas('get_position', function ($qr) use ($positions) {
                //     // dd($qr);
                //     return $qr->where('publish_status', '1')
                //         ->where(function ($qr) use ($positions) {
                //             // dd($positions);
                //             return $qr->whereIn('id', $positions);
                //         });
                // })
                ->orderBy('advertisements.order', 'asc')
                ->get();
        });
        // dd($header_ads);
        if ($type == 'header') {
            $header_ads = $header_ads->whereIn('position', $this->getHeaderPositions());
        } else if ($type == 'menu') {
            // dd($header_ads);
            // dd($this->getMenuPositions());
            $header_ads = $header_ads->whereIn('position', $this->getMenuPositions());
            // dd($header_ads);
        } else if ($type == 'skip') {
            $header_ads = $header_ads->whereIn('position', $this->getSkipPositions());
            // dd($header_ads);
        } else if ($type == 'bottom') {
            $header_ads = $header_ads->whereIn('position', $this->getBottomAdPositions());
        }
        $ads = null;
        if ($header_ads->count()) {
            $limiter = $this->advertisement_position_items()->where('id', $header_ads->first()->position)->first();
            $ads = $header_ads->take($limiter->quantity);
        }
        // dd($ads);
        return $ads;
    }

    public function getHeaderAdvertisements()
    {

        // dd($header_ads);
        $header_ads = $this->getAllHeaderAndMenuAds('header');
    }

    public function getMenuAdvertisement()
    {
        $menu_ads = Advertisement::select('id', 'title', 'organization', 'url', 'position', 'columnType')
            ->where('publish_status', '1')
            ->with([
                'advertiseHasImage' => fn($qr) => $qr->select('id', 'contentId', 'url')
                    ->where('table', 'advertisements'),
                'get_position' => fn($qr) => $qr->select('id', 'key', 'title', 'page', 'quantity'),
            ])
            ->whereHas('get_position', function ($qr) {
                // dd($qr);
                return $qr->where('publish_status', '1')
                    ->where(function ($qr) {
                        $qr = $qr->where('key', 'ALL_PAGE_MENU');
                        if ($this->current_route == 'newsDetail') {
                            $qr = $qr->orWhere('key', 'NEWS_MENU');
                        } else if ($this->current_route == 'newsCategory') {
                            $qr = $qr->orWhere('key', 'CATEGORY_MENU');
                        } else if ($this->current_route == 'index') {
                            $qr = $qr->orWhere('key', 'HOMEPAGE_MENU');
                        }
                        return $qr;
                    });
            })
            ->orderBy('position', 'asc')
            ->get();
        // dd($header_ads);

        if ($menu_ads->count()) {
            $limiter = $this->advertisement_position_items()->where('id', $menu_ads->first()->position)->first();
            $menu_ads = $menu_ads->take($limiter->quantity);
        }
        return $menu_ads;
    }
}
