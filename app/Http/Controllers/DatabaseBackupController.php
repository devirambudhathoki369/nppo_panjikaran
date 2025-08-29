<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use Carbon\Carbon;

class DatabaseBackupController extends Controller
{
    /**
     * Show the backup form
     */
    public function index()
    {
        return view('database.backup');
    }

    /**
     * Download complete database backup
     */
    public function download(Request $request)
    {
        try {
            $backupFileName = 'complete_database_backup_' . date('Y-m-d_H-i-s') . '.sql';

            $backupContent = "-- Complete Database Backup\n";
            $backupContent .= "-- Generated on: " . now()->format('Y-m-d H:i:s') . "\n";
            $backupContent .= "-- System: " . config('app.name') . "\n\n";

            $backupContent .= "SET FOREIGN_KEY_CHECKS=0;\n\n";

            // Get all tables from the database
            $tables = DB::select('SHOW TABLES');
            $databaseName = DB::getDatabaseName();
            $tableKey = "Tables_in_" . $databaseName;

            foreach ($tables as $table) {
                $tableName = $table->$tableKey;
                $backupContent .= $this->generateCompleteTableBackup($tableName);
            }

            $backupContent .= "\nSET FOREIGN_KEY_CHECKS=1;\n";
            $backupContent .= "\n-- Complete database backup finished\n";

            return Response::make($backupContent, 200, [
                'Content-Type' => 'application/sql',
                'Content-Disposition' => 'attachment; filename="' . $backupFileName . '"'
            ]);

        } catch (\Exception $e) {
            return back()->with('error', 'ब्याकअप सिर्जना गर्न असफल: ' . $e->getMessage());
        }
    }

    /**
     * Generate complete backup for a table
     */
    private function generateCompleteTableBackup($table)
    {
        $backupContent = "\n-- ========================================\n";
        $backupContent .= "-- Table: {$table}\n";
        $backupContent .= "-- ========================================\n\n";

        try {
            // Get table structure
            $columns = DB::getSchemaBuilder()->getColumnListing($table);

            if (empty($columns)) {
                return $backupContent . "-- Warning: No columns found for table {$table}\n\n";
            }

            $backupContent .= "DROP TABLE IF EXISTS `{$table}`;\n\n";

            // Get actual CREATE TABLE statement
            try {
                $createTable = DB::select("SHOW CREATE TABLE `{$table}`");
                if (!empty($createTable)) {
                    $backupContent .= $createTable[0]->{'Create Table'} . ";\n\n";
                }
            } catch (\Exception $e) {
                // Fallback to simple structure
                $backupContent .= "CREATE TABLE `{$table}` (\n";
                $columnDefinitions = [];
                foreach ($columns as $column) {
                    $columnDefinitions[] = "  `{$column}` TEXT";
                }
                $backupContent .= implode(",\n", $columnDefinitions);
                $backupContent .= "\n);\n\n";
            }

            // Get all data from table
            $records = DB::table($table)->get();

            if ($records->count() > 0) {
                $backupContent .= "-- Data for table {$table}\n";

                foreach ($records as $record) {
                    $recordArray = (array) $record;
                    $columnsList = '`' . implode('`, `', array_keys($recordArray)) . '`';

                    $values = array_map(function($value) {
                        if ($value === null) {
                            return 'NULL';
                        }
                        return "'" . str_replace("'", "''", addslashes($value)) . "'";
                    }, array_values($recordArray));

                    $valuesString = implode(', ', $values);
                    $backupContent .= "INSERT INTO `{$table}` ({$columnsList}) VALUES ({$valuesString});\n";
                }
            } else {
                $backupContent .= "-- No data in table {$table}\n";
            }

            $backupContent .= "\n";

        } catch (\Exception $e) {
            $backupContent .= "-- Error backing up table {$table}: " . $e->getMessage() . "\n\n";
        }

        return $backupContent;
    }

    /**
     * Alternative backup method using Laravel's DB
     */
    public function downloadCustom(Request $request)
    {
        $request->validate([
            'from_date' => 'required|date',
            'to_date' => 'required|date|after_or_equal:from_date',
        ]);

        $fromDate = Carbon::parse($request->from_date)->startOfDay();
        $toDate = Carbon::parse($request->to_date)->endOfDay();

        try {
            $backupFileName = 'backup_' . $fromDate->format('Y-m-d') . '_to_' . $toDate->format('Y-m-d') . '_' . date('Y-m-d_H-i-s') . '.sql';

            $backupContent = "-- Database Backup\n";
            $backupContent .= "-- Date Range: {$fromDate->format('Y-m-d')} to {$toDate->format('Y-m-d')}\n";
            $backupContent .= "-- Generated on: " . now()->format('Y-m-d H:i:s') . "\n\n";

            // Get main tables with date filtering
            $tables = [
                'checklists' => 'created_at',
                'panjikarans' => 'created_at',
                'bargikarans' => 'created_at',
                'recommended_crops' => 'created_at',
                'recommended_pests' => 'created_at',
                'checklist_details' => 'created_at',
                'check_list_containers' => 'created_at',
                'check_list_formulations' => 'created_at',
                'notifications' => 'created_at'
            ];

            foreach ($tables as $table => $dateColumn) {
                if (DB::getSchemaBuilder()->hasTable($table)) {
                    $backupContent .= "\n-- Table: {$table}\n";
                    $backupContent .= "DROP TABLE IF EXISTS `{$table}`;\n";

                    // Get table structure
                    $createTable = DB::select("SHOW CREATE TABLE `{$table}`")[0];
                    $backupContent .= $createTable->{'Create Table'} . ";\n\n";

                    // Get filtered data
                    $records = DB::table($table)
                        ->whereBetween($dateColumn, [$fromDate, $toDate])
                        ->get();

                    if ($records->count() > 0) {
                        foreach ($records as $record) {
                            $recordArray = (array) $record;
                            $columns = implode('`, `', array_keys($recordArray));
                            $values = array_map(function($value) {
                                return $value === null ? 'NULL' : "'" . addslashes($value) . "'";
                            }, array_values($recordArray));
                            $valuesString = implode(', ', $values);

                            $backupContent .= "INSERT INTO `{$table}` (`{$columns}`) VALUES ({$valuesString});\n";
                        }
                    }
                    $backupContent .= "\n";
                }
            }

            return Response::make($backupContent, 200, [
                'Content-Type' => 'application/sql',
                'Content-Disposition' => 'attachment; filename="' . $backupFileName . '"'
            ]);

        } catch (\Exception $e) {
            return back()->with('error', 'ब्याकअप सिर्जना गर्न असफल: ' . $e->getMessage());
        }
    }
}
