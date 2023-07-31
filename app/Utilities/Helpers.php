<?php
//get unocde number
function mapdatabaseItem($assigned_data, $column)
{
    // dd($column);
    // dd($assigned_data);
    foreach ($assigned_data as $data) {
        if ($data->external_column == $column && $data->is_primary_key == '1') {
            return true;
        } else {
            return false;
        }
        break;
        // dd($data);
    }
}

function getUnicodeNumber($input)
{
    $standard_numsets = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];
    $nepali_numsets = ['०', '१', '२', '३', '४', '५', '६', '७', '८', '९'];
    return str_replace($standard_numsets, $nepali_numsets, $input);
}

//get standarrd number
function getStandardNumber($input)
{
    $nepali_numsets = ['०', '१', '२', '३', '४', '५', '६', '७', '८', '९'];
    $standard_numsets = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];
    $result = str_replace($nepali_numsets, $standard_numsets, $input);
    return strtoupper(trim($result));
}

//Upload Image
function uploadFile($file, $dir, $thumb = null, $user_file = null)
{
    $path = public_path() . '/' . $dir;
    if (!File::exists($path)) {
        File::makedirectory($path, 0777, true, true);
    }
    // dd($path);
    // dd($user_file);
    if (!$file->getClientOriginalExtension()) {
        return false;
    }
    if ($user_file != null) {
        $file_name = $user_file . "_" . rand(1111, 9999) . "." . $file->getClientOriginalExtension();
    } else {
        $file_name = ucfirst($dir) . "-" . date('YmdHis') . rand(0, 9999) . "." . $file->getClientOriginalExtension();
    }
    if ($file_name) {
        $success = $file->move($path, $file_name);
        if ($success):
            if ($thumb) {
                list($width, $height) = explode('x', $thumb);
                Image::make($path . '/' . $file_name)->resize($width, $height, function ($constraints) {
                    return $constraints->aspectRatio();
                })->save($path . '/Thumb-' . $file_name);
            }
            return $file_name;
        else:
            return false;
        endif;
    }
}

//Delete Image
function deleteFile($file, $dir, $thumb = false)
{
    if (file_exists(public_path() . '/' . $dir . '/' . $file) && !empty($file)) {
        unlink(public_path() . '/' . $dir . '/' . $file);
        if (file_exists(public_path() . '/' . $dir . '/Thumb-' . $file)) {
            unlink(public_path() . '/' . $dir . '/Thumb-' . $file);
        }
    }
}

//map error message for API
function mapErrorMessage($validation)
{
    $errors = [];
    // dd($validation->messages());
    foreach ($validation->errors()->all() as $key => $message) {
        $errors[] = $message;
    }
    return $errors;
}

//English to Nepali date:datenep('2076-12-30') for 2046-03-14 or  datenep('2046-03-14',true) for  २०४६ असार १४ गते बुधबार;
function datenep($date, $num_date = null)
{
    $lib = new \App\Models\NepaliCalander();
    $date = str_replace('/', '-', $date);
    $a = explode("-", $date);
    $b = explode(" ", $a[2]);
    $cd = $lib->eng_to_nep($a[0], $a[1], $b[0]);
    $cd = (array) $cd;
    if ($num_date == true) {
        return $cd['year'] . " " . $cd['nmonth'] . " " . $cd['date'] . " गते " . $cd['day'];
    } else {
        (getStandardNumber($cd['month']) > 9) ? $m = $cd['month'] : $m = "0" . $cd['month'];
        (getStandardNumber($cd['date']) > 9) ? $d = $cd['date'] : $d = "0" . $cd['date'];
        return getStandardNumber($cd['year'] . "-" . $m . "-" . $d);
    }
}

//Nep to eng dateeng('2076-12-30') or dateeng(2076-12-30',true) for leading 0 & false for not leading 0
function dateeng($date, $lead = true)
{
    $lib = new \App\Models\NepaliCalander();
    $date = str_replace('/', '-', $date);
    $a = explode("-", $date);
    $b = explode(" ", $a[2]);
    $cd = $lib->nep_to_eng($a[0], $a[1], $b[0]);
    $cd = (array) $cd;
    if ($lead == false) { //return the leading zero date
        return $cd['year'] . "-" . $cd['month'] . "-" . $cd['date'];
    } else {
        ($cd['month'] > 9) ? $m = $cd['month'] : $m = "0" . $cd['month'];
        ($cd['date'] > 9) ? $d = $cd['date'] : $d = "0" . $cd['date'];
        return $cd['year'] . "-" . $m . "-" . $d;
    }
}

