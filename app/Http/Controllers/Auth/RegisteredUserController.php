<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Validation\Rule;
use Illuminate\Database\Query\Builder;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): Response
    {
        return Inertia::render('Auth/Register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'fname' => 'required|string|max:255',
            'lname' => 'required|string|max:255',
            'uname' => [
                'required',
                'string',
                'max:255',
                Rule::unique(User::class)->where(fn (Builder $query) =>
                    $query->where('status', '!=', 'trash')
                ),
            ],
            'email' => [
                'required',
                'string',
                'lowercase',
                'email',
                'max:255',
                Rule::unique(User::class)->where(fn (Builder $query) =>
                    $query->where('status', '!=', 'trash')
                ),
            ],
            'country_code' => 'required|string|max:10',
            'phone' => [
                'required',
                'digits_between:6,20',
            ],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'profile_picture' => 'nullable|file|mimes:jpg,jpeg,png,webp|max:2048',
            'photo_id' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:4096',
        ]);

        $phone = substr($request->phone, strlen($request->country_code));
        $email = strtolower($request->email);

        $existing = false;
        foreach(User::where('status', '!=', 'trash')->cursor() as $user){
            $additionalEmails = array_filter(explode(',', $user->additional_email));
            $additionalPhones = json_decode($user->additional_phones, true) ?? [];
            if(in_array($email, $additionalEmails)){
                $existing = ['field' => 'email', 'message' => 'Entered email already exists!'];
                break;
            }
            if($user->country_code == $request->country_code && $user->phone == $phone){
                $existing = ['field' => 'phone', 'message' => 'Entered phone already exists!'];
                break;
            }
            foreach($additionalPhones as $addPhone){
                if($addPhone['country_code'] == $request->country_code && $addPhone['phone'] == $phone){
                    $existing = ['field' => 'phone', 'message' => 'Entered phone already exists!'];
                    break 2;
                }
            }
        }

        if($existing){
            return redirect()->back()
                ->withInput()
                ->withErrors([$existing['field'] => $existing['message']]);
        }

        $profilePicture = $request->hasFile('profile_picture')
        ? basename($request->file('profile_picture')->store('profile_pictures', 'public'))
        : null;

        $photoId = $request->hasFile('photo_id')
        ? basename($request->file('photo_id')->store('photo_ids'))
        : null;
        

        $user = User::create([
            'fname' => $request->fname,
            'lname' => $request->lname,
            'email' => $request->email,
            'uname' => $request->uname,
            'country_code' => $request->country_code,
            'phone' => $phone,
            'profile_picture' => $profilePicture,
            'photo_id' => $photoId,
            'password' => $request->password,
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect(route('dashboard', absolute: false));
    }
}
