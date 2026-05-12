<?php

use App\Mail\EmailCampaign;
use App\Models\CampaignMail;
use App\Models\Campaigns;
use App\Models\EmailList;
use App\Models\Subscriber;
use App\Models\Template;

use function Pest\Laravel\get;
use function PHPUnit\Framework\assertTrue;

beforeEach(function(){
    $template = Template::factory()->create([
        'body' => '<div>Hello Word! <a href="http://www.google.com">Click Here!</a></div>'
    ]);
    $emailList = EmailList::factory()->has(Subscriber::factory()->count(3))->create();
    $this->campaign = Campaigns::factory()->for($emailList)->create(['body' => $template->body, 'send_at' => now()->addDays(2)->format('Y-m-d')]);
    $subscriber = $emailList->subscribers->first();
    $this->mail = CampaignMail::query()->create(['openings' => 0,'campaigns_id' => $this->campaign->id, 'subscriber_id' => $subscriber->id, 'sent_at' => $this->campaign->send_at]);
});

it('should increment openings on the database if the campaign is tracking openings', function(){
    $this->campaign->update(['track_open' => true]);
    get(route('tracking.openings', ['mail' => $this->mail]));
    expect($this->mail)->refresh()->openings->toBe(1);
});

it('should not increment openings on the database if the campaign is not tracking openings', function(){
    $this->campaign->update(['track_open' => false]);
    get(route('tracking.openings', ['mail' => $this->mail]));
    expect($this->mail)->refresh()->openings->toBe(0);
});

test('check id on the email has the link for the tracking openings', function(){
    $email = (new EmailCampaign($this->campaign, $this->mail))->render();

    assertTrue(str($email)->contains(route('tracking.openings', $this->mail)));
});