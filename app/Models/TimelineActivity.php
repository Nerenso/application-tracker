<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property int $user_id
 * @property int $job_listing_id
 * @property string $title
 * @property string $description
 * @property \Carbon\Carbon $activity_date
 * @property string $activity_type
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 */

class TimelineActivity extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'job_listing_id',
        'title',
        'description',
        'activity_date',
        'activity_type',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function jobListing(): BelongsTo
    {
        return $this->belongsTo(JobListing::class);
    }
}
