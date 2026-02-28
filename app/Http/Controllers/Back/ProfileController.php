<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    /**
     * Display the user's profile details.
     */
    public function show(Request $request)
    {
        return view('back.pages.profile.show', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Display the user's profile form.
     */
    public function edit(Request $request)
    {
        return view('back.pages.profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(Request $request)
    {
        $user = $request->user();

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
        ]);

        $user->name = $validated['name'];
        $user->email = $validated['email'];

        if (!empty($validated['password'])) {
            $user->password = Hash::make($validated['password']);
        }

        if ($request->filled('cropped_photo')) {
            try {
                $base64Image = $request->input('cropped_photo');
                $imageParts = explode(';base64,', $base64Image);
                if (count($imageParts) === 2) {
                    $imageTypeAux = explode('image/', $imageParts[0]);
                    $imageType = isset($imageTypeAux[1]) ? $imageTypeAux[1] : 'jpg';
                    $imageBase64 = base64_decode($imageParts[1]);
                    $fileName = 'avatars/' . uniqid() . '.' . $imageType;

                    if ($user->photo && \Illuminate\Support\Facades\Storage::disk('public')->exists($user->photo)) {
                        \Illuminate\Support\Facades\Storage::disk('public')->delete($user->photo);
                    }

                    \Illuminate\Support\Facades\Storage::disk('public')->put($fileName, $imageBase64);
                    $user->photo = $fileName;
                }
            } catch (\Exception $e) {
                // Ignore silent failure for photo upload, or log it
                \Illuminate\Support\Facades\Log::error('Photo upload error: ' . $e->getMessage());
            }
        }

        $user->save();

        return back()->with('success', 'Profile updated successfully.');
    }
}
