<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class EmailVerificationPromptController extends Controller
{
    /**
     * Display the email verification prompt.
     */
    public function __invoke(Request $request): RedirectResponse|Response
    {
        return $request->user(config('constants.ADMIN_DIR'))->hasVerifiedEmail()
                    ? redirect()->intended(route(config('constants.ADMIN_DIR') . '.dashboard', absolute: false))
                    : Inertia::render(config('constants.ADMIN_DIR_UC') . '/VerifyEmail', ['status' => session('status')]);
    }
}
