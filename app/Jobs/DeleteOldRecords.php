<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class DeleteOldRecords implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        try {
            $sixMonthsAgo = now()->subMonths(6);
            
            // Replace 'your_table' with the actual table name and 'created_at' with the timestamp column.
            DB::table('your_table')->where('created_at', '<', $sixMonthsAgo)->delete();
            
            Log::info('Old records deleted successfully.');
        } catch (\Exception $e) {
            Log::error('Error deleting old records: ' . $e->getMessage());
        }
    }
}
