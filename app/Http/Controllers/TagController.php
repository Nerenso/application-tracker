<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use Illuminate\Contracts\Database\Query\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;
use Inertia\Inertia;

class TagController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        return Inertia::render('Tag/Index', [
            "tags" => Tag::query()->where("user_id", auth()->user()->id)->orderBy('title', 'asc')->get()
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
            // "title" => "required|string",
            "title" => Rule::unique('tags', 'title')->where(fn (Builder $query) => $query->where('user_id', auth()->user()->id)),
            "color" => "required|string"
        ]);

        $tag = [
            "user_id" => auth()->user()->id,
            "title" => $validated['title'],
            "color" => $validated['color']
        ];

        Tag::create($tag);

        return redirect()->back();
    }

    /**
     * Display the specified resource.
     */
    public function show(Tag $tag)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Tag $tag)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Tag $tag)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tag $tag)
    {
        Gate::authorize('delete', $tag);

        $tag->delete();

        return redirect()->back()->with(['success' => "Tag Successfully Deleted"]);
    }
}
