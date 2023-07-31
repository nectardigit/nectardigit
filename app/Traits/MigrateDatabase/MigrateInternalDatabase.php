<?php
namespace App\Traits\MigrateDatabase;

use App\Models\MigrationAssignedTable;

/**
 *
 */
trait MigrateInternalDatabase
{
    use MigrateCiTrait;
    protected function migrateDatabaseInternally($request)
    {
        //  dd($request->all());
        $old_db = MigrationAssignedTable::find($request->content_id);
        // dd($old_db);
        if (!$old_db) {
            return response()->json([
                'success' => false,
                "message" => "Invalid information.",
            ]);
        }
        if ($old_db->framework == 'wordpress') {
            return $this->migrateWordpress($old_db, $request);
        } else if ($old_db->framework == 'laravel') {
            return $this->migrateLaravel($old_db, $request);
        } else if ($old_db->framework == 'ci') {
            return $this->migrateCi($old_db);
        } else if ($old_db->framework == 'PHP') {
            return $this->migratePHP($old_db, $request);
        }
    }

   
}
