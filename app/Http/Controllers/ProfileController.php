<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\Finance\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Redirect;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     *
     * @return \Illuminate\View\View
     */

    public function getMerpBlc()
    {
        $projects = Project::whereNotNull('merp_id')->get();
        foreach ($projects as $project) {
            $response = Http::get('https://merp-v2.makbrc.org/unit/ledger/' . $project->merp_id);
            if ($response->successful()) {
                $data = $response->json(); // Decode the JSON response to an array
                $merpBalance = $data['balance'];
            } else {
                // Handle errors, if the request fails
                $merpBalance = 0;
            }
            $project->merp_amount = $merpBalance;
            $project->update();
        }

    }
    public function edit(Request $request)
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(ProfileUpdateRequest $request)
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request)
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current-password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
