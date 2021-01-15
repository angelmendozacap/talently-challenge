<?php

namespace App\Http\Requests;

use App\Models\Phase;
use Illuminate\Foundation\Http\FormRequest;

class ChangeApplicationPhaseRequest extends FormRequest
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
            'phase_id' => ['required', 'exists:'.Phase::class.',id']
        ];
    }
}
