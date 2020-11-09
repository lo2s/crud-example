<?php

namespace App\Http\Requests\API\Employee;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateEmployeeRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required|string|max:255|sometimes',
            'email' => [
                'required',
                'email',
                'max:255',
                'sometimes',
                Rule::unique('employees')
                    ->ignore($this->route('employee')->id),
            ],
            'phone' => 'required|string|min:10|sometimes',
            'salary' => 'required|numeric|sometimes',
        ];
    }
}
