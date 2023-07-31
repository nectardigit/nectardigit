<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Traits\DatabaseUpdater\DatabaseUpdater;
use App\Traits\Shared\AdminSharedTrait;
use DB;



class FetchTableController extends Controller
{
    use DatabaseUpdater;
    use AdminSharedTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $menu;
    public function __construct()
    {
        $this->get_web();
        $this->middleware(['permission:fetchData-list|fetchData-create|fetchData-edit|fetchData-delete'], ['only' => [
            'index',
            'store',
            'getRowExternal',
            'getRowInternal',
        ]]);
        $this->middleware(['permission:fetchData-create'], ['only' => [
            'create', 'store', 'getRowExternal',
            'getRowInternal',
        ]]);
        $this->middleware(['permission:fetchData-edit'], ['only' => ['edit', 'update']]);
        $this->middleware(['permission:fetchData-delete'], ['only' => ['destroy']]);
    }
    protected function getTable($request, $connection = null)
    {
        $database1 = collect(DB::connection($connection)->select('show tables'));

        $database2 = collect(DB::connection('mysql2')->select('show tables'));

        // dd($data);
        $data = [
            'database1' => $database1,
            'database2' => $database2,
        ];
        return $data;
    }
    protected function getDbName($request)
    {
        $dbname1 = "Tables_in_" . env('DB_DATABASE');
        $dbname2 = "Tables_in_" . env('DB_DATABASE_SECOND');

        // if($request->keyword){
        //     $database = $request->keyword;
        //     $db = "Tables_in_".$database;

        // }
        $db = [
            'dbname1' => $dbname1,
            '$dbname2' => $dbname2
        ];
        return $db;
    }
    public function index(Request $request, $connection = null)
    {
        // dd($request->all());
        // $data = DB::select('SHOW TABLES');
        $database1 = collect(DB::connection($connection)->select('show tables'));

        $database2 = collect(DB::connection('mysql2')->select('show tables'));
        $dbname1 = "Tables_in_" . env('DB_DATABASE');
        $dbname2 = "Tables_in_" . env('DB_DATABASE_SECOND');



        return view('admin/fetchtable/tables', compact('database1', 'database2', 'dbname1', 'dbname2'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($table)
    {
    }
    public function getRowInternal($table)
    {
        // dd($table);
        $columns = \DB::connection()->getSchemaBuilder()->getColumnListing($table);
        if ($table == env('DB_DATABASE_SECOND')) {
            $columns = \DB::connection('mysql2')->getSchemaBuilder()->getColumnListing($table);
        }
        return view('admin/fetchtable/rows', compact('columns'));
    }
    public function getRowExternal($table)
    {
        // dd($table);
        $columns = \DB::connection('mysql2')->getSchemaBuilder()->getColumnListing($table);

        return view('admin/fetchtable/rows', compact('columns'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
