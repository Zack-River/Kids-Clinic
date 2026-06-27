<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    /**
     * Show the form for editing the profile.
     */
    public function edit()
    {
        $user = Auth::user();
        return view('profile.edit', compact('user'));
    }

    /**
     * Update the user's profile information.
     */
    public function update(Request $request)
    {
        $user = Auth::user();

        $rules = [
            'cropped_avatar' => ['nullable', 'string'],
            'current_password' => ['nullable', 'required_with:new_password', 'current_password'],
            'new_password' => ['nullable', 'string', 'min:8', 'confirmed'],
        ];

        if (in_array($user->role->name, ['Admin', 'Mod'])) {
            $rules['name'] = ['required', 'string', 'max:100'];
            $rules['username'] = ['required', 'string', 'max:50', Rule::unique('users')->ignore($user->id)];
        }

        $validated = $request->validate($rules);

        if (in_array($user->role->name, ['Admin', 'Mod'])) {
            $user->name = $validated['name'];
            $user->username = $validated['username'];
        }

        if ($request->filled('cropped_avatar')) {
            $base64Image = $request->input('cropped_avatar');
            if (preg_match('/^data:image\/(\w+);base64,/', $base64Image, $type)) {
                $base64Image = substr($base64Image, strpos($base64Image, ',') + 1);
                $type = strtolower($type[1]);
                
                if (in_array($type, ['jpg', 'jpeg', 'png', 'gif', 'webp'])) {
                    $imageData = base64_decode($base64Image);
                    if ($imageData !== false) {
                        if ($user->avatar) {
                            \Illuminate\Support\Facades\Storage::disk('public')->delete($user->avatar);
                        }
                        $fileName = 'avatars/' . uniqid() . '.' . $type;
                        \Illuminate\Support\Facades\Storage::disk('public')->put($fileName, $imageData);
                        $user->avatar = $fileName;
                    }
                }
            }
        }

        if (!empty($validated['new_password'])) {
            $user->password = Hash::make($validated['new_password']);
        }

        $user->save();

        return redirect()->route('profile.edit')->with('success', 'تم تحديث الملف الشخصي بنجاح.');
    }
}
