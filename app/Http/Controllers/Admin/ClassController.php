<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ClassModel;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ClassController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $weekStart = Carbon::now()->startOfWeek();
        $weekEnd = Carbon::now()->endOfWeek();
        $classes = ClassModel::withCount(['students', 'schedules'])->latest()->get();
        
        return view('admin.classes.index', compact('classes', 'weekStart', 'weekEnd'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $weekStart = Carbon::now()->startOfWeek();
        $weekEnd = Carbon::now()->endOfWeek();
        return view('admin.classes.create', compact('weekStart', 'weekEnd'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:classes,name'
        ]);

        ClassModel::create($validated);

        return redirect()->route('admin.classes.index')
            ->with('success', 'Classe créée avec succès.');
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
    public function edit(string $id)
    {
        $weekStart = Carbon::now()->startOfWeek();
        $weekEnd = Carbon::now()->endOfWeek();
        $class = ClassModel::findOrFail($id);
        
        return view('admin.classes.edit', compact('class', 'weekStart', 'weekEnd'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $class = ClassModel::findOrFail($id);
        
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:classes,name,' . $id
        ]);

        $class->update($validated);

        return redirect()->route('admin.classes.index')
            ->with('success', 'Classe mise à jour avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $class = ClassModel::findOrFail($id);
        
        // Vérifier s'il y a des étudiants dans la classe
        if ($class->students()->count() > 0) {
            return redirect()->route('admin.classes.index')
                ->with('error', 'Impossible de supprimer une classe qui contient des étudiants.');
        }
        
        // Vérifier s'il y a des emplois du temps associés
        if ($class->schedules()->count() > 0) {
            return redirect()->route('admin.classes.index')
                ->with('error', 'Impossible de supprimer une classe qui a des emplois du temps associés.');
        }

        $class->delete();

        return redirect()->route('admin.classes.index')
            ->with('success', 'Classe supprimée avec succès.');
    }
}