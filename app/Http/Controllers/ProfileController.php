<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit-profile', [
            'title' => 'Edit Profile',
            'user' => $request->user(),
            'currentPage' => 'Edit Profile',
            'breadcrumbs' => [
                ['name' => 'Profile', 'route' => route('profile.edit')],
            ],
        ]);
    }

    public function editPassword(Request $request): View
    {
        return view('profile.edit-profile', [
            'title' => 'Edit Profile',
            'user' => $request->user(),
            'currentPage' => 'Ganti Password',
            'breadcrumbs' => [
                ['name' => 'Profile', 'route' => route('profile.edit')],
            ],
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        $request->user()->save();

        if ($request->header('Referer') && strpos($request->header('Referer'), 'frontend') !== false) {
            return redirect()->back()->with('success', 'Profile berhasil diperbarui.');
        }

        return Redirect::route('profile.edit')->with('success', 'Profile berhasil diperbarui.');
    }

    public function updatePassword(Request $request): RedirectResponse
    {
        $validated = $request->validateWithBag('passwordUpdate', [
            'current_password' => ['required', 'current_password'],
            'newPassword' => ['required', 'string', 'min:8', 'confirmed'],
            'newPassword_confirmation' => ['required'],
        ]);

        $request->user()->update([
            'password' => bcrypt($validated['newPassword']),
        ]);

        if ($request->header('Referer') && strpos($request->header('Referer'), 'frontend') !== false) {
            return redirect()->back()->with('success', 'Password berhasil diubah.');
        }

        return Redirect::route('profile.password')->with('success', 'Password berhasil diubah.');
    }

    /**
     * Delete the user's account.
     */
    // public function destroy(Request $request): RedirectResponse
    // {
    //     $request->validateWithBag('userDeletion', [
    //         'password' => ['required', 'current_password'],
    //     ]);

    //     $user = $request->user();

    //     Auth::logout();

    //     $user->delete();

    //     $request->session()->invalidate();
    //     $request->session()->regenerateToken();

    //     return Redirect::to('/');
    // }
}
