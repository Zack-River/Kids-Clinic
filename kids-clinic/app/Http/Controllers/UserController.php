<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $query = User::with('role');
        
        if (auth()->user()->role->name === 'Mod') {
            $query->whereHas('role', function($q) {
                $q->where('name', '!=', 'Admin');
            });
        }

        $users = $query->get();
        return view('users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $roles = Role::query();
        if (auth()->user()->role->name === 'Mod') {
            $roles->whereIn('name', ['Doctor', 'Receptionist']);
        }
        $roles = $roles->get();
        return view('users.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'username' => ['required', 'string', 'max:50', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'role_id' => ['required', 'exists:roles,id'],
        ]);

        if (auth()->user()->role->name === 'Mod') {
            $assignedRole = Role::find($validated['role_id']);
            if (in_array($assignedRole->name, ['Admin', 'Mod'])) {
                abort(403, 'You cannot create users with Admin or Mod privileges.');
            }
        }

        $validated['password'] = Hash::make($validated['password']);
        $validated['is_active'] = true;

        User::create($validated);

        return redirect()->route('users.index')->with('success', 'تم إضافة المستخدم بنجاح.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        if (auth()->user()->role->name === 'Mod' && $user->role->name === 'Admin') {
            abort(403, 'Unauthorized to edit Admin users.');
        }

        $roles = Role::query();
        if (auth()->user()->role->name === 'Mod') {
            $roles->whereIn('name', ['Doctor', 'Receptionist']);
        }
        $roles = $roles->get();
        return view('users.edit', compact('user', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        if (auth()->user()->role->name === 'Mod' && $user->role->name === 'Admin') {
            abort(403, 'Unauthorized to edit Admin users.');
        }

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'username' => ['required', 'string', 'max:50', Rule::unique('users')->ignore($user->id)],
            'role_id' => ['required', 'exists:roles,id'],
            'is_active' => ['boolean'],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
        ]);

        if (auth()->user()->role->name === 'Mod') {
            $assignedRole = Role::find($validated['role_id']);
            if (in_array($assignedRole->name, ['Admin', 'Mod'])) {
                abort(403, 'You cannot assign Admin or Mod privileges.');
            }
        }

        if (!empty($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        $validated['is_active'] = $request->has('is_active');

        $user->update($validated);

        return redirect()->route('users.index')->with('success', 'تم تحديث بيانات المستخدم بنجاح.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        if (auth()->id() === $user->id) {
            return redirect()->route('users.index')->with('error', 'لا يمكنك حذف حسابك الشخصي!');
        }

        if (auth()->user()->role->name === 'Mod' && in_array($user->role->name, ['Admin', 'Mod'])) {
            abort(403, 'Mods cannot delete Admins or other Mods.');
        }

        $user->delete();
        return redirect()->route('users.index')->with('success', 'تم حذف المستخدم بنجاح.');
    }
}
