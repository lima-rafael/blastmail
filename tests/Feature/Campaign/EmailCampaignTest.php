<?php

use App\Mail\EmailCampaign;
use App\Models\CampaignMail;
use App\Models\Campaigns;
use App\Models\EmailList;
use App\Models\Subscriber;
use App\Models\Template;

test('links on the body should be replace with the traking link', function(){
    $template = Template::factory()->create([
        'body' => '<div>Hello Word! <a href="http://www.google.com">Click Here!</a></div>'
    ]);
    $emailList = EmailList::factory()->has(Subscriber::factory()->count(3))->create();
    $campaign = Campaigns::factory()->for($emailList)->create(['body' => $template->body, 'send_at' => now()->addDays(2)->format('Y-m-d')]);
    $subscriber = $emailList->subscribers->first();
    $mail = CampaignMail::query()->create(['campaigns_id' => $campaign->id, 'subscriber_id' => $subscriber->id, 'sent_at' => $campaign->send_at]);

    $email = (new EmailCampaign($campaign, $mail))->render();

    $pattern = '/href="([^"]*)google.com"/';
    preg_match_all($pattern, $email, $matches);
    $value = $matches[1][0];
    expect($value)->toBe(
        route('tracking.clicks', ['mail' => $mail, 'f' => 'http://www.'])
    );
});