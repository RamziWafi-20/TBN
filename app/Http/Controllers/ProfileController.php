<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function index()
    {
        return view('app.profile', ['user' => Auth::user()]);
    }


    public function apiShow(Request $request)
    {
        return response()->json([
            'success' => true,
            'data' => $request->user(),
        ]);
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $data = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'nis' => ['nullable', 'string', 'max:30'],
            'class_name' => ['nullable', 'string', 'max:50'],
            'profile_photo' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ], [
            'name.required' => 'Nama wajib diisi.',
            'profile_photo.image' => 'File profil harus berupa gambar.',
            'profile_photo.mimes' => 'Format foto harus JPG, JPEG, PNG, atau WEBP.',
            'profile_photo.max' => 'Ukuran foto maksimal 2 MB.',
        ]);

        if ($request->hasFile('profile_photo')) {
            if ($user->profile_photo) {
                Storage::disk('public')->delete($user->profile_photo);
            }

            $data['profile_photo'] = $request->file('profile_photo')->store('profiles', 'public');
        }

        $user->update($data);

        return back()->with('success', 'Profil berhasil diperbarui.');
    }
}
