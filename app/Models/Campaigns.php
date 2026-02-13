<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Campaigns extends Model
{
    /** @use HasFactory<\Database\Factories\CampaignsFactory> */
    use HasFactory;
    use SoftDeletes;

    protected function casts()
    {
        return [
            'send_at' => 'datetime',
        ];
    }

    public function emailList()
    {
        return $this->belongsTo(EmailList::class);
    }

    public function mails(): HasMany
    {
        return $this->hasMany(CampaignMail::class);
    }
}
