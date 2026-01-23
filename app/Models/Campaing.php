<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Campaing extends Model
{
    /** @use HasFactory<\Database\Factories\CampaingFactory> */
    use HasFactory;
    use SoftDeletes;
}
