<?php

namespace Database\Seeders;

use App\Models\CampaignMail;
use App\Models\Campaigns;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CampaignMailSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Campaigns::query()->with('emailList', 'emailList.subscribers')->get()
            ->each(function(Campaigns $campaigns){
                foreach ($campaigns->emailList->subscribers as $subscriber) {
                    CampaignMail::factory()
                        ->create([
                            'campaigns_id' => $campaigns->id,
                            'subscriber_id' => $subscriber->id,
                            'sent_at' => $campaigns->send_at,
                        ]);
                }
            });
    }
}
