<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class RegisterController extends Controller
{
    /**
     * Handle user registration API.
     */
    public function register(Request $request)
    {
        try {
            // Validate inputs
            $validator = Validator::make($request->all(), [
                'name'                  => 'required|string|max:255',
                'email'                 => 'required|string|email|max:255|unique:users,email',
                'password'              => 'required|string|min:8|confirmed',
                'phone'                 => 'nullable|string|max:20',
                'avatar'                => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            ]);

            if ($validator->fails()) {
                return $this->responseError($validator->errors()->first(), 422);
            }

            // Upload avatar if exists
            $avatarPath = null;
            if ($request->hasFile('avatar')) {
                $avatarPath = $request->file('avatar')->store('avatars', 'public');
            }

            // Create user
            $user = User::create([
                'name'      => $request->name,
                'email'     => $request->email,
                'password'  => Hash::make($request->password),
                'phone'     => $request->phone,
                'avatar'    => $avatarPath,
                'status'    => 'active',
                'role'      => 'customer',
            ]);

            // Issue Sanctum Token
            $token = $user->createToken('auth_token')->plainTextToken;

            return $this->responseSuccess([
                'user'  => $user,
                'token' => $token,
            ], __('message.register_success'));

        } catch (\Exception $e) {
            return $this->responseError($e->getMessage(), 500);
        }
    }
}
