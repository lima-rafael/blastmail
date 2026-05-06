<?php

use App\Models\Campaigns;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;

use function Pest\Laravel\get;
use function Pest\Laravel\getJson;

pest()->group('campaigns');

beforeEach(function(){
    login();
});

it('only logged users can acess the campaigns', function(){
    Auth::logout();
    getJson(route('campaigns.index'))
        ->assertUnauthorized();
});

it('should be possible see the entire list of campaigns', function(){
    Campaigns::factory()->count(5)->create();

    get(route('campaigns.index'))
        ->assertViewHas('campaigns', function($value){
            expect($value)->count(5);
            return true;
        });
});

it('should be able to search a campaign', function(){
    Campaigns::factory()->count(5)->create();
    Campaigns::factory()->create(['name' => 'Charlie Smith', 'deleted_at' => null]);

    //Filtrar com o emial
    get(route('campaigns.index', ['search' => 'Charlie']))
        ->assertViewHas('campaigns', function($value){
            expect($value)->count(1);
            expect($value)->first()->id->toBe(6);
            return true;
        });
});

it('should be able filter with ID', function(){
    Campaigns::factory()->create(['name' => 'Jane Doe']);
    Campaigns::factory()->create(['name' => 'Joe Doe', 'deleted_at' => null]);

    //Filtrar com o id
    get(route('campaigns.index', ['search' => 2]))
        ->assertViewHas('campaigns', function($value){
            expect($value)->count(1);
            expect($value)->first()->id->toBe(2);
            return true;
        });
});

it('should be able to show deleted records', function(){
    Campaigns::factory()->create(['deleted_at' => now()]);

    Campaigns::factory()->create();
    
    get(route('campaigns.index'))
        ->assertViewHas('campaigns', function($value){
            expect($value)->count(1);
            return true;
        });


    get(route('campaigns.index', ['withTrashed' => 1]))
        ->assertViewHas('campaigns', function($value){
            expect($value)->count(2);
            return true;
        });
});

it('should be paginated', function(){
    Campaigns::factory()->count(30)->create();
    
    get(route('campaigns.index'))
        ->assertViewHas('campaigns', function($value){
            expect($value)->count(5);
            expect($value)->toBeInstanceOf(LengthAwarePaginator::class);
            return true;
        });
});