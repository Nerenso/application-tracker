<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Education extends Model
{
    use HasFactory;

    protected $fillable = ["user_id", "degree_name", "institution_name", "location", "years_attended", "gpa", "additional_information", "academic_progress"];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
