<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class EmailVerificationNotificationController extends Controller
{
    /**
     * Send a new email verification notification.
     */
    public function store(Request $request): RedirectResponse
    {
        if ($request->user(config('constants.ADMIN_DIR'))->hasVerifiedEmail()) {
            return redirect()->intended(route(config('constants.ADMIN_DIR') . '.dashboard', absolute: false));
        }

        $request->user(config('constants.ADMIN_DIR'))->sendEmailVerificationNotification();

        return back()->with('status', 'verification-link-sent');
    }
}
