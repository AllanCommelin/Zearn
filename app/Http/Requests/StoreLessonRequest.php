<?php

namespace App\Http\Requests;

use App\User;
use Illuminate\Foundation\Http\FormRequest;

class StoreLessonRequest extends FormRequest
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
        $professor_ids = implode(',',User::select('id')->whereRole('professor')->get()->pluck('id')->toArray());
        return [
            'name' => 'required|string',
            'professor_id' => 'required|integer|in:'.$professor_ids
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'professor_id.in' => 'Seul un professeur peut être responsable d\'une formation.',
        ];
    }
}
