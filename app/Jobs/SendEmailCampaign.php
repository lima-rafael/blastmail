<?php

namespace App\Jobs;

use App\Mail\EmailCampaign;
use App\Models\Campaigns;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendEmailCampaign implements ShouldQueue
{
    use Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(
        public Campaigns $campaigns
    )
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        foreach ($this->campaigns->emailList->subscribers as $subscriber) {
            Mail::to($subscriber->email)
                ->later($this->campaigns->send_at, new EmailCampaign($this->campaigns));
        }
    }
}
