<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTaskRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => 'required|string|max:255',
            'description' => 'nullable',
            'user_id' => 'required|exists:users,id'
        ];
    }

    public function messages()
    {
        return [
            'title.required' => 'Title is required.',
            'title.string' => 'Title must be string.',
            'title.max' => 'Title is too long.',
            'user_id.required' => 'Task must be assigned to user.',
            'user_id.exists' => 'Assigned user not exists.',
        ];
    }
}
