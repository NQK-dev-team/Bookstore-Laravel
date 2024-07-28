<?php

use App\Models\Discount;
use Carbon\Carbon;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();

Schedule::call(function () {
    DB::transaction(function () {
        $startTime = microtime(true); // Capture start time

        $result = DB::table('delete_queue')->get();
        $counter = 0;
        foreach ($result as $row) {
            if (Carbon::now()->timezone(env('APP_TIMEZONE', 'Asia/Ho_Chi_Minh'))->diffInSeconds($row->created_at) < 0) {
                $user = User::find($row->user_id);
                if ($user) {
                    $user->delete();
                    $counter++;
                }
                DB::table('delete_queue')->where('id', $row->id)->delete();
            }
        }
        $endTime = microtime(true); // Capture end time
        $executionTime = $endTime - $startTime; // Calculate execution time
        $customer = ($counter === 0 || $counter === 1) ? 'customer' : 'customers';
        Log::channel('customer-delete')->info("{$counter} {$customer} deleted. Execution time: {$executionTime} seconds.");
    });
})->everyFiveMinutes();

Schedule::call(function () {
    DB::transaction(function () {
        $result = Discount::whereHas('eventDiscount')->where('status', true)->get();
        foreach ($result as $row) {
            if (Carbon::now()->timezone(env('APP_TIMEZONE', 'Asia/Ho_Chi_Minh'))->diffInSeconds($row->eventDiscount->end_time) < 0) {
                $row->status = false;
                $row->save();
            }
        }
    });
})->everyFiveMinutes();
