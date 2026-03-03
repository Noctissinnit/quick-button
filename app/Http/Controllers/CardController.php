<?php

namespace App\Http\Controllers;

use App\Models\Card;
use App\Models\Institution;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Jika user admin, tampilkan cards management
        if (session('admin_logged_in')) {
            $cards = Card::orderBy('order')->get();
            return view('cards.index', compact('cards'));
        }
        
        // Jika public user, redirect ke institutions page
        return redirect()->route('institutions.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $institutions = Institution::all();
        return view('cards.create', compact('institutions'));
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
            'croppedImage' => 'nullable|string',
            'url' => 'required|url',
            'order' => 'nullable|integer',
            'category' => 'required|in:internal,external',
            'institution_id' => 'nullable|exists:institutions,id',
        ]);

        // Handle cropped image
        if ($request->has('croppedImage') && !empty($validated['croppedImage'])) {
            $imagePath = $this->saveCroppedImage($validated['croppedImage']);
            $validated['image'] = $imagePath;
            unset($validated['croppedImage']);
        } else {
            unset($validated['croppedImage']);
        }

        Card::create($validated);
        return redirect()->route('admin.cards')->with('success', 'Card berhasil ditambahkan');
    }

    /**
     * Save cropped image from base64
     */
    private function saveCroppedImage($base64Image)
    {
        // Remove data:image/png;base64, prefix if exists
        if (strpos($base64Image, 'data:image') === 0) {
            $base64Image = substr($base64Image, strpos($base64Image, ',') + 1);
        }

        // Decode base64
        $imageData = base64_decode($base64Image);

        // Generate filename
        $filename = uniqid() . '.png';

        // Save to storage
        Storage::disk('public')->put('cards/' . $filename, $imageData);

        return 'cards/' . $filename;
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
        $institutions = Institution::all();
        return view('cards.edit', compact('card', 'institutions'));
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
            'croppedImage' => 'nullable|string',
            'url' => 'required|url',
            'order' => 'nullable|integer',
            'category' => 'required|in:internal,external',
            'institution_id' => 'nullable|exists:institutions,id',
        ]);

        // Handle cropped image
        if ($request->has('croppedImage') && !empty($validated['croppedImage'])) {
            // Delete old image if exists
            if ($card->image && Storage::disk('public')->exists($card->image)) {
                Storage::disk('public')->delete($card->image);
            }
            
            $imagePath = $this->saveCroppedImage($validated['croppedImage']);
            $validated['image'] = $imagePath;
            unset($validated['croppedImage']);
        } else {
            unset($validated['croppedImage']);
        }

        $card->update($validated);
        return redirect()->route('admin.cards')->with('success', 'Card berhasil diperbarui');
    }

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
