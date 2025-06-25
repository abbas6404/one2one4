<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserModeController extends Controller
{
    /**
     * Switch user mode between donor and recipient.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function switch(Request $request)
    {
        $request->validate([
            'mode' => 'required|in:donor,recipient'
        ]);

        $user = Auth::user();
        $success = $user->switchMode($request->mode);

        if ($success) {
            return response()->json([
                'success' => true,
                'message' => 'Mode switched successfully',
                'mode' => $user->mode
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Failed to switch mode'
        ], 400);
    }

    /**
     * Get current user mode.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getMode()
    {
        $user = Auth::user();
        
        return response()->json([
            'success' => true,
            'mode' => $user->mode,
            'is_donor' => $user->isDonor(),
            'is_recipient' => $user->isRecipient()
        ]);
    }
} 