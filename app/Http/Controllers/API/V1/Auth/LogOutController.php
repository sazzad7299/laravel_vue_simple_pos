<?php

namespace App\Http\Controllers\API\V1\Auth;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use Illuminate\Http\Request;

class LogOutController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $user = auth('sanctum')->user();

        if ($user) {
            $data = [
                'user_id' => $user->id,
                'model_id' => $user->id,
                'model_name' => 'User',
                'activity_type' => 'Login',
                'activity' => 'Logout successfully!',
            ];
            ActivityLog::create($data);
            $user->tokens()->delete();
            session()->forget('pharmacy_id');
            return $this->respondSuccess(null, 'User logged out successfully');
        }

        // Handle the case where the user is not authenticated
        return $this->respondError('User not found', 404);
    }
}