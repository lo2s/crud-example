<?php

namespace App\Http\Requests\API\Employee;

use Illuminate\Foundation\Http\FormRequest;

class CreateEmployeeRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:employees|max:255',
            'phone' => 'required|string|min:10',
            'salary' => 'required|numeric',
        ];
    }
}
