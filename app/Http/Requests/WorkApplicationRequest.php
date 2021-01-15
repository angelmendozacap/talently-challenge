<?php

namespace App\Http\Requests;

use App\Models\Phase;
use Illuminate\Foundation\Http\FormRequest;

class WorkApplicationRequest extends FormRequest
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
            'name' => ['required', 'string', 'max:100'],
            'company' => ['required', 'string', 'max:100'],
            'description' => ['required', 'string', 'nullable'],
            'phase_id' => ['required', 'exists:' . Phase::class . ',id'],
            'application_date' => ['required', 'date_format:Y-m-d']
        ];
    }
}
