<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use App\Models\DiaryEntry;
use App\Models\Emotion;
use App\Models\Category;
use App\Models\Tag;

class DiaryEntryController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function index()
    {
        $diaryEntries = Auth::user()->diaryEntries()
        ->with('emotions', 'categories', 'tags')
        ->orderBy('date', 'desc')
        ->get();
        return view('diary.index', compact('diaryEntries'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $emotions = Emotion::all(); // Fetch all emotions for selection
        $categories = Category::all(); // Fetch all categories for selection
        $tags = Tag::all(); // Fetch all tags for selection
        return view('diary.create', compact('emotions', 'categories', 'tags')); // Pass emotions and categories to the view
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'date' => ['required', 'date'],
            'content' => ['required', 'string'],

            'tags' => ['nullable', 'array'],
            'tags.*' => ['integer', 'exists:tags,id'],

            'categories' => ['nullable', 'array'],
            'categories.*' => ['integer', 'exists:categories,id'],

            'emotions' => ['nullable', 'array'],
            'emotions.*' => ['integer', 'exists:emotions,id'],

            // intensity is keyed by emotion id: intensity[3]=5
            'intensity' => ['nullable', 'array'],
        ]);

        // Only create with diary_entries columns
        $diaryEntry = Auth::user()->diaryEntries()->create([
            'date' => $validated['date'],
            'content' => $validated['content'],
        ]);

        // Tags (polymorphic many-to-many)
        $diaryEntry->tags()->sync($validated['tags'] ?? []);

        // Categories (many-to-many)
        $diaryEntry->categories()->sync($validated['categories'] ?? []);

        // Emotions with pivot intensity (many-to-many with extra column)
        $emotionSyncData = [];
        foreach (($validated['emotions'] ?? []) as $emotionId) {
            $emotionSyncData[$emotionId] = [
                'intensity' => $validated['intensity'][$emotionId] ?? null,
            ];
        }
        $diaryEntry->emotions()->sync($emotionSyncData);

        return redirect()
            ->route('diary.index')
            ->with('status', 'Diary entry added successfully!');
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $diaryEntry = Auth::user()
            ->diaryEntries()
            ->with('emotions', 'categories', 'tags') // eager load related emotions, categories, and tags
            ->findOrFail($id);

        return view('diary.show', compact('diaryEntry'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $diaryEntry = Auth::user()->diaryEntries()->with('emotions', 'categories', 'tags')->findOrFail($id);
        $emotions = Emotion::all(); // Fetch all emotions for selection (you must have a model called 'Emotion' to fetch all emotions)
        $categories = Category::all(); // Fetch all categories for selection
        $tags = Tag::all(); // Fetch all tags for selection
        return view('diary.edit', compact('diaryEntry', 'emotions', 'categories', 'tags'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $diaryEntry = Auth::user()->diaryEntries()->findOrFail($id);

        $validated = $request->validate([
            'date' => ['required', 'date'],
            'content' => ['required', 'string'],

            'tags' => ['nullable', 'array'],
            'tags.*' => ['integer', 'exists:tags,id'],

            'categories' => ['nullable', 'array'],
            'categories.*' => ['integer', 'exists:categories,id'],

            'emotions' => ['nullable', 'array'],
            'emotions.*' => ['integer', 'exists:emotions,id'],

            // intensity is keyed by emotion id: intensity[3]=5
            'intensity' => ['nullable', 'array'],
        ]);

        // Update diary entry columns
        $diaryEntry->update([
            'date' => $validated['date'],
            'content' => $validated['content'],
        ]);

        // Sync tags (polymorphic many-to-many)
        $diaryEntry->tags()->sync($validated['tags'] ?? []);

        // Sync categories (many-to-many)
        $diaryEntry->categories()->sync($validated['categories'] ?? []);

        // Sync emotions with pivot intensity (many-to-many with extra column)
        $emotionSyncData = [];
        foreach (($validated['emotions'] ?? []) as $emotionId) {
            $emotionSyncData[$emotionId] = [
                'intensity' => $validated['intensity'][$emotionId] ?? null,
            ];
        }
        $diaryEntry->emotions()->sync($emotionSyncData);

        return redirect()
            ->route('diary.index')
            ->with('status', 'Diary entry updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): RedirectResponse
    {
        $diaryEntry = Auth::user()->diaryEntries()->findOrFail($id);
        $diaryEntry->delete();

        return redirect()->route('diary.index')->with('status', 'Diary entry deleted successfully!');
    }
}