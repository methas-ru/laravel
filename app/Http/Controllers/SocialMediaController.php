<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use App\Models\SocialMedia;

class SocialMediaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $socialMedia = Auth::user()->socialMedia()->get();
        return view('social.index', compact('socialMedia'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('social.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'platform' => 'required|string',
            'url' => 'required|string',
        ]);

        Auth::user()->socialMedia()->create($validated);

        return redirect()->route('social.index')->with('status', 'Social media added successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $socialMedia = Auth::user()->socialMedia()->findOrFail($id);
        return view('social.show', compact('socialMedia'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $socialMedia = Auth::user()->socialMedia()->findOrFail($id);
        return view('social.edit', compact('socialMedia'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Retrieve the diary entry by its ID
        $socialMedia = Auth::user()->socialMedia()->findOrFail($id);
        $validated = $request->validate([
            'platform' => 'required|string',
            'url' => 'required|string',
        ]);

        $socialMedia->update($validated);

        return redirect()->route('social.index')->with('status', 'Social Media updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): RedirectResponse
    {
        $socialMedia = SocialMedia::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail(); // Will throw a ModelNotFoundException if the entry doesn't exist or doesn't belong to the user

        $socialMedia->delete();

        return redirect()->route('social.index')->with('status', 'Social media deleted successfully!');
    }
}