// profile image loader
function profileImage($image)
{
    $thumbnail = asset('/img/profile.png');
    if ($image && !empty($image) && file_exists(public_path('uploads/riders/' . @$image))) {
        $thumbnail = asset('/uploads/riders/' . @$image);
    }
    return $thumbnail;
}

// string date to readable dates format
function ReadableDate($date, $type = null)
{
    if ($date) {
        $date = strtotime($date);
        if ($type == 'all') {
            return date('F d, Y h:i a', $date);
        } else if ($type == 'y') {
            return date('Y', $date);
        } else if ($type == 'ym') {
            return date('F Y', $date);
        } else if ($type == 'ymd') {
            return date('F d, Y', $date);
        } else if ($type == 'mf') {
            return date('F  h:i a', $date);
        } else if ($type == 'md') {
            return date('F d', $date);
        } else if ($type == 'fdt') {
            return date('F d, h:i a', $date);
        } else if ($type == 'dt') {
            return date('d, h:i a', $date);
        } else if ('time') {
            return date('h:i a', $date);
        }
    } else {
        return '';
    }
}

//for list of slider type
define('SLIDER_TYPE', [
    'trending' => 'Trending',
    'offer' => 'Offer',
]);

define('SHOW_ON', [
    'header' => 'Header',
    'footer' => 'Footer',
    'sidebar' => 'Sidebar',
    'useful_links' => 'Useful Links',
    "homepage" => "Homepage",
]);
/*
 * Map pagination data for api response while returning data
 *
 * @return
 */
function mapPageItems($data, $key = null)
{
    $mapdata = [
        'current_page' => $data->currentpage(),
        'total' => $data->total(),
        'perPage' => $data->perPage(),
        'lastPage' => $data->lastPage(),
    ];
    // dd($data->items());
    if ($key) {
        $mapdata[$key] = ($data->items() || count($data->items())) ? $data->items() : null;
    }
    return $mapdata;
}

define('pages', [
    "all" => "All",
    'homepage' => "Homepage",
    'category' => "Category",
    'news_detail' => "News Detail",
    // 'blog_detail' => "Blog Detail",
    // 'contact' => "Contact",
]);
define('COLUMN_TYPE', [
    'col-lg-3' => 'Column Three (25%)',
    'col-lg-4' => 'Column Four  (33.33%)',
    'col-lg-6' => 'Column Six  (50%)',
    'col-lg-8' => 'Column Eight  (66.67%)',
    'col-lg-9' => 'Column Nine  (75%)',
    'col-lg-12' => 'Column Twelve  (100%)',
]);
define('DIRECTION', [
    'top' => 'Top',
    'right' => "Right",
    "bottom" => "Bottom",
    "left" => "Left",
]);

define('CONTENT_LIST', [
    'categories' => "Categories",
    'posts' => "Posts",
    'news' => "News",
    "images" => "Images",
    "users" => "Users",
    "news_category" => "News Categories",
    "guest" => "Guests",
    "other" => "Others",
]);
//return valid url
function validate_url($url)
{
    return ((strpos($url, 'http://') === 0 || strpos($url, 'https://') === 0) && filter_var($url, FILTER_VALIDATE_URL) !== false);
}

function getYoutubeVideoId($url)
{
    $matches = null;
    preg_match("/^(?:http(?:s)?:\/\/)?(?:www\.)?(?:m\.)?(?:youtu\.be\/|youtube\.com\/(?:(?:watch)?\?(?:.*&)?v(?:i)?=|(?:embed|v|vi|user)\/))([^\?&\"'>]+)/", $url, $matches);
    return $matches;
}

function getFacebookVideoId($url)
{
    $matches = null;
    preg_match("~/videos/(?:t\.\d+/)?(\d+)~i", $url, $matches);
    return $matches;
}

function isVerified($status = null)
{
    if (!$status || $status == '0' || $status == 0) {
        return 'Unverified';
    } else if ($status == 1 || $status == '1') {
        return 'Verified';
    }
}

