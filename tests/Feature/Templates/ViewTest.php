<?php

use App\Models\Template;

use function Pest\Laravel\get;

pest()->group('templatesView');

beforeEach(function(){
    login();

    $this->template = Template::factory()->create();
    $this->route = route('template.show', $this->template);

});

it('should be able to open a template', function () {
    get($this->route)
        ->assertViewHas('template', $this->template);
});

it('should make sure that the template is being displayed', function () {
    get($this->route)
        ->assertSee($this->template->name)
        ->assertSee($this->template->body);
});