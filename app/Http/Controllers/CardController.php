<?php

namespace App\Http\Controllers;

use App\Models\Card;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $cards = Card::orderBy('order')->get();
        return view('cards.index', compact('cards'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('cards.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'icon' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'url' => 'required|url',
            'order' => 'nullable|integer',
            'category' => 'required|in:internal,external',
        ]);

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('cards', 'public');
            $validated['image'] = $imagePath;
        }

        Card::create($validated);
        return redirect()->route('admin.cards')->with('success', 'Card berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Card $card)
    {
        return view('cards.edit', compact('card'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Card $card)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'icon' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'url' => 'required|url',
            'order' => 'nullable|integer',
            'category' => 'required|in:internal,external',
        ]);

        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($card->image && Storage::disk('public')->exists($card->image)) {
                Storage::disk('public')->delete($card->image);
            }
            $imagePath = $request->file('image')->store('cards', 'public');
            $validated['image'] = $imagePath;
        }

        $card->update($validated);
        return redirect()->route('admin.cards')->with('success', 'Card berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Card $card)
    {
        // Delete image if exists
        if ($card->image && Storage::disk('public')->exists($card->image)) {
            Storage::disk('public')->delete($card->image);
        }
        $card->delete();
        return redirect()->route('admin.cards')->with('success', 'Card berhasil dihapus');
    }
}
