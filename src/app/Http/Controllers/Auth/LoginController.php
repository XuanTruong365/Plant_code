<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use PHPUnit\Exception;

class LoginController extends Controller
{
    /**
     * Handle user login request.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        try {
            //validate input
            $validator = Validator::make($request->all(), [
                'email' => 'required|email',
                'password' => 'required|string|min:8',
            ]);

            if ($validator->fails()) {
                return $this->responseError($validator->errors()->first(), 422);
            }

            $ceredentials = $request->only('email', 'password');

            //attempt to login
            if (!auth()->attempt($ceredentials)) {
                return $this->responseError(__('message.invalid_credentials'), 401);
            }

            $user = auth()->user();

            //generate token
            $token = $user->createToken('auth_token')->plainTextToken;

            $responseData = [
                'access_token' => $token,
                'token_type' => 'Bearer',
                'user' => $user
            ];

            return $this->responseSuccess($responseData, __('message.login_success'));
        } catch (\Exception $e) {
            return $this->responseError($e->getMessage(), 500);
        }
    }

    /**
     * Logout user (revoke token).
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout(Request $request) {
        try {
            $user = $request->user();

            if (!$user) {
                return $this->responseError(__('message.unauthenticated'), 401);
            }
            //revoke all tokens
            $user->currentAccessToken()->delete();

            return $this->responseSuccess(null, __('message.logout_success'));
        } catch (Exception $e) {
            return $this->responseError($e->getMessage(), 500);
        }
    }
}
