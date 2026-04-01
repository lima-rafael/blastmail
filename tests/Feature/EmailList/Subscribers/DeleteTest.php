<?php

use App\Models\Subscriber;

use function Pest\Laravel\assertSoftDeleted;
use function Pest\Laravel\delete;
pest()->group('subscriberDelete');

it('should be able to delete a subscriber from a list', function(){
    login();
    $subscriber = Subscriber::factory()->create();

    // dd($subscriber, $subscriber->email);

    delete(route('subscribers.destroy', ['emailList' => $subscriber->email_list_id, 'subscriber' => $subscriber]))
        ->assertRedirect();

    assertSoftDeleted('subscribers', ['id' => $subscriber->id]);
});