<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Get the authenticated user's profile.
     */
    public function profile(Request $request)
    {
        return response()->json([
            'message' => 'message.profile_loaded',
            'data' => $request->user(),
        ]);
    }

    /**
     * Display a listing of users.
     */
    public function index(Request $request)
    {
        $query = User::query();

        if ($request->has('search')) {
            $keyword = $request->search;
            $query->where('name', 'LIKE', "%{$keyword}%")
                ->orWhere('email', 'LIKE', "%{$keyword}%");
        }

        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        $users = $query->latest()->paginate(10);
        return response()->json($users);
    }

    /**
     * Store a newly created user.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'phone'    => 'nullable|string|max:20',
            'avatar'   => 'nullable|string',
            'status'   => 'nullable|integer',
            'role'     => 'nullable|string',
        ]);

        $validated['password'] = Hash::make($validated['password']);

        $user = User::create($validated);

        return response()->json([
            'message' => 'User created successfully!',
            'data' => $user,
        ], 201);
    }

    /**
     * Display the specified user.
     */
    public function show($id)
    {
        $user = User::with(['addresses', 'orders', 'activityLogs'])
            ->findOrFail($id);

        return response()->json($user);
    }

    /**
     * Update the specified user.
     */
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $validated = $request->validate([
            'name'     => 'nullable|string|max:255',
            'email'    => 'nullable|email|unique:users,email,' . $id,
            'password' => 'nullable|min:6',
            'phone'    => 'nullable|string|max:20',
            'avatar'   => 'nullable|string',
            'status'   => 'nullable|integer',
            'role'     => 'nullable|string',
        ]);

        if (!empty($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        $user->update($validated);

        return response()->json([
            'message' => 'User updated successfully!',
            'data' => $user,
        ]);
    }

    /**
     * Soft delete a user.
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return response()->json(['message' => 'User deleted successfully!']);
    }

    /**
     * Restore soft deleted user.
     */
    public function restore($id)
    {
        $user = User::onlyTrashed()->findOrFail($id);
        $user->restore();

        return response()->json(['message' => 'User restored successfully!']);
    }

    /**
     * Force delete user permanently.
     */
    public function forceDelete($id)
    {
        $user = User::onlyTrashed()->findOrFail($id);
        $user->forceDelete();

        return response()->json(['message' => 'User permanently deleted!']);
    }
}
