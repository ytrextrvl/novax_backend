<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UsersController extends Controller
{
    public function index()
    {
        return response()->json([
            'users' => User::query()->with('roles')->orderBy('id')->limit(500)->get()
        ]);
    }

    public function create(Request $request)
    {
        $data = $request->validate([
            'name' => ['required','string','max:255'],
            'email' => ['required','email','max:255','unique:users,email'],
            'password' => ['nullable','string','min:8'],
            'roles' => ['nullable','array'],
        ]);

        $user = User::create([
            'name' => $data['name'],
            'email' => strtolower($data['email']),
            'password' => Hash::make($data['password'] ?? str()->random(24)),
        ]);

        if (!empty($data['roles'])) {
            $user->syncRoles($data['roles']);
        }

        activity()->causedBy(auth('api')->user())->performedOn($user)->log('admin.user_create');

        return response()->json(['user' => $user], 201);
    }
}
