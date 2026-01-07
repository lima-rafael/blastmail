<?php

namespace Database\Seeders;

use App\Models\EmailList;
use App\Models\Subscriber;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Suky',
            'email' => 'suky@email.com',
        ]);

        EmailList::factory()->count(50)->create()
            ->each(function (EmailList $list){
                Subscriber::factory()
                    ->count(rand(50, 200))
                    ->create(['email_list_id' => $list->id]);
            });
    }
}
