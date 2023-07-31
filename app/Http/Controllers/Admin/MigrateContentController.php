<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\News;
use App\Models\Menu;
use App\Models\OldDatabase;
use App\Traits\MigrateDatabase\MigrateInternalDatabase;
// use App\Traits\MigrateDatabase\MigrateCodeigniterTrait;
use App\Traits\MigrateDatabase\MigrateLaravelTrait;
use App\Traits\MigrateDatabase\MigratePHPTrait;
use App\Traits\MigrateDatabase\MigrateWordpressTrait;
use Illuminate\Http\Request;

class MigrateContentController extends Controller
{
    //
    use MigrateInternalDatabase;
    // use MigratePHPTrait;
    use MigrateWordpressTrait;
    // use MigrateLaravelTrait; 
    // use MigrateCodeigniterTrait;
    public function __construct(Menu $menu, News $news)
    {
        $this->get_web();
        $this->menu = $menu;
        $this->news = $news;
    }
    protected function getClassName($old_db, $internal = false ){
        if($internal){
            $table = $old_db->internal_table;
        }else {
            $table = $old_db->aspected_table;
        }
        $className = 'App\\Models\\' . studly_case(str_singular($table));
        return $class = new $className;
    }
    public function startMigratingContent(Request $request)
    {

        if($request->type && $request->type == 'internal'){
            return $this->migrateDatabaseInternally($request);
        }
        $old_db = OldDatabase::find($request->content_id);
        if (!$old_db) {
            // $request->session()->flash('error', 'Invalid information.');
            // return redirect()->route('migration.index');
            return response()->json([
                'success' => false,
                // 'status_code' => 404,
                "message" => "Invalid information.",
            ]);
        }
        // dd($request->all());
        if ($old_db->framework == 'wordpress') {
            return $this->migrateWordpress($old_db, $request);
        } else if ($old_db->framework == 'laravel') {
            return $this->migrateLaravel($old_db, $request);
        } else if ($old_db->framework == 'ci') {
            return $this->migrateCi($old_db, $request);
        } else if ($old_db->framework == 'PHP') {
            return $this->migratePHP($old_db, $request);
        }

    }

    protected function createStatus($status)
    {
        switch (ucFirst($status)) {
            case "Publish":
                $value = '1';
                break;
            case "Unpublish":
                $value = '0';
                break;
            case "Published":
                $value = '1';
                break;
            case "Unpublished":
                $value = '0';
                break;
            case '1':
                $value = '1';
                break;
            case '0':
                $value = '0';
                break;
            case 1;
                $value = '1';
                break;
            case 0:
                $value = '0';
                break;
            default:
                $value = '0';
        }
        return $value;
    }

    protected function generateCategory($category)
    {
        // dd($category);
        if (is_array($category)) {
            return json_encode($category);
        }
        return $category;

    }

    protected function createJsonData($environment = 'ci', $contentItem, $swap_key, $internal = false )
    {

        $data = [
            'np' => '',
            'en' => '',
        ];
        // $new_content = preg_replace("/wp-content\/uploads/i", 'uplaods', $contentItem->content->rendered);
        if ($this->_website == 'Nepali') {
            if ($contentItem->$swap_key) {
                if (is_string($contentItem->$swap_key) || $environment != 'wordpress') {
                    $data['np'] = $contentItem->$swap_key;
                } else {
                    if ($contentItem->$swap_key->rendered) {
                        $new_content = preg_replace("/wp-content\/uploads/i", 'uplaods', $contentItem->$swap_key->rendered);
                        // dd($new_content);
                        $data['np'] = $new_content;
                    }
                }
            }
        } else if ($this->_website == 'English') {
            if ($contentItem->$swap_key) {
                if (is_string($contentItem->$swap_key) || $environment != 'wordpress') {
                    $data['en'] = $contentItem->$swap_key;
                } else {
                    if ($contentItem->$swap_key->rendered) {
                        $new_content = preg_replace("/wp-content\/uploads/i", 'uplaods', $contentItem->$swap_key->rendered);
                        $data['en'] = $new_content;
                    }
                }
            }
        } else  {
            if ($contentItem->$swap_key) {
                if (is_string($contentItem->$swap_key) || $environment != 'wordpress') {
                    $data['en'] = $contentItem->$swap_key;
                    $data['np'] = $contentItem->$swap_key;
                } else {
                    if ($contentItem->$swap_key->rendered) {
                        $new_content = preg_replace("/com\/wp-content\/uploads/i", 'uplaods', $contentItem->$swap_key->rendered);
                        $data['en'] = $new_content;
                        $data['np'] = $new_content;
                    }
                }
            }
        }
        return json_encode($data, JSON_UNESCAPED_UNICODE);
        // if($internal) {
        //     return  $data;

        // }else {
            
        // }
    }

    protected function getOldDBId($old_db, $internal = false)
    {
        // dd($old_db);
        if($internal){
            $table = $old_db->internal_table;
        }else {
            $table = $old_db->aspected_table;
        }
        $className = 'App\\Models\\' . studly_case(str_singular($table));
        $class = new $className;
        // dd($class);
        // dd($test);
         $ids =  $class->select('id', 'oldId')->whereNotNull('oldId')->pluck('oldId')->toArray();
         return $ids;
        //  dd($ids);
        // if(count($ids) > 0){
        //     return $ids;
        // }else {
        //     return null ;
        // }
        // return count($ids > 0) ? $ids : null;
    }
}
