<?php

namespace App\Http\Controllers;

use App\Models\ContactDetail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Inertia\Inertia;

class ContactDetailController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $contactDetail = ContactDetail::with('user')->where('user_id', auth()->user()->id)->first();

        return Inertia::render('ContactDetail/Index', [
            'contactDetail' => $contactDetail,
        ]);
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
    public function store(Request $request)
    {
        $user = User::find(auth()->user()->id);

        $validated = $request->validate([
            "first_name" => 'required|string',
            "last_name" => 'required|string',
            "email" => 'required|email',
            'phone' => 'string|nullable',
            "city" => 'required|string',
            'state' => 'string|nullable',
            "portfolio_link" => 'url|nullable'
        ]);

        $validated["user_id"] = $user->id;

        $user->update([
            'name' => $validated['first_name'],
        ]);

        ContactDetail::create($validated);

        return redirect()->back()->with(['success' => "Contact Details Saved!"]);
    }

    /**
     * Display the specified resource.
     */
    public function show(ContactDetail $contactDetail)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ContactDetail $contactDetail)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ContactDetail $contactDetail)
    {
        Gate::authorize('update', $contactDetail);

        $user = User::find(auth()->user()->id);

        $validated = $request->validate([
            "first_name" => 'required|string',
            "last_name" => 'required|string',
            "email" => 'required|email',
            'phone' => 'string|nullable',
            "city" => 'required|string',
            'state' => 'string|nullable',
            "portfolio_link" => 'url|nullable'
        ]);

        $contactDetail->update($validated);

        $contactDetail->save();

        $user->update([
            'name' => $validated['first_name'],
        ]);

        return redirect()->back()->with(['success' => "Contact Details Updated!"]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ContactDetail $contactDetail)
    {
        //
    }
}
