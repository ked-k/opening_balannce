<?php
namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\Finance\FmsTransaction;
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
    public function fetchTransactions($id)
    {
        try {
            // Fetch project with ledger relationship

            // Check if ledger exists
            if (! $id) {
                return response()->json([
                    'success'      => false,
                    'message'      => 'No ledger found for this project.',
                    'transactions' => [],
                ], 404);
            }

            // Get transactions and filter specific fields
            $transactions = FmsTransaction::where('project_id', $id)->get()->map(function ($trx) {
                return [
                    'id'           => $trx->id,
                    'trx_no'       => $trx->trx_no,
                    'trx_ref'      => $trx->trx_ref,
                    'trx_date'     => $trx->trx_date,
                    'total_amount' => $trx->total_amount,
                    'amount_local' => $trx->amount_local,
                    'deductions'   => $trx->deductions,
                    'rate'         => $trx->rate,
                    'project_id'   => $trx->project_id,
                    'currency_id'  => $trx->currency_id,
                    'trx_type'     => $trx->trx_type,
                    'status'       => 'Paid',
                    'description'  => $trx->description . ' For ' . ($trx->client ?? ''),
                    'entry_type'   => 'OP',
                ];
            });

            return response()->json([
                'success'      => true,
                'transactions' => $transactions,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while fetching transactions.',
                'error'   => $e->getMessage(),
            ], 500);
        }
    }
    public function getMerpBlc()
    {
        $projects = Project::whereNotNull('merp_id')->get();
        foreach ($projects as $project) {
            $response = Http::get('https://merp.makbrc.org/unit/ledger/' . $project->merp_id);
            if ($response->successful()) {
                $data        = $response->json(); // Decode the JSON response to an array
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
