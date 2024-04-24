<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class JobListing extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'page_title', 'company_name', 'listing_url', 'company_url', 'img_url', 'notes', 'salary_from', 'salary_to', 'contact_name', 'contact_phone', 'contact_email', 'listing_plain_text', 'generated_description', 'location', 'status', 'listing_language'
    ];

    public function tags()
    {
        return $this->belongsToMany(Tag::class)->withTimestamps();
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
