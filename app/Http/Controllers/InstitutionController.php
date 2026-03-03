<?php

namespace App\Http\Controllers;

use App\Models\Institution;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class InstitutionController extends Controller
{
    // Public - Show all institutions
    public function index()
    {
        $institutions = Institution::all();
        return view('institutions.index', compact('institutions'));
    }

    // Public - Show institution detail with related cards
    public function show(Institution $institution)
    {
        $cards = $institution->cards()->orderBy('order')->get();
        return view('institutions.show', compact('institution', 'cards'));
    }

    // Admin - List all institutions
    public function adminIndex()
    {
        $institutions = Institution::all();
        return view('institutions.admin-index', compact('institutions'));
    }

    // Admin - Show create form
    public function create()
    {
        return view('institutions.create');
    }

    // Admin - Store institution
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'link' => 'required|url',
            'croppedImage' => 'nullable|string',
        ]);

        // Handle cropped image
        if ($request->has('croppedImage') && !empty($validated['croppedImage'])) {
            $imagePath = $this->saveCroppedImage($validated['croppedImage']);
            $validated['image'] = $imagePath;
            unset($validated['croppedImage']);
        } else {
            unset($validated['croppedImage']);
        }

        Institution::create($validated);

        return redirect()->route('admin.institutions.index')
            ->with('success', 'Institusi berhasil ditambahkan');
    }

    // Admin - Show edit form
    public function edit(Institution $institution)
    {
        return view('institutions.edit', compact('institution'));
    }

    // Admin - Update institution
    public function update(Request $request, Institution $institution)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'link' => 'required|url',
            'croppedImage' => 'nullable|string',
        ]);

        // Handle cropped image
        if ($request->has('croppedImage') && !empty($validated['croppedImage'])) {
            // Delete old image if exists
            if ($institution->image && Storage::disk('public')->exists($institution->image)) {
                Storage::disk('public')->delete($institution->image);
            }
            
            $imagePath = $this->saveCroppedImage($validated['croppedImage']);
            $validated['image'] = $imagePath;
            unset($validated['croppedImage']);
        } else {
            unset($validated['croppedImage']);
        }

        $institution->update($validated);

        return redirect()->route('admin.institutions.index')
            ->with('success', 'Institusi berhasil diperbarui');
    }

    // Admin - Delete institution
    public function destroy(Institution $institution)
    {
        // Delete image if exists
        if ($institution->image && Storage::disk('public')->exists($institution->image)) {
            Storage::disk('public')->delete($institution->image);
        }
        
        $institution->delete();

        return redirect()->route('admin.institutions.index')
            ->with('success', 'Institusi berhasil dihapus');
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
        Storage::disk('public')->put('institutions/' . $filename, $imageData);

        return 'institutions/' . $filename;
    }
}