function getDuration($starttimestamp, $endtimestamp)
{
    $start_time = strtotime($starttimestamp);
    $end_time = strtotime($endtimestamp);
    $duration = ($end_time - $start_time) / 1000;
    return $duration;
}

function getImageFromUrl($filepath, $multiple = false)
{

    // dd($filepath);
    $check_if_multiple = explode(',', $filepath);
    if ($multiple == false) {
        if (count($check_if_multiple) > 1) {
            $filepath = $check_if_multiple[0];
        }
        // dd($filepath);
        // dd(getimagesize($filepath));
        if ($filepath && !empty($filepath)) {
            $image_url = explode('uploads/', $filepath);
            // dd($image_url);
            // dd($image_url);
            if (count($image_url) > 1) {
                $path = explode('/', $image_url[1]);
                // dd($path);
                $image = end($path);
                $image_path = str_replace($image, '', $image_url[1]);
                return [
                    'path' => $image_path,
                    'image' => $image,
                ];
            } else {
                return false;
            }
        } else {
            return false;
        }
    }
}

function getThumbImage($image, $path)
{
    if (filter_var($image, FILTER_VALIDATE_URL)) {
        return $image;
    }
    if ($image) {
        $thumbnail = asset('/uploads/' . $path . 'thumbs/' . $image);
    } else {
        $thumbnail = asset('/uploads/photos/author.png');
    }
    return $thumbnail;
}

function getFrontEndImage($image, $path, $isold)
{
}

function getFullImage($image, $path)
{
    $thumbnail = asset('/uploads/' . $path . $image);
    return $thumbnail;
}

function getPageNum($data, $key)
{
    return $data->perPage() * ($data->currentPage() - 1) + $key + 1;
}

function checkData($data)
{
    if (is_string($data)) {
        return $data;
    } else if (is_int($data)) {
        return $data;
    } else {
        // dd($data->rendered);
        if (@$data->rendered) {
            // dd($data->rendered);
            return @$data->rendered;
        }
    }
    // is_string($value) || is_int($value) ? $value : ''

}

function admin()
{
    return ['Admin', 'Super Admin'];
}

function todayDate()
{
    $calendar = new NepaliCalendar();
    return $calendar->ENG_TO_NEP_TIME(date("Y-m-d H:i:s"));
}

function get_title($content)
{
    // dd(app()->getLocale());
    return $content->title[app()->getLocale()];
}

function get_description($content, $field = null)
{
    if ($field) {
        return $content->field[app()->getLocale()];
    }
    return $content->description[app()->getLocale()];
}

function get_reporterName($content)
{
    // dd($content);
    return @$content->reporters->name['np'] ?? @$content->reporters->name['en'] ?? env('APP_NAME');
}

function get_reporter($content)
{
    return @$content->name['np'] ?? @$content->name['en'] ?? env('APP_NAME');
}

function get_guest($guests)
{
    return @$guests['np'] ?? @$guests['en'] ?? env('APP_NAME');
}

function get_guest_position($value, $_website)
{
    // dd($value->position);
    if ($_website == 'Nepali' || $_website == 'Both') {
        return @$value->position['np'];
    } elseif ($_website == 'English' || $_website == 'Both') {
        return @$value->position['en'];
    }
}

function get_guestName($content)
{
    return @$content->guests->name['en'] ?? @$content->guests->name['np'] ?? env('APP_NAME') . " guest";
}

function get_summary($content)
{
    return $content->summary[app()->getLocale()];
}

function published_date($created_at, $format = "dDmyt")
{
    $calendar = new NepaliCalendar();
    $date = $calendar->publish_time_date($created_at);
    // dd($format);
    foreach (str_split($format) as $index) {
        $date_value[] = "$date[$index] ";
    }
    $date_value = implode(" ", $date_value);
    return $date_value;

    if (!empty($created_at)) {
        $calendar = new NepaliCalendar();
        return $calendar->ENG_TO_NEP_TIME($created_at);
    } else {
        return null;
    }
    // dd($created_at);

}
function breaking_summary($content)
{
    return html_entity_decode(str_limit(strip_tags($content->summary['np']), 300));
}

