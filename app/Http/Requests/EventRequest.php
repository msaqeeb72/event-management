<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EventRequest extends BaseRequest
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
        if($this->isMethod("get")) return [];
        $isUpdate = $this->isMethod("put");

        $rules = [
            'title'          => ['required', 'string'],
            'description'    => ['nullable', 'string'],
            'start_datetime' => ['required', 'date'],
            'end_datetime'   => ['nullable', 'date', 'after_or_equal:start_datetime'],
            'venue'          => ['nullable', 'string'],
            'city'           => ['nullable', 'string'],
            'state'          => ['nullable', 'string'],
            'country'        => ['nullable', 'string'],
            'image'          => ['required','file_extension:png,jpg,jpeg']
        ];

        if ($isUpdate) {
            $rules['status'] = ['required', 'in:published,cancelled,postponed'];
            $rules['is_active'] = ['required', 'boolean'];
            foreach ($rules as $field => &$rule) {
                $rule = array_filter($rule, fn($r) => $r !== 'required');
            }
        }

        return $rules;
    }
}













