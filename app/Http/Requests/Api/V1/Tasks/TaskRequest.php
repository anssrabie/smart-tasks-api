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
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {

        if ($this->isMethod('patch') || $this->isMethod('put')) {
            return [
                'title'        => ['required','required','string','max:255'],
                'description'  => ['required','nullable','string'],
            ];
        }

        // Post
        return [
            'title'        => ['required','string','max:255'],
            'description'  => ['required','string'],
            'status_id'    => ['nullable','exists:statuses,id'],
            'assigned_to'  => [
                'nullable',
                Rule::exists('users','id')->withoutTrashed(),
            ],
        ];
    }
}
