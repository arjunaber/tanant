<?php
// app/Http/Controllers/ProfileController.php
namespace App\Http\Controllers;

use App\Models\Profile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    // Show profile
    public function show()
    {
        $user = Auth::user();
        $profile = Profile::where('user_id', $user->id)->first();

        return view('profile.show', compact('user', 'profile'));
    }

    // Edit profile form
    public function edit()
    {
        $user = Auth::user();
        $profile = Profile::where('user_id', $user->id)->first();

        return view('profile.edit', compact('user', 'profile'));
    }

    // Update profile - CARA ALTERNATIF YANG LEBIH AMAN
    public function update(Request $request)
    {
        $user = Auth::user();

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:15',
            'address' => 'required|string',
            'identity_number' => 'required|string|max:20',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Update user
        $user->update([
            'name' => $request->name,
        ]);

        // Update or create profile
        Profile::updateOrCreate(
            ['user_id' => $user->id],
            [
                'phone' => $request->phone,
                'address' => $request->address,
                'identity_number' => $request->identity_number,
            ]
        );

        return redirect()->route('profile.show')
            ->with('success', 'Profile berhasil diperbarui.');
    }
}