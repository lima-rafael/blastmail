<?php

use App\Jobs\SendEmailsCampaign;
use App\Models\EmailList;
use App\Models\Template;
use Illuminate\Support\Facades\Bus;

use function Pest\Laravel\assertDatabaseCount;
use function Pest\Laravel\get;
use function Pest\Laravel\post;

beforeEach(function(){
    login();
    EmailList::factory()->create();
    $this->template = Template::factory()->create();
    $this->route = route('campaigns.create', ['tab' => 'schedule']);

    post(route('campaigns.create'), [
        'name' => 'First Campaign',
        'subject' => 'Subject',
        'email_list_id' => 1,
        'template_id' => 1,
        'track_open' => true,
        'track_click' => true,
    ]);

    Bus::fake();
});

test('all the data should be filled before entering the tab schedule', function() {
    get($this->route, ['referer' => $this->route])
        ->assertOk();
    session()->forget('campaigns::create');

    get($this->route, ['referer' => $this->route])
        ->assertRedirect(route('campaigns.create'));
});

test('when sending now it should just create the campaign', function() {
    post($this->route, ['send_when' => 'now'])
        ->assertSessionHasNoErrors();

    assertDatabaseCount('campaigns', 1);
});

test('when sending later the send at should be requiered', function() {
    post($this->route, ['send_when' => 'later'])
        ->assertSessionHasErrors(['send_at' => __('validation.required', ['attribute' => 'send at'])]);
});

test('campaign should be created when sending later', function() {
    post($this->route, ['send_when' => 'later', 'send_at' => now()->addDays(5)])
        ->assertSessionHasNoErrors();

    assertDatabaseCount('campaigns', 1);
});

test('campaign should be in the futere', function() {
    post($this->route, ['send_when' => 'later', 'send_at' => now()->subDays(5)])
        ->assertSessionHasErrors(['send_at' => __('validation.after', ['attribute' => 'send at', 'date' => 'today'])]);
});

test('check if the job if being queued', function() {
    post($this->route, ['send_when' => 'now']);

    Bus::assertDispatchedAfterResponse(SendEmailsCampaign::class);
});

test('after everything we should redirect to campaign index route', function() {
    post($this->route, ['send_when' => 'now'])
        ->assertRedirect(route('campaigns.index'));
});