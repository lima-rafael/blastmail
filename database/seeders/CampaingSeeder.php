<?php

namespace Database\Seeders;

use App\Models\Campaing;
use App\Models\EmailList;
use App\Models\Template;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CampaingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for($i = 0; $i < 10; $i++){
            $emailList = EmailList::query()->inRandomOrder()->first();
            $template = Template::query()->inRandomOrder()->first();

            Campaing::factory()->create([
                'email_list_id' => $emailList->id,
                'template_id' => $template->id
            ]);
        }
    }
}
