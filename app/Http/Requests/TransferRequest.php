<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Traits\ValidationTrait;
use Illuminate\Validation\ValidationException;

class TransferRequest extends FormRequest
{

    use ValidationTrait;

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'amount' => ['required', 'numeric', 'gt:0', 'between:1,9999999.99'],
            'email' => ['required', 'email', 'exists:users,email']
        ];
    }


    public function messages(): array
    {
        return [
            'amount.gt' => 'Minimum deposit amount: 1'
            // Add more custom messages as needed
        ];
    }


    public function preventSelfTransfer() {
        
        if ($this->email === auth()->user()->email) {
            throw ValidationException::withMessages([
                'email' => 'Cannot transfer to your own email.',
            ]);
        }

    }

}
