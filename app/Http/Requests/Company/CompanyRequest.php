<?php

namespace App\Http\Requests\Company;

use Illuminate\Foundation\Http\FormRequest;

class CompanyRequest extends FormRequest
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
        $id = $this->route()->company->id;

        return [
            'name' => [
                'required',
                'unique:companies,name,'.$id.',id,deleted_at,NULL',
                'max:255',
            ],
            'code' => [
                'required',
                'unique:companies,code,'.$id.',id,deleted_at,NULL',
                'max:16',
                'regex:/^[a-zA-Z0-9]+$/',
            ],
            'address' => ['nullable', 'max:2000'],
            'description' => ['nullable', 'max:2000'],
            'founding_date' => ['nullable', 'date', 'date_format:Y-m-d'],
            'image' => ['nullable', 'file', 'max:4000', 'mimes:jpeg,jpg,png']
        ];
    }
}
