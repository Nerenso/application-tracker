<?php

namespace App\Http\Controllers;

use App\Models\JobListing;
use App\Models\TimelineActivity;
use App\Services\Timeline\TimelineActivityService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class TimelineActivityController extends Controller
{

    private $timelineActivityService;

    public function __construct()
    {
        $this->timelineActivityService = new TimelineActivityService();
    }


    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, JobListing $jobListing)
    {
        Gate::authorize('view', $jobListing);

        $validated = $this->validateFormFields($request);

        $validated['user_id'] = auth()->user()->id;
        $validated['job_listing_id'] = $jobListing->id;
        $validated['activity_type'] = 'note_added';
        $validated['activity_date'] = $this->createActivityDateTimeStamp($validated['activity_date']);

        $this->timelineActivityService->createTimelineActivity($jobListing, $validated);

        return redirect()->back()->with(['success' => "Activity Successfully Added!"]);
    }

    /**
     * Display the specified resource.
     */
    public function show(TimelineActivity $timelineActivity)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TimelineActivity $timelineActivity)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, JobListing $job_listing, TimelineActivity $activity)
    {
        Gate::authorize('view', $job_listing);

        $validated = $this->validateFormFields($request);
        $validated['activity_date'] = $this->createActivityDateTimeStamp($validated['activity_date']);

        $activity->update($validated);

        return redirect()->back()->with(['success' => "Activity Successfully Updated!"]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(JobListing $job_listing, TimelineActivity $activity)
    {
        Gate::authorize('view', $job_listing);

        $activity->delete();

        return redirect()->back()->with(['success' => "Activity Successfully Deleted!"]);
    }

    private function validateFormFields(Request $request)
    {
        return $request->validate([
            'title' => 'required',
            'description' => 'required',
            'activity_date' => 'required',
        ]);
    }

    private function createActivityDateTimeStamp(string $date)
    {
        $now = now()->setTimezone('Europe/Amsterdam');

        return Carbon::parse($date)->isToday() ? $now : Carbon::parse($date)->setHours($now->hour)->setMinutes($now->minute)->setSeconds($now->second);
    }
}
