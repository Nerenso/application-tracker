<?php

namespace App\Models;

use GuzzleHttp\Psr7\Query;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Contracts\Database\Query\Builder as QueryBuilderContract;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Facades\DB;

class JobListing extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'page_title',
        'company_name',
        'listing_url',
        'company_url',
        'img_url',
        'notes',
        'salary_from',
        'salary_to',
        'contact_name',
        'contact_phone',
        'contact_email',
        'listing_plain_text',
        'generated_description',
        'location',
        'status',
        'listing_language',
        'structured_listing',
        'is_bookmarked',
    ];

    public function tags()
    {
        return $this->belongsToMany(Tag::class)->withTimestamps();
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function coverLetter(): HasOne
    {
        return $this->hasOne(CoverLetter::class);
    }

    public function preparation(): HasOne
    {
        return $this->hasOne(Preparation::class);
    }

    public function scopeFilter(Builder $query, array $filters)
    {

        // dd($filters);

        if ($filters['selectedTags'] ?? false) {
            foreach ($filters['selectedTags'] as $tagId) {
                $query->whereHas(
                    'tags',
                    function (Builder $query) use ($tagId) {
                        return $query->where('tags.id', $tagId);
                    }
                );
            }
        }

        $query->when(
            $filters['show_bookmarked_only'] ?? false,
            fn($query, $value) => $query->where('is_bookmarked', 1)
        )->when(
            $filters['salary_from'] ?? false,
            fn($query, $value) => $query->where('salary_from', '>=', $value)
        )->when(
            $filters['salary_to'] ?? false,
            fn(Builder $query, $value) => $query->where('salary_to', '<=', $value)->orWhere('salary_from', '<=', $value)
        );

        return $query;
    }

    public function scopeUserListingsWithTags(Builder $query): Builder
    {
        return $query->where("user_id", auth()->user()->id)
            ->orderByDesc('created_at')
            ->with('tags', function (QueryBuilderContract $query) {
                $query->orderBy('title', 'ASC');
            });
    }

    public function scopeSearch(Builder $query, $searchTerm)
    {
        return $query->when(
            $searchTerm ?? false,
            fn($query, $value) => $query->where(DB::raw('LOWER(structured_listing)'), 'LIKE', '%' . strtolower(trim($value)) . '%')
        );
    }
}
