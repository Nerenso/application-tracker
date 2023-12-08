<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobListing extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'page_title', 'company_name', 'listing_url', 'company_url', 'img_url'
    ];
}
