<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\News;
use App\Models\OldDatabase;
use App\Traits\Shared\AdminSharedTrait;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Throwable;

class MigrateDatabaseController extends Controller
{
    //
    use AdminSharedTrait;
    public function __construct()
    {

    }
    protected $page_limit = 100;
    public function index(Request $request, $connection = null)
    {

        // $database1 = collect(DB::connection($connection)->select('show tables'));

        // $database2 = collect(DB::connection('mysql2')->select('show tables'));
        // $dbname1 = "Tables_in_" . env('DB_DATABASE');
        // $dbname2 = "Tables_in_" . env('DB_DATABASE_SECOND');
        // $data = [
        //     'database1' => $database1,
        //     'database2' => $database2,
        //     'dbname1' => $dbname1,
        //     'dbname2' => $dbname2,
        // ];
        //   dd($db);
        $old_db = OldDatabase::orderBy('id', 'DESC')->get();
        // dd($old_db);
        $data = [
            'old_db' => $old_db,
        ];
        // return view('admin/fetchtable/tables', compact('database1','database2','dbname1','dbname2'));
        return view('admin.migration.old-db-list', $data);
    }
    public function getClassesList($dir)
    {

        $classes = \File::allFiles($dir);
        foreach ($classes as $class) {
            $class->classname = str_replace(
                [app_path(), 'Models', '\\', '.php'], 
                ['', '', '', ''],
                $class->getRealPath()

            );
        }
        return $classes;
    }
    public function create(Request $request)
    {
        // $categories = Menu::where('publish_status', '1')->where('slug', 'category')->pluck('');
        // dd($categories);
        $database = collect(DB::connection(null)->select('show tables'));
        // dd($database);
        $models = $this->getClassesList(app_path('Models'));
        // dd($models);
        // $models = $models->classname;
        $db = "Tables_in_" . env('DB_DATABASE');
        $data = [
            'old_db' => null,
            'route' => route('migration.store'),
            "database" => $database,
            "db" => $db,
            "models" => $models,
            "frameworkType" => $this->frameworkType,
            "website_available_content" => $this->website_available_content
        ];
        return view('admin/migration/add-database-form', $data);
    }
    public function store(Request $request)
    {
        // dd($request->all());
        $this->validate($request, [
            'url' => 'required|url',
            "api_url" => "required|url",
            "framework" => "required|string|",
            "content_type" => "required|string",
            "aspected_table" => "required|string",
        ]);
        $data = $request->only('url', 'api_url', 'framework', 'content_type', 'model_name', 'aspected_table');
        $data['added_by'] = $request->user()->id;
        DB::beginTransaction();
        try {
            OldDatabase::create($data);

            DB::commit();
            $request->session()->flash('success', 'Website url added successfully.');
            return redirect()->route('migration.index');
        } catch (\Exception $error) {
            DB::rollback();
            $request->session()->flash('error', $error->getMessage());
            return redirect()->back();
        }
    }
    public function edit(Request $request, $id)
    {
        $old_db = OldDatabase::find($id);
        if (!$old_db) {
            $request->session()->flash('error', 'Invalid information.');
            return redirect()->route('migration.index');
        }
        $database = collect(DB::connection(null)->select('show tables'));
        $db= "Tables_in_".env('DB_DATABASE');
        $models = $this->getClassesList(app_path('Models'));
        // dd($models);
        $data = [
            'old_db' => $old_db,
            "route" => route('migration.update', $old_db->id),
            "database" => $database,
            "db" => $db,
            "models" => $models,

        ];
        return view('admin/migration/add-database-form', $data);
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'url' => 'required|url',
            "api_url" => "required|url",
            "framework" => "required|string|",
            "content_type" => "required|string",
            "aspected_table" => "required|string",
        ]);
        $old_db = OldDatabase::find($id);
        if (!$old_db) {
            $request->session()->flash('error', 'Invalid information.');
            return redirect()->route('migration.index');
        }

        $data = $request->only('url', 'api_url', 'framework', 'content_type', 'aspected_table', 'model_name');
        // $data['added_by'] = $request->user()->id;
        DB::beginTransaction();
        try {
            $old_db->fill($data)->save();

            DB::commit();
            $request->session()->flash('success', 'Website url updated successfully.');
            return redirect()->route('migration.index');
        } catch (\Exception $error) {
            DB::rollback();
            $request->session()->flash('error', $error->getMessage());
            return redirect()->back();
        }
    }

    public function show(Request $request, $id)
    {
        $old_db = OldDatabase::find($id);
        if (!$old_db) {
            $request->session()->flash('error', 'Invalid information.');
            return redirect()->route('migration.index');
        }
        // dd($old_db);
        $type = $old_db->content_type;
        // dd($old_db);
        // cache()->forget('internal_columns');
        $table = null;
        
        $internal_columns = DB::connection()->getSchemaBuilder()->getColumnListing($old_db->aspected_table);

        // dd($internal_columns);
        $client = new Client();
        $response = $client->get($old_db->api_url, [
            "query" => [
                'per_page' => 1,
            ],
            // 'headers' => $headers,
            // 'body' => $fields,
        ]);
        // dd($response->getBody()->getContents());
        $content = [];
        if ($response->getStatusCode() == 200) {
            $content = json_decode($response->getBody()->getContents());

        }
        // dd(json_decode($response->getBody()->getContents()));
        // dd($content);
        
        $data = [
            'old_db' => $old_db,
            "content" => $content,
            "internal_columns" => $internal_columns,
        ];
        if($old_db->framework == 'ci'){
            // dd($content);
            $data['content']  = $content->categories;
        }
        $data["route"] = route('assignWordpressColumns', $old_db->id);
        return view('admin.migration.content-list', $data);
    }
    public function assignWordpressColumns(Request $request, $wp_table_id){
        // dd($wp_table_id);
        $assigned_table = OldDatabase::find($wp_table_id);
        if (!$assigned_table) {
            $request->session()->flash('error', 'Invalid information.');
            return redirect()->route('migration.index');
        }
        // dd($assigned_table);
        // dd($request->all());
        if ($request->column) {
            try {
                foreach ($request->column as $external_column => $internal_column) {
                    dd($external_column);
                    $data = [
                        'external_column' => $external_column,
                        'internal_column' => $internal_column,
                        'external_table' => $assigned_table->external_table,
                        'internal_table' => $assigned_table->internal_table,
                        'external_table_id' => $assigned_table->id,
                        'internal_table_id' => $assigned_table->id,
                        'created_by' => auth()->id(),
                        'updated_by' => auth()->id(),
                        "is_primary_key" => $request->is_primary_key[$external_column] ?? '0',
                    ];
                    // dd($data);
                    $column_info = AssignedMigrationTableColumn::where('external_column', $external_column)
                        ->where('external_table', $assigned_table->external_table)
                        ->where('internal_table', $assigned_table->internal_table)
                        ->first();
                    if ($column_info) {
                        $column_info->fill($data)->save();
                    } else {
                        AssignedMigrationTableColumn::create($data);
                    }
                    // dd($data);
                }
                $request->session()->flash('success', 'Table column pair updated successfully. Now you can migrate data.');
                return redirect()->route('migrateTableContent', $table_name);
            } catch (\Exception $error) {
                $request->session()->flash('error', $error->getMessage());
                return redirect()->back();
            }
        }
    }

    public function updateImageName(Request $request, $id)
    {
        $old_db = OldDatabase::find($id);

        if (!$old_db) {
            $request->session()->flash('error', 'Invalid information.');
            return redirect()->route('migration.index');
        }
        if (!$old_db->content_type == 'images') {
            $request->session()->flash('error', 'Invalid information.');
            return redirect()->route('migration.index');
        }
        $images = News::select('id', 'oldId', 'thumbnail')
            ->where('oldId', '!=', null)
            ->where('path', null)
            ->paginate(20);
        if (!$old_db->framework == 'wordpress') {
            $request->session()->flash('error', 'Feature only available for wordpress.');
            return redirect()->route('migration.index');
        }
        // dd($old_db);
        // dd($images);
        $data = [
            'old_db' => $old_db,
            // "content" => $content,
            // "internal_columns" => $internal_columns,
            "images" => $images,
        ];

        return view('admin.migration.update-images', $data);
    }

    public function startMigratingImages(Request $request)
    {
        // dd($request->all());
        $old_db = OldDatabase::find($request->content_id);
        // dd($old_db);

        if (!$old_db) {
            // $request->session()->flash('error', 'Invalid information.');
            // return redirect()->route('migration.index');
            return response()->json([
                'status' => false,
                'messsage' => "Invalid information",
            ]);
        }
        $client = new Client();
        $images = News::where('oldId', '!=', null)->where('path', null)->paginate($this->page_limit);
        if ($images->count() < 1) {
            return response()->json([
                'status' => false,
                "message" => "Image item not found.",
            ]);
        }
        // dd($images);
        $all_pages = $images->lastPage();
        // DB::beginTransaction();
        $count_page = 1;
        do {
            $images = News::where('oldId', '!=', null)->where('path', null)->paginate($this->page_limit);
            // dd($images);
            foreach ($images as $imageItem) {
                try {
                    if ($imageItem->thumbnail != '0' && $imageItem->thumbnail != 0) {
                        // get image data
                        $response = $client->get($old_db->api_url . $imageItem->thumbnail, [
                            // "query" => $count_page,
                        ]);
                        // dd($response);
                        if ($response->getStatusCode() == 200) {
                            $content = json_decode($response->getBody()->getContents());
                            // dd($content);
                            $image_name = explode('/', $content->media_details->file);
                            // dd(end($image_name));
                            $data = [
                                'thumbnail' => end($image_name),
                                'path' => explode(end($image_name), $content->media_details->file)[0],
                            ];
                            // DB::beginTransaction();
                            $imageItem->fill($data)->save();
                        }
                    }else {
                        $imageItem->fill(['thumbnail' => NULL, 'path' => '-'])->save();
                    }
                } catch (Throwable $t) {
                    $imageItem->fill(['thumbnail' => NULL, 'path' => '-'])->save();
                    continue;
                }
            }
            // dd($images);
            $count_page++;
        } while ($count_page <= $all_pages);
        // DB::commit();
        return response()->json([
            'status' => true,
            "message" => "Image data updated successfully.",
        ]);

    }
}
