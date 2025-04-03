<?php

use App\Models\CoverLetter;
use App\Models\JobListing;
use Illuminate\Support\Facades\Broadcast;

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

Broadcast::channel('test-job', function () {
    return true;
});


Broadcast::channel('job-listings.{jobListingId}.cover-letter', function ($user, $jobListingId) {
    // return (int) $user->id === JobListing::find($jobListingId)->user_id;
    return true;
});

Broadcast::channel('job-listings.{jobListingId}.preparation-questions', function ($user, $jobListingId) {
    return (int) $user->id === JobListing::find($jobListingId)->user_id;
    // return true;
});

Broadcast::channel('job-listings.{jobListingId}.summarize-listing', function ($user, $jobListingId) {
    return (int) $user->id === JobListing::find($jobListingId)->user_id;
});
