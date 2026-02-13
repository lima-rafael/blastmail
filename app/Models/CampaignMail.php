<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\belongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CampaignMail extends Model
{
    use HasFactory;

    public function campaigns(): belongsTo
    {
        return $this->belongsTo(Campaigns::class);
    }

    public function subscriber(): belongsTo
    {
        return $this->belongsTo(Subscriber::class);
    }
}
