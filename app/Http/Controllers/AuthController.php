<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use PragmaRX\Google2FALaravel\Support\Google2FA;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $data = $request->validate([
            'name' => ['required','string','max:255'],
            'email' => ['required','email','max:255','unique:users,email'],
            'password' => ['required','string','min:8'],
        ]);

        $user = User::create([
            'name' => $data['name'],
            'email' => strtolower($data['email']),
            'password' => Hash::make($data['password']),
        ]);

        $user->assignRole('user');

        $token = JWTAuth::fromUser($user);

        return response()->json($this->tokenResponse($token, $user));
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required','email'],
            'password' => ['required','string'],
        ]);

        if (! $token = auth('api')->attempt($credentials)) {
            throw ValidationException::withMessages([
                'email' => ['Invalid credentials.'],
            ]);
        }

        /** @var User $user */
        $user = auth('api')->user();
        $user->forceFill(['last_login_at' => now()])->save();

        // If MFA enabled, require verify step
        if ($user->mfa_enabled) {
            // Return a short-lived token with an "mfa_required" flag.
            // Client should call /auth/mfa/verify with one-time code.
            return response()->json([
                'mfa_required' => true,
                'temp_token' => $token,
                'user' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'roles' => $user->getRoleNames(),
                ],
            ]);
        }

        return response()->json($this->tokenResponse($token, $user));
    }

    public function logout()
    {
        auth('api')->logout(true);
        return response()->json(['message' => 'Logged out.']);
    }

    public function refresh()
    {
        return response()->json($this->tokenResponse(auth('api')->refresh(true, true), auth('api')->user()));
    }

    public function me()
    {
        $user = auth('api')->user();
        return response()->json([
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'roles' => $user->getRoleNames(),
                'permissions' => $user->getAllPermissions()->pluck('name'),
            ]
        ]);
    }

    public function mfaEnable(Request $request)
    {
        $user = auth('api')->user();

        /** @var Google2FA $google2fa */
        $google2fa = app('pragmarx.google2fa');

        $secret = $google2fa->generateSecretKey();
        $user->forceFill([
            'mfa_secret' => $secret,
            'mfa_enabled' => false,
        ])->save();

        $inlineUrl = $google2fa->getQRCodeInline(
            config('app.name'),
            $user->email,
            $secret
        );

        return response()->json([
            'secret' => $secret,
            'qr' => $inlineUrl,
        ]);
    }

    public function mfaVerify(Request $request)
    {
        $data = $request->validate([
            'code' => ['required','string'],
            // If mfa_required login returned temp_token, send it as Authorization: Bearer <temp_token>
        ]);

        $user = auth('api')->user();

        /** @var Google2FA $google2fa */
        $google2fa = app('pragmarx.google2fa');

        $valid = $user->mfa_secret
            ? $google2fa->verifyKey($user->mfa_secret, $data['code'])
            : false;

        if (! $valid) {
            throw ValidationException::withMessages([
                'code' => ['Invalid MFA code.'],
            ]);
        }

        $user->forceFill(['mfa_enabled' => true])->save();

        // Keep the current token as valid login token
        $token = JWTAuth::getToken();
        return response()->json($this->tokenResponse((string)$token, $user));
    }

    private function tokenResponse(string $token, User $user)
    {
        return [
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth('api')->factory()->getTTL() * 60,
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'roles' => $user->getRoleNames(),
            ],
        ];
    }
}
