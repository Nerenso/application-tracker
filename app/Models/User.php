<?php

namespace App\Models;

use App\Notifications\EmailVerificationNotification;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Notifications\PasswordResetNotification;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function jobListings(): HasMany
    {
        return $this->hasMany(JobListing::class);
    }

    public function workExperiences(): HasMany
    {
        return $this->hasMany(WorkExperience::class);
    }

    public function tags(): HasMany
    {
        return $this->hasMany(Tag::class);
    }

    public function contactDetail(): HasOne
    {
        return $this->hasOne(ContactDetail::class);
    }

    public function education(): HasMany
    {
        return $this->hasMany(Education::class)->orderBy('created_at', "asc");
    }

    public function skills(): HasMany
    {
        return $this->hasMany(Skill::class);
    }

    public function certifications(): HasMany
    {
        return $this->hasMany(Certification::class)->orderBy('created_at', 'asc');
    }

    public function coverLetters(): HasMany
    {
        return $this->hasMany(CoverLetter::class);
    }

    public function preparations(): HasMany
    {
        return $this->hasMany(Preparation::class);
    }


    public function sendPasswordResetNotification($token)
    {
        $this->notify(new PasswordResetNotification($token, $this));
    }

    public function sendEmailVerificationNotification()
    {
        $this->notify(new EmailVerificationNotification($this));
    }
}
