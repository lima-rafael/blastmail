<?php

use App\Models\Template;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;

use function Pest\Laravel\get;
use function Pest\Laravel\getJson;

pest()->group('templates');

beforeEach(function(){
    login();
});

it('only logged users can acess the templates', function(){
    Auth::logout();
    getJson(route('template.index'))
        ->assertUnauthorized();
});

it('should be possible see the entire list of templates', function(){
    Template::factory()->count(5)->create();

    get(route('template.index'))
        ->assertViewHas('templates', function($value){
            expect($value)->count(5);
            return true;
        });
});

it('should be able to search a template', function(){
    Template::factory()->count(5)->create();
    Template::factory()->create(['name' => 'Charlie Smith',]);

    //Filtrar com o emial
    get(route('template.index', ['search' => 'Charlie']))
        ->assertViewHas('templates', function($value){
            expect($value)->count(1);
            expect($value)->first()->id->toBe(6);
            return true;
        });
});

it('should be able filter with ID', function(){
    Template::factory()->create(['name' => 'Jane Doe',]);
    Template::factory()->create(['name' => 'Joe Doe',]);

    //Filtrar com o id
    get(route('template.index', ['search' => 1]))
        ->assertViewHas('templates', function($value){
            expect($value)->count(1);
            expect($value)->first()->id->toBe(1);
            return true;
        });
});

it('should be able to show deleted records', function(){
    Template::factory()->create(['deleted_at' => now()]);

    Template::factory()->create();
    
    get(route('template.index'))
        ->assertViewHas('templates', function($value){
            expect($value)->count(1);
            return true;
        });


    get(route('template.index', ['withTrashed' => 1]))
        ->assertViewHas('templates', function($value){
            expect($value)->count(2);
            return true;
        });
});

it('should be paginated', function(){
    Template::factory()->count(30)->create();
    
    get(route('template.index'))
        ->assertViewHas('templates', function($value){
            expect($value)->count(5);
            expect($value)->toBeInstanceOf(LengthAwarePaginator::class);
            return true;
        });
});