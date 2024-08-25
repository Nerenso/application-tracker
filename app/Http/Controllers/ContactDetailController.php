<?php

namespace App\Http\Controllers;

use App\Models\ContactDetail;
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
        return Inertia::render('ContactDetail/Index', [
            'contactDetail' => ContactDetail::with('user')->find(auth()->user()->id),
            // 'contactDetail' => (object) ["first_name" => "John", "last_name" => 'Doe']
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


        $validated = $request->validate([
            "first_name" => 'required|string',
            "last_name" => 'required|string',
            "email" => 'required|email',
            'phone' => 'string|nullable',
            "city" => 'required|string',
            'state' => 'string|nullable',
            "portfolio_link" => 'url|nullable'
        ]);

        $validated["user_id"] = auth()->user()->id;

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

        $validated = $request->validate([
            "first_name" => 'required|string',
            "last_name" => 'required|string',
            "email" => 'required|email',
            'phone' => 'string|nullable',
            "city" => 'required|string',
            'state' => 'string|nullable',
            "portfolio_link" => 'url'
        ]);

        $contactDetail->update($validated);

        $contactDetail->save();

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
