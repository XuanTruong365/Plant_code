<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    /**
     * Handle user registration.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(Request $request)
    {
        try {
            //Validate input
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255',
                'email' => 'required|string|max:255|unique:users,email',
                'password' => 'required|string|min:8|confirmed',
                'phone' => 'nullable|string|max:20',
                'avatar' => 'nullable|url',
            ]);
            if ($validator->fails()) {
                return $this->responseError($validator->errors()->first(), 422);
            }

            //Create user
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'phone' => $request->phone,
                'avatar' => $request->avatar ?? null,
                'status' => 'active',
                'role' => 'customer',
            ]);

            //optionally, you can log the user in after registration
            // auth()->login($user);
            return $this->responseSuccess($user, __('message.register_success'));
        } catch (\Exception $e) {
            return $this->responseError($e->getMessage(), 500);
        }
    }
}
