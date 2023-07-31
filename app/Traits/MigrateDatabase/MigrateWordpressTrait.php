<?php
namespace App\Traits\MigrateDatabase;

use App\Events\DataMigratedEvent;
use App\Models\News;
use App\Models\Menu;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\DB;

/**
 *
 */
trait MigrateWordpressTrait
{
    protected $content_type = null;
    protected function migrateWordpress($old_db, $request)
    {
        $type = $old_db->content_type;
        $table = null;
        if ($type == 'categories') {
            // $this->content_type = $type;
            $table = 'menus';
        } else if ($type == 'news') {
            $table = 'news';
        }
        // dd($old_db);
        // cache()->forget('internal_columns');
        $internal_columns = DB::connection()->getSchemaBuilder()->getColumnListing($old_db->aspected_table);
        $client = new Client();
        $json_column = ['title', 'description', 'summary', 'name', 'short_description', 'position'];
        set_time_limit(0);
        DB::beginTransaction();
        try {
            // $url = "https://www.arthiksandesh.com/81369/";
            // $response = $client->get($url);
            // dd($response);
            $i = 0;
            do {
                $i++;
                $params = array_merge($this->query_params($type), ['page' => $i, 'per_page' => 60]);
                $response = $client->get($old_db->api_url, [
                    "query" => $params,
                ]);
                // dd($response->getBody()->getContents());
                $content = [];
                if ($response->getStatusCode() == 200) {
                    $content = json_decode($response->getBody()->getContents());
                }
                // dd($content);
                $data = [];
                if ($content) {
                    $old_ids = $this->getOldDBId($old_db);
                    // dd($old_ids);
                    // dd($request->column);
                    foreach ($content as $content_key => $contentItem) {
                        // dd($contentItem);
                        // dd($old_ids);
                        // dd(in_array($contentItem->id, $old_ids));
                        $fields = [];
                        if (!in_array($contentItem->id, $old_ids)) {
                            foreach ($request->column as $swap_key => $swap_column) {
                                // dd($request->column);

                                if ($swap_column && in_array($swap_column, $internal_columns)) {
                                    // echo $swap_key;
                                    if (in_array($swap_column, $json_column)) {
                                        // dd($swap_key);
                                        $fields[$swap_column] = $this->createJsonData($swap_column, $contentItem, $swap_key);
                                    } else {
                                        $fields[$swap_column] = $contentItem->$swap_key;
                                    }

                                    if ($swap_column == 'category') {
                                        $fields[$swap_column] = $this->generateCategory($contentItem->$swap_key);
                                    }
                                    if ($swap_column == 'publish_status') {
                                        $fields[$swap_column] = $this->createStatus($contentItem->$swap_key);
                                    }
                                    if ($swap_column == 'oldId') {
                                        if (!in_array($contentItem->$swap_key, $old_ids)) {
                                            $fields[$swap_column] = $contentItem->$swap_key;
                                        }
                                    }
                                    if ($swap_column == 'created_at') {
                                        $fields[$swap_column] = date('Y-m-d H:i:s', strtotime($contentItem->date));
                                    }
                                    if ($swap_column == 'updated_at') {
                                        $fields[$swap_column] = date('Y-m-d H:i:s', strtotime($contentItem->modified));
                                    }
                                    if($type == 'categories'){
                                        $fields['show_on'] = json_encode(array_keys(SHOW_ON), JSON_UNESCAPED_UNICODE) ;
                                        $fields['content_type'] = 'category';
                                    }
                                    // dd($fields);
                                }

                            }
                        }
                        // dd($fields);
                        if ($fields) {
                            $data[] = $fields ?? [];
                        }
                    }
                    // dd($data);
                    if ($data) {
                        // dd($data);
                        $tableClass = $this->getClassName($old_db);
                        $tableClass->insert($data); 
                        // if ($type == 'categories') {
                        //     $this->menu->insert($data);

                        // } else if ($type == 'news') {
                        //     $success = $this->news->insert($data);
                        // }
                        // dd('done');
                    }

                }
                DB::commit();
                // dd('done');

                echo 'time is \n' . round(microtime(true) - LARAVEL_START, 2);
                event(new DataMigratedEvent(round(microtime(true) - LARAVEL_START, 2)));
                // dd('done');

            } while ($content);

            return response()->json([
                'status' => true,
                "message" => "Content migrated successfully",
            ]);
        } catch (\Exception $error) {
            DB::rollback();
            return response()->json([
                'status' => false,
                'message' => $error->getMessage(),
            ]);
        }
    }
   
    
    protected function query_params($type)
    {   $query_params = [];
        if ($type == 'categories') {
            $query_params = [];
        } else if ($type == 'news') {
            $query_params = [
                'order' => 'asc',
                'orderby' => 'date',
            ];
        }
        return $query_params;
    }
}
