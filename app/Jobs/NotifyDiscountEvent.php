<?php

namespace App\Jobs;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Mail\NotifyDiscountEvent as EventMail;

class NotifyDiscountEvent implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $emailContent;

    /**
     * Create a new job instance.
     */
    public function __construct($path)
    {
        $this->emailContent = Storage::get($path);
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $customers = User::where('is_admin', 0)->get();
        foreach ($customers as $customer) {
            Mail::to($customer->email)->queue(new EventMail($this->emailContent)); // For some reason this might not work sometimes, idk why
        }
    }
}
