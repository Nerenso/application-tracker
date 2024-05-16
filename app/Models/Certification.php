<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Certification extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'title', 'organisation', 'certification_date', 'expiration_date', 'additional_information'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
