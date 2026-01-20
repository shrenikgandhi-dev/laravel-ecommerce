<?php

namespace App\Http\Requests;

use App\Models\Admin;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Database\Eloquent\Builder;

class AdminProfileUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'fname' => ['required', 'string', 'max:255'],
            'lname' => ['required', 'string', 'max:255'],
            'uname' => [
                'required',
                'string',
                'max:255',
                Rule::unique(Admin::class)
                    ->ignore($this->user()->id)
                    ->where(fn (Builder $query) =>
                        $query->where('status', '!=', 'trash')
                    ),
            ],
            'email' => [
                'required',
                'string',
                'lowercase',
                'email',
                'max:255',
                Rule::unique(Admin::class)
                    ->ignore($this->user()->id)
                    ->where(fn (Builder $query) =>
                        $query->where('status', '!=', 'trash')
                    ),
            ],
        ];
    }
    public function withValidator($validator)
    {
        $validator->after(function ($validator) {

            $email = $this->input('email');
            $currentUserId = $this->user()->id;

            $exists = Admin::where('status', '!=', 'trash')
                ->where('id', '!=', $currentUserId)
                ->whereNotNull('additional_email')
                ->where('additional_email', 'LIKE', "%{$email}%")
                ->exists();

            if ($exists) {
                $validator->errors()->add(
                    'email',
                    'Entered email already exists!'
                );
            }
        });
    }
}
