<?php
namespace App\Traits\DatabaseUpdater;

use App\Models\AssignedMigrationTableColumn;
use App\Models\MigrationAssignedTable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/**
 *
 */
trait DatabaseUpdater
{
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
    public function adminGetTables(Request $request, $connection = null)
    {

        $database1 = collect(DB::connection($connection)->select('show tables'));

        $database2 = collect(DB::connection('mysql2')->select('show tables'));
        $old_data = MigrationAssignedTable::get();
        // ->toArray();

        $dbname1 = "Tables_in_" . env('DB_DATABASE');
        $dbname2 = "Tables_in_" . env('DB_DATABASE_SECOND');
        $db = "Tables_in_" . env('DB_DATABASE');
        $models = $this->getClassesList(app_path('Models'));
        // dd($models);
        $data = [
            'database1' => $database1,
            'database2' => $database2,
            'dbname1' => $dbname1,
            'dbname2' => $dbname2,
            "db" => $db,
            "old_data" => $old_data,
            "models" => $models,
            "frameworkType" => $this->frameworkType,
        ];

        return view('admin/fetchtable/assign-tables', $data);
    }

    public function migrateTableContent(Request $request, $table_name)
    {
        // dd($table_name);
        // dd($request->all());
        $assigned_table = MigrationAssignedTable::
            where('external_table', $table_name)
        // ->where('internal_table', $internal_table)
            ->first();
        // dd($assigned_table);
        if (!$assigned_table) {
            $request->session()->flash('error', 'Assigned table not found.');
            return redirect()->route('adminGetTables');
        }
        if ($assigned_table->migrated) {
            $request->session()->flash('info', "Migrated table can not be migrated again.");
            return redirect()->route('adminGetTables');
        }
        if (!$assigned_table->external_table || !$assigned_table->internal_table) {
            $request->session()->flash('error', 'Table to migration has not completed. Please assign internal and external table properly before migrating.');
            return redirect()->route('adminGetTables');
        }

        $internal_columns = DB::connection()->getSchemaBuilder()->getColumnListing($assigned_table->internal_table);
        // $eternal_columns = DB::connection()->getSchemaBuilder()->getColumnListing($assigned_table->external_table);
        $external_table = DB::connection('mysql2')->table($assigned_table->external_table)->first();
        // dd($eternal_columns);
        // getSchemaBuilder()->getColumnListing($assigned_table->external_table);
        // dd($columns);
        $old_columns = AssignedMigrationTableColumn::select('id', 'internal_column', 'external_column', 'external_table', 'internal_table', 'is_primary_key')
            ->where('external_table', $assigned_table->external_table)
            ->where('internal_table', $assigned_table->internal_table)
            ->get();
        $data = [
            "external_table" => $external_table,
            "internal_columns" => $internal_columns,
            "assigned_table" => $assigned_table,
            "old_columns" => $old_columns->pluck('internal_column', 'external_column')->toArray(),
            "assinged_data" => $old_columns,
        ];
        // dd($old_columns);
        // dd($assigned_table);
        return view('admin/fetchtable/setup-migration-table-data', $data);

    }
    public function assignTableColumn(Request $request, $table_name)
    {
        // dd($request->all());
        $assigned_table = MigrationAssignedTable::
            where('external_table', $table_name)
        // ->where('internal_table', $internal_table)
            ->first();
        // dd($assigned_table);
        if ($request->column) {
            try {
                foreach ($request->column as $external_column => $internal_column) {
                    // dd($internal_column);
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

    public function adminUpdateAssingnedTables(Request $request)
    {
        // dd($request->all());
        if ($request->tables) {
            try {
                foreach ($request->tables as $external_table => $internal_table) {
                    $assigned_table = MigrationAssignedTable::
                        where('external_table', $external_table)
                    // ->where('internal_table', $internal_table)
                        ->first();
                    $data = [
                        'internal_table' => $internal_table,
                        'external_table' => $external_table,
                        "content_type" => $request->content_type[$external_table],
                        "model_name" => $request->model_name[$external_table],

                        "framework" => $request->framework[$external_table],
                    ];
                    if ($assigned_table) {
                        if (!$assigned_table->migrated) {
                            $data['updated_by'] = auth()->id();
                            $assigned_table->fill($data)->save();
                        }
                    } else {
                        $data = [
                            'internal_table' => $internal_table,
                            'external_table' => $external_table,
                            'migrated' => '0',
                            "content_type" => $request->content_type[$external_table],
                            "model_name" => $request->model_name[$external_table],

                            "framework" => $request->framework[$external_table],
                            // 'updated_by' => auth()->id(),
                            'created_by' => auth()->id(),
                        ];
                        MigrationAssignedTable::create($data);
                    }
                }
                $request->session()->flash('success', "Migration Table updated  modified successfully.");
                return redirect()->route('adminGetTables');
            } catch (\Exception $error) {
                $request->session()->flash('error', $error->getMessage());
                return redirect()->back();
            }

        }
    }

    public function moveDatabaseTableContent(Request $request, $external_table_name)
    {
        $assigned_table = MigrationAssignedTable::
            where('external_table', $external_table_name)
        // ->where('internal_table', $internal_table)
            ->first();
        // dd($assigned_table);
        if (!$assigned_table) {
            $request->session()->flash('error', 'Assigned table not found.');
            return redirect()->route('adminGetTables');
        }
        if ($assigned_table->migrated) {
            $request->session()->flash('info', "Migrated table can not be migrated again.");
            return redirect()->route('adminGetTables');
        }
        if (!$assigned_table->external_table || !$assigned_table->internal_table) {
            $request->session()->flash('error', 'Table to migration has not completed. Please assign internal and external table properly before migrating.');
            return redirect()->route('adminGetTables');
        }

        $internal_columns = DB::connection()->getSchemaBuilder()->getColumnListing($assigned_table->internal_table);
        // $eternal_columns = DB::connection()->getSchemaBuilder()->getColumnListing($assigned_table->external_table);
        $external_table = DB::connection('mysql2')->table($assigned_table->external_table)->first();
        // dd($eternal_columns);
        // getSchemaBuilder()->getColumnListing($assigned_table->external_table);
        // dd($columns);
        $old_columns = AssignedMigrationTableColumn::where('external_table', $assigned_table->external_table)
            ->where('internal_table', $assigned_table->internal_table)
            ->pluck('internal_column', 'external_column')->toArray();
        $data = [
            "external_table" => $external_table,
            "internal_columns" => $internal_columns,
            "assigned_table" => $assigned_table,
            "old_columns" => $old_columns,
        ];

        // dd($assigned_table);
        return view('admin/fetchtable/move-database-content', $data);
    }
}