function parse_description($content, $tags = false, $limit = null, $field = null)
{
    // if tag is true
    // dd($content);
    if ($tags) {
        return html_entity_decode(strip_tags(get_description($content, $field)));
    }
    if ($limit) {
        return html_entity_decode(str_limit(strip_tags(get_description($content, $field)), $limit));
    }
    return html_entity_decode(get_description($content, $field));
}

function detail_description($content)
{
    if ($content->news_language == 'en') {
        return html_entity_decode($content->description['en']);
    } else if ($content->news_language == 'np') {
        return html_entity_decode($content->description['np']);
    }
}

function create_url($menuItem)
{

    if ($menuItem->content_type == 'home') {
        $menuItem->slug = '/';
        return route('index');
    } else if ($menuItem->content_type == 'category') {
        return route('newsCategory', $menuItem->slug);
    }
    // return $menuItem->url;
}

// function create_image_url($image, $size = "banner")
// {

//     if ($image->isOldData) {
//         // dd($image->thumbnail );
//         if ($image->thumbnail) {
//             if (filter_var($image->thumbnail, FILTER_VALIDATE_URL)) {
//                 // dd($image->thumbnail);
//                 return $image->thumbnail;
//             }
//             else if ($image->img_url) {
//                 // dd($image);
//                 return $image->img_url;
//             } else {
//                 $image_path = public_path("/uploads/$image");
//                 $url = asset("uploads/$image");
//                 if (!file_exists($image_path)) {
//                     $url = asset("uploads/$image");
//                 }
//                 return $url;
//             }
//         }
//     }

//     // dd($image);

//     $name = $image->img_name;
//     $ext = $image->img_extension;
//     $path = $image->folder_path;
//     $size = config('lfm.other_img_size')[$size];
//     $file_path = public_path("uploads/$path" . "thumbs/$name-$size[0]x$size[1].$ext");

//     $url = asset("uploads/$path" . "thumbs/$name-$size[0]x$size[1].$ext");
//     // dd(file_exists($file_path));
//     if (!file_exists($file_path)) {
//         $url = asset("uploads/$path$name.$ext");
//     }
//     // dd($url);
//     // $code = get_headers($url);
//     // dd($code);
//     return $url;
// }
function getExt($filepath)
{
    // $filepath = public_path() . '/uploads/'.$path.'/' . $file;
    return $file_type = pathinfo($filepath, PATHINFO_EXTENSION);
}

function checkdevice($show_on)
{
    if ($show_on == 'web') {
        return "ads-only-desktop";
    } else if ($show_on == 'app') {
        return "ads-only-mobile";
    }
    return "show_all";
}

function deviceShowOn($show_on, $device)
{
    switch ($show_on) {
        case 'web':
            return $device == true ? true : false;
            break;
        case 'app':
            return $device == false ? true : false;
            break;
        default:
            return true;
    }
}

// function checkscreen(){

// }
function create_image_url($image, $size = "banner")
{
    // dd($image);
    if (!$image) {
        $setting = cache()->get('sitesetting');
        // return
        if ($setting) {
            return $setting->og_image;
        }
        // dd($setting);
    }

    if (filter_var($image, FILTER_VALIDATE_URL)) {

        // dd(strpos($image, route('index')));
        // dd(route('index'));
        if (!strpos($image, route('index'))) {
            return $image;
        }
        // dd($image);

        // $file_url =is_string($image)  ? $image : ($image->thumbnail ? $image->thumbnail : ($image->img_url ? $image->img_url : ''));
        $file_url = $image;
        // dd($image);
        $explode = @explode(route('index'), $file_url);
        if (count($explode) < 2) {
            $setting = cache()->get('sitesetting');
            // return
            if ($setting) {
                return $setting->logo_url;
            }
        }
        $folder_path = @$explode[1];
        // dd($folder_path);
        $original_path = $folder_path;
        $path = str_replace('/uploads/photos/', '', $folder_path);
        // dd($path);
        $imagepath = str_replace($path, config('lfm.thumb_folder_name'), $folder_path);
        // dd($imagepath);
        $ext = getExt($path);
        $name = pathinfo($path, PATHINFO_FILENAME);
        // dd($name);
        // echo $size;
        // $size = $size ?? 'banner';
        // dd(array_keys(config('lfm.other_img_size')));
        if (in_array($size, array_keys(config('lfm.other_img_size')))) {
            $size = config('lfm.other_img_size')[$size];
            // dd($size);
            $main_path = $imagepath . "/$name-$size[0]x$size[1].$ext";
            // dd($main_path);
            $file_path = public_path($main_path);
            // dd($file_path);
            $url = asset($main_path);
            if (!file_exists($file_path)) {
                $url = asset("$original_path");
                if (!file_exists($url)) {
                    $setting = cache()->get('sitesetting');
                    // return
                    if ($setting) {
                        return $setting->logo_url;
                    }
                }
                // dd($url);
            }
        } else {
            // dd($image);
            $url = asset("$original_path");
            if (!file_exists($url)) {
                $setting = cache()->get('sitesetting');
                // return
                if ($setting) {
                    return $setting->logo_url;
                }
            }
        }

        return $url;
    } else {
        if (isset($image) && $image) {
            return $image;
        }

        $setting = cache()->get('sitesetting');
        // return
        if ($setting) {
            return $setting->favicon;
        }
    }
    return $image;
}

