<?php

namespace App\Jobs;

use App\Mail\EmailCampaign;
use App\Models\CampaignMail;
use App\Models\Campaigns;
use App\Models\Subscriber;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Mail;

class SendEmailCampaignJob implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(
        public Campaigns $campaigns,
        public Subscriber $subscriber
    ){}

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        CampaignMail::query()
            ->create([
                'campaigns_id' => $this->campaigns->id,
                'subscriber_id' => $this->subscriber->id,
                'sent_at' => $this->campaigns->send_at,
            ]);

        Mail::to($this->subscriber->email)
                ->later($this->campaigns->send_at, new EmailCampaign($this->campaigns));
    }
}
