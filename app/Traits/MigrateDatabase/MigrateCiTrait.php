<?php

namespace App\Traits\MigrateDatabase;

use App\Events\DataMigratedEvent;
use App\Models\AssignedMigrationTableColumn;
use App\Models\ExternalDatabaseConnection;
use App\Models\Menu;
use App\Models\News;
use App\Models\NewsGuest;
use App\Models\Reporter;
use App\Models\Tag;
use App\Models\User;
use Carbon\Carbon;
use DateTime;
use Illuminate\Support\Facades\DB;

/**
 *
 */
trait MigrateCiTrait
{

    protected $current_page = 1;
    protected function migrateCi($assigned_table)
    {
        // mysql --max_allowed_packet=100M -u root -p database < dump.sql
        $model = new ExternalDatabaseConnection;
        $model->setTable($assigned_table->external_table);
        // dd($model);
        // dd($assigned_table);
        $tableClass = $this->getClassName($assigned_table, $internal = true);
        // dd($assigned_table);
        // internal database expected table columns fetched below
        // $internal_columns = DB::connection()->getSchemaBuilder()->getColumnListing($assigned_table->internal_table);
        // dd($internal_columns);
        // External database table column fetched below
        // this is from where data to is being migrated
        // $external_columns = DB::connection('mysql2')->getSchemaBuilder()->getColumnListing($assigned_table->external_table);
        // dd($external_columns);
        // extarnal database expected table item feteched below
        // $this->table = $assigned_table->external_table;
        // dd($this->table);
        // dd($tableClass);
        // dd($assigned_table->internal_table);

        $swap_columns = AssignedMigrationTableColumn::select('internal_table', 'external_column', 'internal_column', 'id', 'is_primary_key')
            ->where('internal_table', $assigned_table->internal_table)
            ->where('external_table', $assigned_table->external_table)
            ->get();
        // dd($swap_columns);
        set_time_limit(0);
        $users = User::select('id', 'name', 'oldId')->get();
        $reporters = Reporter::select('id', 'name', 'oldId')->get();
        $guests = NewsGuest::select('id', 'name', 'oldId')->get();
        $categories = Menu::select('id', 'title', 'oldId')->get();
        $tags = Tag::select('id', 'title', 'oldId')->get();
        $side_data =  [
            'categories' => $categories,
            'users' => $users,
            'reporters' => $reporters,
            'guests' => $guests,
            'tags' => $tags,
        ];
        if ($assigned_table->internal_table == 'news_categories' || $assigned_table->internal_table == 'news_reporters' || $assigned_table->internal_table == 'news_guests') {
            $news_items = News::select('id', 'oldId')->latest()->get();
            // dd($news_items[0]);
            $side_data['news_items'] = $news_items;
            // dd($news_items);
        }

        $external_table_items = $model
       
        ->where('is_special', '1' )
        ->pluck('content_id')->toArray();
        // dd($external_table_items);
    //    $hello=  News::whereIn('oldId', $external_table_items)->update(['isSpecial'=>'1'])->toSql();
    
       
        // $dup_data = News::select('oldId')->groupBy('oldId')->get();
        // dd($dup_data);
        try {
            $i = 0;
            $i = 156;
            $check_primary = $swap_columns->pluck("is_primary_key", 'external_column')->toArray();
            $primary_id = array_search('1', $check_primary);
            // dd($old_ids);
            // dd($primary_id);
            // $old_ids = $this->getOldDBId($assigned_table, $internal = true);
            
            do {
                // $latest_id = $tableClass->select('id', 'oldId')->orderBy('oldId', 'ASC')->first();
                // $external_table_items = DB::connection('mysql2')->table($assigned_table->external_table)->paginate(4);
                $external_table_items = $model
                    // ->whereNoTIn($primary_id, $old_ids)
                    // ->whereIn($primary_id, [76747,76748,76749,76750,76751])
                    ->orderBy($primary_id, 'ASC')
                    // ->where($primary_id, ">",  )
                    ->paginate(100, ["*"], 'page', $i + 1);
                // dd($external_table_items);
                // dd($external_table_items[0]);
                // $ids_list =  $external_table_items->pluck($primary_id)->toArray();
                // dd($ids_list);
                // $alredy_migrated_data = $tableClass->whereIn('oldId', $ids_list)->pluck('oldId');
                if ($external_table_items->count()) {
                    $alredy_migrated_data =  $tableClass
                        ->whereIn('oldId', $external_table_items->pluck($primary_id))
                        ->pluck('oldId')->toArray();
                    // dd($alredy_migrated_data);
                    // $insertion_items = $external_table_items->map(function ($item) use ($alredy_migrated_data, $primary_id) {
                    //     $ids = $alredy_migrated_data;
                    //     // dd($ids);
                    //     if(!in_array($item->$primary_id,$ids)){
                    //         return $item;
                    //     }
                    //     return false;

                    // });
                    // $insertion_items = [];
                        // if($assigned_table->internal_table == 'news_categories'){
                        //     $news_items = News::select('id', 'oldId')
                        //     ->where('oldId', $external_table_items->pluck('news_id')->toArray())
                        //     ->get();
                        //     // dd($news_items);
                        //     // dd($news_items[0]);
                        //     $side_data['news_items'] = $news_items;
                        // }

                    // if ($assigned_table->internal_table == 'news_categories' || $assigned_table->internal_table == 'news_reporters' || $assigned_table->internal_table == 'news_guests') {
                    //     $news_items = News::select('id', 'oldId')
                    //     ->where('oldId', $external_table_items->pluck($primary_id)->toArray())
                    //     ->pluck('oldId');
                    //     // dd($news_items);
                    //     // dd($news_items[0]);
                    //     $side_data['news_items'] = $news_items;
                    //     // dd($news_items);
                    // }
                    
                    foreach ($external_table_items as $key =>  $new_data) {
                        // dd($new_data);
                        if (in_array($new_data->$primary_id, $alredy_migrated_data)) {
                            // dd($new_data);
                            // $insertion_items[] = $new_data;
                            unset($external_table_items[$key]);
                        }


                        // if($assigned_table->internal_table == 'news_categories'){
                            
                        //     if (!in_array($new_data->news_id, $news_items->pluck('oldId')->toArray())) {
                        //         // dd($new_data);
                        //         // $insertion_items[] = $new_data;
                        //         unset($external_table_items[$key]);
                        //     }
                          
                             
                        // }
                    }
                    // dd('hello outer', round(microtime(true) - LARAVEL_START, 2));
                    // dd($external_table_items->count());
                    // dd($insertion_items);
                    // foreach ($insertion_items as $key => $itemdata) {
                    //     if (!$itemdata) {
                    //         unset($insertion_items[$key]);
                    //     }
                    // }
                   
                    if ($external_table_items->count()) {
                        // dd('hello', round(microtime(true) - LARAVEL_START, 2));
                        // dd($insertion_items);
                        $this->mapExternalData($assigned_table, $external_table_items, $swap_columns, $side_data);
                    }
                    // if ($insertion_items->count()) {
                    //     // dd('hello innner', $insertion_items);
                    // }
                }
                // if($i == 4){
                //     dd('hello outer', round(microtime(true) - LARAVEL_START, 2), $external_table_items);

                // }

                $i++;
                $this->current_page = $external_table_items->currentpage();


                // dd($external_table_items->lastPage());
            } while ($external_table_items->currentpage() < $external_table_items->lastPage());
            // echo 'time is \n' . round(microtime(true) - LARAVEL_START, 2);

            // event(new DataMigratedEvent(round(microtime(true) - LARAVEL_START, 2)));
            return response()->json([
                'status' => true,
                "message" => "Data migrated successfully",
            ]);
        } catch (\Exception $error) {

            return response()->json([
                'status' => false,
                'message' => $error->getMessage(),
            ]);
        }
    }

