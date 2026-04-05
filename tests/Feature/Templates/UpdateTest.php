<?php

use App\Models\Template;

use function Pest\Laravel\{assertDatabaseHas, put, withoutExceptionHandling};

pest()->group('templatesUpdate');

beforeEach(function () {
    login();

    $this->template = Template::factory()->create([
        'name' => 'Template Master',
        'body' => '<span>Hello world!</span>',
    ]);
    $this->route = route('template.update', $this->template);
});

it('should be able to create a new subscriber', function () {
    put($this->route, ['name' => 'Changing Template', 'body' => '<span>Has Changed</span>',])
        ->assertRedirect()
        ->assertSessionHas('message', __('Template updated successfully'));

    assertDatabaseHas('templates', [
        'name' => 'Changing Template',
        'body' => '<span>Has Changed</span>',
    ]);
});

test('name should be required', function () {
    put($this->route, ['name' => null,'body' => '<span>Hello world!</span>',])
        ->assertSessionHasErrors(['name' => __('validation.required', ['attribute' => 'name'])]);
});

test('name should have a max of 255 character', function () {
    put($this->route, ['name' => str_repeat('*', 256),'body' => '<span>Hello world!</span>',])
        ->assertSessionHasErrors(['name' => __('validation.max.string', ['attribute' => 'name', 'max' => 255])]);
});

test('email should be required', function () {
    put($this->route, ['name' => 'Joe Doe','body' => null])
        ->assertSessionHasErrors(['body' => __('validation.required', ['attribute' => 'body'])]);
});
