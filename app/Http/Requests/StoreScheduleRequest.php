<?php

namespace App\Http\Requests;

use App\Enums\Frequency;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class StoreScheduleRequest extends FormRequest
{
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'starts_at' => [
                'required',
                Rule::date()
                    ->format('Y-m-d H:i:s'),
            ],
            'ends_at' => [
                'required',
                Rule::date()
                    ->format('Y-m-d H:i:s')
                    ->afterOrEqual('starts_at'),
            ],
            'frequency' => ['required', Rule::enum(Frequency::class)],
            'employee_id' => [
                'required',
                Rule::exists('employees', 'id')->where('user_id', Auth::id()),
            ],
        ];
    }
}
