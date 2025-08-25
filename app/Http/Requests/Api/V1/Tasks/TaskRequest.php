<?php

namespace App\Http\Requests\Api\V1\Tasks;

use App\Http\Requests\Api\BaseFormApiRequest;
use Illuminate\Validation\Rule;

class TaskRequest extends BaseFormApiRequest
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
     */
    public function rules(): array
    {
        // Common rules
        return  [
            'title'       => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'status_id'   => ['nullable', 'exists:statuses,id'],
            'assigned_to' => ['nullable', Rule::exists('users', 'id')->withoutTrashed()],
        ];
    }
}