    protected function mapExternalData($assigned_table, $external_table_items, $swap_columns, $helper_data)
    {

        $categories = $helper_data['categories'];
        $users = $helper_data['users'];
        $reporters = $helper_data['reporters'];
        $guests = $helper_data['guests'];
        $tags = $helper_data['tags'];
        $news_items = @$helper_data['news_items'];
        // dd($categories);
        // dd($users->where('oldId', 5));
        $json_column = ['title', 'description', 'summary', 'name', 'short_description'];
        $data = [];
        if (isset($external_table_items) && $external_table_items->count()) {
            // dd($assigned_table);
            // already existing data in main table  is fetched below
            $old_ids = $this->getOldDBId($assigned_table, $internal = true);
            // dd($old_ids);
            // $json_column = ['title', 'description', 'summary', 'name', 'short_description'];
            $json_column = ['title', 'description', 'summary', 'name', 'short_description', 'position'];
            $check_primary = $swap_columns->pluck("is_primary_key", 'external_column')->toArray();
            $primary_id = array_search('1', $check_primary);
            // dd($primary_id);
            $internal_columns = DB::connection()->getSchemaBuilder()->getColumnListing($assigned_table->internal_table);
            // dd($internal_columns);
            $insertdata = [];
            foreach ($external_table_items as $data_key => $contentItem) {
                // dd($swap_columns);
                // all the data migrated from here are old data
                // $migrating_data['isOldData'] =  '1';
                // dd($old_ids); 

                if (!in_array($contentItem->$primary_id, $old_ids)) {
                    if (isset($swap_columns) && $swap_columns->count()) {
                        $single_data = [];
                        // $single_data['oldId'] = @$contentItem->$primary_id;
                        // dd($single_data);
                        foreach ($swap_columns as $column_key => $swap_column_data) {
                            //  dd($internal_columns);
                            // dd($swap_columns);


                            if ($swap_column_data->external_column && $swap_column_data->internal_column) {
                                $content_key_data = $contentItem[$swap_column_data->external_column];
                                // dd($swap_column_data->external_column);
                                if (in_array($swap_column_data->internal_column, $json_column)) {
                                    // dd($swap_column_data->internal_column);
                                    // dd($swap_column_data);
                                    $single_data[$swap_column_data->internal_column] = $this->createJsonData($swap_column_data->internal_column, $contentItem, $swap_column_data->external_column, true);
                                    // dd($single_data); 
                                } else {
                                    $single_data[$swap_column_data->internal_column] = $content_key_data;
                                }
                                if ($swap_column_data->internal_column == 'slug') {
                                    // $single_data[$swap_column_data->internal_column] = $content_key_data ?? $primary_id;
                                    $single_data[$swap_column_data->internal_column] = $contentItem->$primary_id;
                                }
                                if ($swap_column_data->internal_column == 'created_by') {
                                    $created_by = null;
                                    if (intval($content_key_data) > 0) {
                                        // $created_by = User::where('id', $content_key_data)->first();
                                        $created_by = $users->firstWhere('id', $content_key_data);
                                    }
                                    $single_data[$swap_column_data->internal_column] =  $created_by ? $created_by->id : null;
                                }
                                if ($swap_column_data->internal_column == 'updated_by') {
                                    $updated_by =  null;
                                    if (intval($content_key_data) > 0) {
                                        $updated_by = $users->firstWhere('id', $content_key_data);
                                        //  User::where('id', $content_key_data)->first();
                                    }
                                    $single_data[$swap_column_data->internal_column] =  $updated_by ? $updated_by->id : null;
                                }
                                // if($swap_column_data->internal_column == 'newsId'){
                                //   $news =   News::where('id',$content_key_data )->first();
                                //   $single_data[$swap_column_data->internal_column] =  $news ? $news->id : null;
                                // }
                                if ($swap_column_data->internal_column == 'reporter' || $swap_column_data->internal_column == 'guestId') {

                                    if (is_int($content_key_data) && intval($content_key_data) > 0) {
                                        $single_data[$swap_column_data->internal_column] = $content_key_data;
                                    }
                                }
                                if ($swap_column_data->internal_column == 'view_count') {
                                    $single_data[$swap_column_data->internal_column] = $content_key_data ?? 0;
                                }

                                if ($swap_column_data->internal_column == 'category') {
                                    $single_data[$swap_column_data->internal_column] = $this->generateCategory($content_key_data);
                                }
                                if ($swap_column_data->internal_column == 'publish_status') {
                                    $single_data[$swap_column_data->internal_column] = $this->createStatus($content_key_data);
                                }
                                if ($swap_column_data->internal_column == 'created_at') {
                                    $created_at = $this->create_date_format($content_key_data, now());

                                    // dd($content_key_data);
                                    // dd($single_data[$swap_column_data->internal_column] );
                                    $single_data[$swap_column_data->internal_column] = $created_at;
                                }
                                if ($swap_column_data->internal_column == 'published_at') {
                                    // $published_at = $this->create_date_format($content_key_data, $single_data['created_at'] ?? now());
                                    $published_at  = $single_data['created_at'];

                                    // $contentItem[$swap_column_data->internal_column] = $published_at  ;
                                    // dd($single_data[$swap_column_data->internal_column] );
                                    $single_data[$swap_column_data->internal_column] = $published_at;
                                }

                                if ($swap_column_data->internal_column == 'updated_at') {
                                    $updated_at = $this->create_date_format($content_key_data, $single_data['created_at'] ?? now());
                                    $single_data[$swap_column_data->internal_column] = $updated_at;
                                }
                                if ($assigned_table->content_type == 'categories') {
                                    $single_data['show_on'] = json_encode(array_keys(SHOW_ON), JSON_UNESCAPED_UNICODE);
                                    $single_data['content_type'] = 'category';
                                }
                            }

                            if (in_array('isOldData', $internal_columns)) {
                                $single_data['isOldData'] = '1';
                            }
                            if (in_array('oldId', $internal_columns)) {
                                $single_data['oldId'] = $contentItem->$primary_id;
                            }
                            if (in_array('position', $internal_columns)) {
                                $single_data['position'] = (int)$content_key_data;
                            }
                            // $value = $content_key_data;
                            if ($swap_column_data->internal_column  == 'created_by') {
                                // $created_by =  User::query()
                                //     ->select('id', 'oldId')
                                //     ->where('oldId', $value)->first();
                                $created_by = $users->firstWhere('oldId', $content_key_data);


                                $single_data['created_by'] = $created_by ? $created_by->id : null;
                            }
                            if ($swap_column_data->internal_column  == 'updated_by') {
                                // $updated_by =  User::query()
                                //     ->select('id', 'oldId')
                                //     ->where('oldId', $content_key_data)->first();

                                $updated_by = $users->firstWhere('oldId', $content_key_data);
                                $single_data['updated_by'] = $updated_by ? $updated_by->id : null;
                            }
                            if ($swap_column_data->internal_column  == 'guestId') {
                                // $guestId =  NewsGuest::query()
                                //     ->select('id', 'oldId')
                                //     ->where('oldId', $content_key_data)->first();

                                $guestId = $guests->firstWhere('oldId', $content_key_data);
                                $single_data['guestId'] = $guestId ? $guestId->id : null;
                            }
                            if ($swap_column_data->internal_column  == 'userId') {
                                // $userId =  User::query()
                                //     ->select('id', 'oldId')
                                //     ->where('oldId', $content_key_data)->first();

                                $userId = $users->firstWhere('oldId', $content_key_data);
                                $single_data['userId'] = $userId ? $userId->id : null;
                            }
                            if ($swap_column_data->internal_column  == 'reporter') {
                                // $reporter =  Reporter::query()
                                //     ->select('id', 'oldId')
                                //     ->where('oldId', $content_key_data)->first();
                                $reporter = $reporters->firstWhere('oldId', $content_key_data);
                                $single_data['reporter'] = $reporter ? $reporter->id : null;
                            }

                            if ($swap_column_data->internal_column  == 'newsId') {
                                // dd($content_key_data);
                                $news = $news_items->firstWhere('oldId', $content_key_data);
                                // News::query()
                                //     ->select('id', 'oldId')
                                //     ->where('oldId', $content_key_data)->first();
                                // dd($news);
                                // $reporter = $news->firstWhere('oldId', $content_key_data);    
                                $single_data['newsId'] = $news ? $news->id : null;
                                // dd($news);
                                if ($news) {
                                }
                            }
                            if ($swap_column_data->internal_column  == 'categoryId') {
                                // $categoryInfo =  Menu::query()
                                //     ->select('id', 'oldId')
                                //     ->where('oldId', $content_key_data)->first();
                                $categoryInfo = $categories->firstWhere('oldId', $content_key_data);
                                $single_data['categoryId'] = $categoryInfo ? $categoryInfo->id : null;
                            }
                            // if ($swap_column_data->internal_column  == 'categoryId') {
                            //     $news =  Menu::query()
                            //         ->select('id', 'oldId')
                            //         ->where('oldId', $content_key_data)->first();
                            //     $single_data['categoryId'] = $news ? $news->id : null;
                            // }
                            if ($swap_column_data->internal_column  == 'reporterId') {
                                $reporterInfo =   $reporters->firstWhere('oldId', $content_key_data);

                                $single_data['reporterId'] = $reporterInfo ? $reporterInfo->id : null;
                            }
                            if ($swap_column_data->internal_column  == 'tagId') {
                                $tagInfo = $tags->firstWhere('oldId', $content_key_data);
                                $single_data['tagId'] = $tagInfo ? $tagInfo->id : null;
                            }
                            // execute insert query here

                        }
                        // dd('hello', $single_data);

                        if ($single_data) {

                            // dd($single_data);
                            $tableClass = $this->getClassName($assigned_table, $internal = true);
                            // dd($tableClass);
                            // dd($assigned_table);
                            if ($assigned_table->internal_table == 'news_categories') {
                                if ($single_data['newsId'] == null || $single_data['categoryId'] == null) {
                                    // dd('hello');
                                    $single_data = null;
                                }
                            }
                            // dd('test');
                            // DB::beginTransaction();
                            // for single insertion 
                            // $this->insertSingleData($tableClass, $single_data);



                            // try {
                            //     // $alredy_migrated_data = $tableClass->select('id', 'oldId')->where('oldId', $single_data['oldId'])->first();
                            //     // if (!$alredy_migrated_data) {
                            //     //     if ($single_data) {
                            //     //         // dd($single_data);
                            //     //         $success =  $tableClass->insert($single_data);
                            //     //     }
                            //     // }
                            //     if ($single_data) {
                            //         // dd($single_data);
                            //         $success =  $tableClass->insert($single_data);
                            //     }
                            // } catch (\Throwable $t) {
                            //     dd($t->getMessage());
                            //     // dd($data);
                            //     // DB::rollback();
                            //     // return $t->getMessage();

                            //     // return response()->json(['message' => $t->getMessage()], 502);
                            //     continue;
                            // }
                        }
                        // dd($single_data);
                        if($single_data){
                            $insertdata[] = $single_data;

                        }
                    }
                }
                // dd($old_ids);
                // dd($migrating_data);
                // if ($single_data) {
                //     $data[] = $migrating_data ?? [];
                // }
            }
            // dd($insertdata);
            // $news_items = array_chunk($insertdata , 100);
            // foreach($news_items as $)
            try {
                // $alredy_migrated_data = $tableClass->where('oldId', $single_data['oldId'])->first();
                // if (!$alredy_migrated_data) {

                // }
                if ($insertdata) {
                    // dd($single_data);
                    $success =  $tableClass->insert($insertdata);
                }

            } catch (\Throwable $t) {
                dd($t->getMessage());
                // dd($data);
                // DB::rollback();
                // return $t->getMessage();

                // return response()->json(['message' => $t->getMessage()], 502);
                // continue;
            }
            // dd($migrating_data);
        }
        // return $data ?? false;

    }
    protected function insertMultipleData($tableClass, $single_data)
    {
        try {
            $alredy_migrated_data = $tableClass->where('oldId', $single_data['oldId'])->first();
            if (!$alredy_migrated_data) {
                if ($single_data) {
                    // dd($single_data);
                    $success =  $tableClass->insert($single_data);
                }
            }
        } catch (\Throwable $t) {
            dd($t->getMessage());
            // dd($data);

            // continue;
        }
    }