function reporter_img_url($image, $size = "banner")
{
    // dd($image);
    if (!$image) {
        $setting = cache()->get('sitesetting');
        // return

        if ($setting) {
            return $setting->favicon;
        }
        // dd($setting);
    }

    if (filter_var($image, FILTER_VALIDATE_URL)) {
        // dd(strpos($image, route('index')));
        // dd(route('index'));
        if (!strpos($image, route('index'))) {
            return $image;
        }
        // dd($image);

        // $file_url =is_string($image)  ? $image : ($image->thumbnail ? $image->thumbnail : ($image->img_url ? $image->img_url : ''));
        $file_url = $image;
        // dd($image);
        $explode = @explode(route('index'), $file_url);
        if (count($explode) < 2) {

            $setting = cache()->get('sitesetting');
            // return
            if ($setting) {
                return $setting->favicon;
            }
        }
        $folder_path = @$explode[1];
        // dd($folder_path);
        $original_path = $folder_path;
        $path = str_replace('/uploads/photos/', '', $folder_path);
        // dd($path);
        $imagepath = str_replace($path, config('lfm.thumb_folder_name'), $folder_path);
        // dd($imagepath);
        $ext = getExt($path);
        $name = pathinfo($path, PATHINFO_FILENAME);
        // dd($name);
        // echo $size;
        // $size = $size ?? 'banner';
        // dd(array_keys(config('lfm.other_img_size')));
        if (in_array($size, array_keys(config('lfm.other_img_size')))) {
            $size = config('lfm.other_img_size')[$size];
            // dd($size);
            $main_path = $imagepath . "/$name-$size[0]x$size[1].$ext";
            // dd($main_path);
            $file_path = public_path($main_path);
            // dd($file_path);
            $url = asset($main_path);
            if (!file_exists($file_path)) {
                $url = asset("$original_path");
                if (!file_exists($url)) {

                    $setting = cache()->get('sitesetting');
                    // return
                    if ($setting) {
                        return $setting->favicon;
                    }
                }
                // dd($url);
            }
        } else {
            // dd($image);
            $url = asset("$original_path");
            if (!file_exists($url)) {

                $setting = cache()->get('sitesetting');
                // return
                if ($setting) {
                    return $setting->favicon;
                }
            }
        }

        return $url;
    } else {
        dd(isset($image));

        $setting = cache()->get('sitesetting');
        // return
        if ($setting) {
            return $setting->favicon;
        }
    }
    return $image;
}

function get_image_url($image)
{
    if (filter_var($image, FILTER_VALIDATE_URL)) {
        if (strpos($image, ',')) {
            $urls = explode(',', $image);
            foreach ($urls as $key => $url) {

                if (filter_var($url, FILTER_VALIDATE_URL)) {
                    if ($key == 0) {
                        return $url;
                    }
                }
            }
        } else {
            return $image;
        }
    }
    return false;
}

function checkImageExists($image)
{

    $file = public_path(parse_url($image, PHP_URL_PATH));
    return file_exists($file);
}

function limit_words($string, $word_limit)
{
    if (isset($string) && isset($word_limit)) {
        $words = explode(" ", $string);
        if (count($words) <= $word_limit) {
            return implode(" ", array_splice($words, 0, $word_limit, ));
        } else {
            return implode(" ", array_splice($words, 0, $word_limit)) . ' ...';
        }
    } else {
        return null;
    }
}
