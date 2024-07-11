<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class UpdatePersonRequest extends FormRequest
{
    /**
     * Determine if the person is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        //dd($this->person->id);
        $userId = $this->route('person') ? $this->route('person')->id : null;
        //dd($userId);
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $userId,
            'gender' => 'required|in:male,female',
            'birthday' => 'required|date',
            'avatar' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ];
    }
}
