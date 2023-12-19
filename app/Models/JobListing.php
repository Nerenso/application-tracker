<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobListing extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'page_title', 'company_name', 'listing_url', 'company_url', 'img_url', 'notes', 'salary_from', 'salary_to', 'contact_name', 'contact_phone', 'contact_email'
    ];

    public function tags()
    {

        return $this->belongsToMany(Tag::class)->withTimestamps();
    }
}
