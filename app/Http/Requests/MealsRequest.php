<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Exceptions\HttpResponseException;
use App\Rules\ValidCategory;

class MealsRequest extends FormRequest
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
            'per_page' => 'min:1|max:200|numeric',
            'lang' => 'exists:languages,slug|required',
            'tags.*' => 'exists:tags,id',
            'category' => new ValidCategory,
            'with.*' => "in:category,ingredients,tags",
            'diff_time' => 'integer|min:1',
        ];
    }

    public function messages()
    {
        return [
            'per_page.min' => 'Meals shown per page cannot be less than 1!',
            'per_page.max' => 'Meals shown per page cannot be more than 200!',
            'per_page.numeric' => 'Per page can only be a numeric value!',
            'lang.exists' => 'Specified language is not supported! Supported languages are English, French and German!',
            'lang.required' => 'Language parameter is required!',
            'tags.*.exists' => 'One of the tags you have specified does not exist!',
            'with.*.in' => 'Data shown with meals can only be: category, tags and ingredients!',
            'diff_time.integer' => 'diff_time parameter can only be an integer!',
            'diff_time.min' => 'diff_time parameter can only be positive number!'
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'tags' => explode(',', $this->tags),
            'with' => explode(',', $this->with),
        ]);
    }

    protected function failedValidation(Validator $validator)
    {
        $errors = (new ValidationException($validator))->errors();

        throw new HttpResponseException(
            response()->json($errors, 400, array(), JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES|JSON_PRETTY_PRINT)
        );
    }
}
