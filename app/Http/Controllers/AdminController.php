<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\ClassModel;
use App\Models\Schedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rules\Password;

class AdminController extends Controller
{
    public function dashboard()
    {
        $totalUsers = User::count();
        $totalStudents = User::where('role', 'student')->count();
        $totalProfessors = User::where('role', 'professor')->count();
        $totalClasses = ClassModel::count();
        $totalSchedules = Schedule::count();

        return view('admin.dashboard', compact(
            'totalUsers',
            'totalStudents',
            'totalProfessors',
            'totalClasses',
            'totalSchedules'
        ));
    }

    public function index()
    {
        $users = User::all();
        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        $classes = ClassModel::all();
        return view('admin.users.create', compact('classes'));
    }

    public function store(Request $request)
    {
        // Débogage 1 : Vérifier les données reçues
        Log::info('Données reçues pour la création d\'utilisateur:', $request->all());
        
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Password::defaults()],
            'role' => ['required', 'string', 'in:administrator,professor,student'],
            'class_id' => ['required_if:role,student', 'exists:classes,id'],
        ]);
        
        // Débogage 2 : Validation réussie
        Log::info('Validation réussie pour la création d\'utilisateur');
        
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'class_id' => $request->role === 'student' ? $request->class_id : null,
        ]);
        
        // Débogage 3 : Vérifier si l'utilisateur a été créé
        Log::info('Utilisateur créé avec ID:', ['id' => $user->id ?? 'non créé']);

        return redirect()->route('admin.users.index')
            ->with('success', 'Utilisateur créé avec succès.');
    }

    public function edit(User $user)
    {
        $classes = ClassModel::all();
        return view('admin.users.edit', compact('user', 'classes'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'role' => ['required', 'string', 'in:administrator,professor,student'],
            'class_id' => ['required_if:role,student', 'exists:classes,id'],
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
            'class_id' => $request->role === 'student' ? $request->class_id : null,
        ]);

        return redirect()->route('admin.users.index')
            ->with('success', 'Utilisateur mis à jour avec succès.');
    }

    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('admin.users.index')
            ->with('success', 'Utilisateur supprimé avec succès.');
    }

    public function resetPassword(Request $request, User $user)
    {
        $request->validate([
            'password' => ['required', 'confirmed', Password::defaults()],
        ]);

        $user->update([
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('admin.users.index')
            ->with('success', 'Mot de passe réinitialisé avec succès.');
    }
}
