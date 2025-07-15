<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Inertia\Response;
use App\Services\ImageService;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): Response
    {
        return Inertia::render('Profile/Edit', [
            'mustVerifyEmail' => $request->user() instanceof MustVerifyEmail,
            'status' => session('status'),
        ]);
    }

    /**
     * Update only the user's main data (first_name, last_name, email).
     */
    public function updateUser(ProfileUpdateRequest $request): RedirectResponse
    {
        $user = $request->user();
        if ($user) {
            $user->fill($request->only([
                'first_name',
                'last_name',
                'email',
            ]));
            $user->save();
        }
        return Redirect::route('profile.edit');
    }

    /**
     * Update only the user's profile data (nickname, birthdate, academic_level, gender).
     */
    public function updateProfile(Request $request): RedirectResponse
    {
        $request->validate([
            'avatar' => [
                'nullable',
                'image',
                'mimes:jpg,png,jpeg,webp',
                'max:4096',
            ],
            'nickname' => ['nullable', 'string', 'max:255'],
            'birthdate' => ['nullable', 'date'],
            'academic_level' => ['nullable', 'integer'],
            'gender' => ['nullable', 'string', 'max:255'],
        ]);
        $user = $request->user();
        \Log::info('Datos recibidos en updateProfile', [
            'nickname' => $request->input('nickname'),
            'birthdate' => $request->input('birthdate'),
            'academic_level' => $request->input('academic_level'),
            'gender' => $request->input('gender'),
            'avatar' => $request->file('avatar'),
        ]);
        if ($user) {
            $profile = $user->profile()->firstOrNew([]);
            $profile->fill($request->only([
                'nickname',
                'birthdate',
                'academic_level',
                'gender',
            ]));

            if ($request->hasFile('avatar') && $request->file('avatar')->isValid()) {
                \Log::info('Archivo avatar recibido', [
                    'original_name' => $request->file('avatar')->getClientOriginalName(),
                    'size' => $request->file('avatar')->getSize(),
                ]);
                $imageUrl = $request->file('avatar')->store('profile_images', 'public');
                $profile->avatar = $imageUrl;
                \Log::info('Avatar guardado en disco y asignado al modelo', [
                    'imageUrl' => $imageUrl,
                ]);
            } else {
                \Log::info('No se recibió archivo avatar válido');
            }

            $profile->user()->associate($user);
            $profile->save();
            \Log::info('Perfil guardado', $profile->toArray());
        }
        return Redirect::route('profile.edit');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validate([
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