    protected function insertSingleData($tableClass, $single_data)
    {
        try {
            $alredy_migrated_data = $tableClass->where('oldId', $single_data['oldId'])->first();
            if (!$alredy_migrated_data) {
                if ($single_data) {
                    // dd($single_data);
                    $success =  $tableClass->insert($single_data);
                }
            }
        } catch (\Throwable $t) {
            dd($t->getMessage());
            // dd($data);
            // DB::rollback();
            // return $t->getMessage();

            // return response()->json(['message' => $t->getMessage()], 502);
            // continue;
        }
    }










































    protected function create_date_format($date, $created_at = null)
    {
        // $new_date = $this->verifyDate($date);
        // dd($new_date);
        // dd(now());
        // dd($date);
        if ($date == '0000-00-00 00:00:00') {
            return now();
        }
        return $date;

        $date =  date("Y-m-d H:i:s", $date);
        dd($date);
        if ($date) {
            $date = date('Y-m-d H:i:s');
            $date =    Carbon::parse($date);
            dd($this->verifyDate($date));
            //  dd($dat);
        }
        return now();
        if ($new_date) {
            return Carbon::parse($date);
        } else {
            $created_date = $this->verifyDate($created_at);
            if ($created_date) {
                return Carbon::parse($created_at);
            } else {
                return now();
            }
        }
        return now();
    }
    public function verifyDate($date)
    {
        return DateTime::createFromFormat('m/d/Y H:i:s', $date);
        return (DateTime::createFromFormat('m/d/Y H:i:s', $date) !== false);
    }
    protected function TestingFormapExternalData($assigned_table, $external_table_items, $swap_columns)
    {
        $json_column = ['title', 'description', 'summary', 'name', 'short_description'];
        $data = [];
        if (isset($external_table_items) && $external_table_items->count()) {
            // dd($assigned_table);
            // already existing data in main table  is fetched below
            $old_ids = $this->getOldDBId($assigned_table, $internal = true);
            // dd($old_ids);
            $json_column = ['title', 'description', 'summary', 'name', 'short_description'];
            $check_primary = $swap_columns->pluck("is_primary_key", 'external_column')->toArray();
            $primary_id = array_search('1', $check_primary);
            // dd($primary_id);
            $internal_columns = DB::connection()->getSchemaBuilder()->getColumnListing($assigned_table->internal_table);
            // dd($internal_columns);
            foreach ($external_table_items as $data_key => $contentItem) {
                // dd($contentItem);
                // dd($primary_id);
                // dd($contentItem->$primary_id);
                // $swap_columns;
                // all the data migrated from here are old data
                // $migrating_data['isOldData'] =  '1';
                in_array('isOldData', $internal_columns) ? $migrating_data['isOldData'] = '1' : $migrating_data = [];
                if (!in_array($contentItem->$primary_id, $old_ids)) {
                    if (isset($swap_columns) && $swap_columns->count()) {
                        // $migrating_data['oldId'] = @$contentItem->$primary_id;
                        in_array('oldId', $internal_columns) ? $migrating_data['oldId'] = @$contentItem->$primary_id : '';
                        foreach ($swap_columns as $column_key => $swap_column_data) {
                            if ($swap_column_data->external_column && $swap_column_data->internal_column) {
                                // dd($swap_column_data->external_column);
                                if (in_array($swap_column_data->internal_column, $json_column)) {
                                    // dd($swap_column_data->internal_column);
                                    // dd($swap_column_data);
                                    $migrating_data[$swap_column_data->internal_column] = $this->createJsonData($swap_column_data->internal_column, $contentItem, $swap_column_data->external_column);
                                    // dd($migrating_data);
                                } else {
                                    $migrating_data[$swap_column_data->internal_column] = $content_key_data;
                                }
                                if ($swap_column_data->internal_column == 'slug') {
                                    $migrating_data[$swap_column_data->internal_column] = $content_key_data ?? $primary_id;
                                }
                                if ($swap_column_data->internal_column == 'created_by' || $swap_column_data->internal_column == 'updated_by' || $swap_column_data->internal_column == 'reporter' || $swap_column_data->internal_column == 'guestId') {
                                    if (is_int($content_key_data) && intval($content_key_data) > 0) {
                                        $migrating_data[$swap_column_data->internal_column] = $content_key_data;
                                    }
                                }
                                if ($swap_column_data->internal_column == 'view_count') {
                                    $migrating_data[$swap_column_data->internal_column] = $content_key_data ?? 0;
                                }

                                if ($swap_column_data->internal_column == 'category') {
                                    $migrating_data[$swap_column_data->internal_column] = $this->generateCategory($content_key_data);
                                }
                                if ($swap_column_data->internal_column == 'publish_status') {
                                    $migrating_data[$swap_column_data->internal_column] = $this->createStatus($content_key_data);
                                }
                                if ($swap_column_data->internal_column == 'created_at') {
                                    $created_at = $this->create_date_format($content_key_data, now());

                                    // dd($content_key_data);
                                    // dd($migrating_data[$swap_column_data->internal_column] );
                                    $migrating_data[$swap_column_data->internal_column] = $created_at;
                                }
                                if ($swap_column_data->internal_column == 'published_at') {
                                    $published_at = $this->create_date_format($content_key_data, $migrating_data['created_at'] ?? now());

                                    // $contentItem[$swap_column_data->internal_column] = $published_at  ;
                                    // dd($migrating_data[$swap_column_data->internal_column] );
                                    $migrating_data[$swap_column_data->internal_column] = $published_at;
                                }

                                if ($swap_column_data->internal_column == 'updated_at') {
                                    $updated_at = $this->create_date_format($content_key_data, $migrating_data['created_at'] ?? now());
                                    $migrating_data[$swap_column_data->internal_column] = $updated_at;
                                }
                                if ($assigned_table->content_type == 'categories') {
                                    $migrating_data['show_on'] = json_encode(array_keys(SHOW_ON), JSON_UNESCAPED_UNICODE);
                                    $migrating_data['content_type'] = 'category';
                                }
                            }
                        }
                    }
                }
                // dd($migrating_data);
                if ($migrating_data) {
                    $data[] = $migrating_data ?? [];
                }
            }
            // dd($migrating_data);
        }
        return $data ?? false;
        dd($data);
    }
}
