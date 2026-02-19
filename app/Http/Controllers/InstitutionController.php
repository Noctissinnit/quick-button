<?php

namespace App\Http\Controllers;

use App\Models\Institution;
use Illuminate\Http\Request;

class InstitutionController extends Controller
{
    // Public - Show all institutions
    public function index()
    {
        $institutions = Institution::all();
        return view('institutions.index', compact('institutions'));
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
        ]);

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
        ]);

        $institution->update($validated);

        return redirect()->route('admin.institutions.index')
            ->with('success', 'Institusi berhasil diperbarui');
    }

    // Admin - Delete institution
    public function destroy(Institution $institution)
    {
        $institution->delete();

        return redirect()->route('admin.institutions.index')
            ->with('success', 'Institusi berhasil dihapus');
    }
}
