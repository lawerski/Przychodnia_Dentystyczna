<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use OTPHP\TOTP;
class AdminPanelController extends Controller
{
    public function index()
    {
        return view('admin.dashboard');
    }

    public function editProfile()
    {
        $user = Auth::user();
        return view('admin.profile', compact('user'));
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();
        $validated = $request->validate([
            'username' => 'required|string|max:255|unique:users,username,' . $user->id,
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:255',
            'password' => 'nullable|string|min:4|confirmed',
        ]);
        if (!empty($validated['password'])) {
            $validated['password'] = bcrypt($validated['password']);
        } else {
            unset($validated['password']);
        }
        $user->update($validated);

        return back()->with('success', 'Dane zostały zaktualizowane.');
    }
    public function generateTotpSecret()
    {
        $user = Auth::user();

        if (!$user->totp_secret) {
            $totp = TOTP::create();
            $user->totp_secret = $totp->getSecret();
            $user->save();
        }
        $totp = TOTP::create($user->totp_secret);

        $label = $user->email ?: $user->username;
        if (!$label) {
            $label = 'user-' . $user->id;
        }
        $totp->setLabel($label);
        $totp->setIssuer(config('app.name', 'Przychodnia Dentystyczna'));

        $provisioningUri = $totp->getProvisioningUri();
        $qrTemplate = 'https://api.qrserver.com/v1/create-qr-code/?size=200x200&data=%s';
        $qrCodeUri = sprintf($qrTemplate, urlencode($provisioningUri));

        return view('auth.totp', [
            'qrCodeUri' => $qrCodeUri,
            'secret' => $user->totp_secret,
        ]);
    }
}
