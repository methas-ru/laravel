<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reminder;
use App\Models\Tag;
use Illuminate\Support\Facades\Auth;

class ReminderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $reminders = Auth::user()
            ->reminders()
            ->with('tags')
            ->latest()
            ->get();

        $tags = Tag::all();

        return view('reminders.index', compact('reminders', 'tags'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $tags = Tag::all();
        return view('reminders.create', compact('tags'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'due_date' => 'required|date',
            'status' => 'required|in:pending,in_progress,done',
            'tags' => 'array'
        ]);

        // สร้าง reminder
        $reminder = Auth::user()->reminders()->create($validated);

        // ผูก tags
        if ($request->tags) {
            $reminder->tags()->sync($request->tags);
        }

        return redirect()->route('reminders.index')
            ->with('success', 'Reminder created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $reminder = Reminder::with('tags')->findOrFail($id);
        return view('reminders.show', compact('reminder'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $reminder = Reminder::with('tags')->findOrFail($id);
        $tags = Tag::all();

        return view('reminders.edit', compact('reminder', 'tags'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $reminder = Reminder::findOrFail($id);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'due_date' => 'required|date',
            'status' => 'required|in:pending,in_progress,done',
            'tags' => 'array'
        ]);

        $reminder->update($validated);

        // sync tags
        $reminder->tags()->sync($request->tags ?? []);

        return redirect()->route('reminders.index')
            ->with('success', 'Reminder updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $reminder = Reminder::findOrFail($id);
        $reminder->delete();

        return back()->with('success', 'Reminder deleted');
    }
}
