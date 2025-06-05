<?php

namespace App\Http\Controllers;

use App\Models\Nas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class NasController extends Controller
{
    /**
     * Display a listing of the NAS resources.
     */
    public function index()
    {
        $nas = Nas::all();
        return view('radius.nas', compact('nas'));
    }

    /**
     * Show the form for creating a new NAS resource.
     */
    public function create()
    {
        return view('radius.nas-create');
    }

    /**
     * Store a newly created NAS resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nasname' => 'required|string|max:255',
            'shortname' => 'nullable|string|max:32',
            'type' => 'required|string|max:30',
            'ports' => 'nullable|integer',
            'secret' => 'required|string|max:60',
            'server' => 'nullable|string|max:64',
            'community' => 'nullable|string|max:50',
            'description' => 'nullable|string|max:200',
        ]);

        Nas::create($validated);

        return redirect()->route('nas.index')->with('success', 'NAS berhasil ditambahkan.');
    }

    /**
     * Display the specified NAS resource.
     */
    public function show(Nas $na)
    {
        return view('nas.show', compact('na'));
    }

    /**
     * Show the form for editing the specified NAS resource.
     */
    public function edit(Nas $na)
    {
        return view('nas.edit', compact('na'));
    }

    /**
     * Update the specified NAS resource in storage.
     */
    public function update(Request $request, Nas $na)
    {
        $validated = $request->validate([
            'nasname' => 'required|string|max:255',
            'shortname' => 'nullable|string|max:32',
            'type' => 'required|string|max:30',
            'ports' => 'nullable|integer',
            'secret' => 'required|string|max:60',
            'server' => 'nullable|string|max:64',
            'community' => 'nullable|string|max:50',
            'description' => 'nullable|string|max:200',
        ]);

        $na->update($validated);

        return redirect()->route('nas.index')->with('success', 'NAS berhasil diperbarui.');
    }

    /**
     * Remove the specified NAS resource from storage.
     */
    public function destroy(Nas $na)
    {
        try {
            DB::beginTransaction();
            
            $na->delete();
            
            DB::commit();
            
            if (request()->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'NAS berhasil dihapus.'
                ]);
            }
            
            return redirect()->route('nas.index')->with('success', 'NAS berhasil dihapus.');
        } catch (\Exception $e) {
            DB::rollBack();
            
            if (request()->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal menghapus NAS: ' . $e->getMessage()
                ], 500);
            }
            
            return redirect()->route('nas.index')->with('error', 'Gagal menghapus NAS: ' . $e->getMessage());
        }
    }
}

