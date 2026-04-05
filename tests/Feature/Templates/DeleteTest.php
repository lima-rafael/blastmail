<?php

use App\Models\Template;

use function Pest\Laravel\assertSoftDeleted;
use function Pest\Laravel\delete;
pest()->group('templatesDelete');

it('should be able to delete a template from a list', function () {
    login();
    $template = Template::factory()->create();

    // dd($template, $template->email);

    delete(route('template.destroy', ['template' => $template]))
        ->assertRedirectToRoute('template.index')
        ->assertSessionHas('message', __('Template deleted succcessfully.'));

    assertSoftDeleted('templates', ['id' => $template->id]);
});