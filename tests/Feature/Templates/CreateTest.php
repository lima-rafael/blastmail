<?php

use App\Models\EmailList;
use App\Models\Subscriber;
use App\Models\Template;

use function Pest\Laravel\{assertDatabaseHas, post, withoutExceptionHandling};

pest()->group('templatesCreate');

beforeEach(function () {
    login();

    $this->template = Template::factory()->create();
    $this->route = route('template.store', $this->template);
});

it('should be able to create a new subscriber', function () {
    post($this->route, ['name' => 'Joe Doe', 'body' => '<span>Hello world!</span>',])
        ->assertRedirect(route('template.index'));

    assertDatabaseHas('templates', [
        'name' => 'Joe Doe',
        'body' => '<span>Hello world!</span>',
    ]);
});

test('name should be required', function () {
    post($this->route, ['name' => null,'body' => '<span>Hello world!</span>',])
        ->assertSessionHasErrors(['name' => __('validation.required', ['attribute' => 'name'])]);
});

test('name should have a max of 255 character', function () {
    post($this->route, ['name' => str_repeat('*', 256),'body' => '<span>Hello world!</span>',])
        ->assertSessionHasErrors(['name' => __('validation.max.string', ['attribute' => 'name', 'max' => 255])]);
});

test('email should be required', function () {
    post($this->route, ['name' => 'Joe Doe','body' => null])
        ->assertSessionHasErrors(['body' => __('validation.required', ['attribute' => 'body'])]);
});
