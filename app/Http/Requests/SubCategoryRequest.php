<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SubCategoryRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    protected function onCreate(): array
    {
        return [
            'category_id'=>'required|integer|exists:categories,id',
            'name'=>'required|string|max:255'
        ];
    }

    protected function onUpdate(): array
    {
        return [
            'category_id'=>'required|integer|exists:categories,id',
            'name'=>'required|string|max:255'
        ];
    }

    public function rules(): array
    {
        return request()->isMethod('PUT') || request()->isMethod('PATCH') ? $this->onUpdate() : $this->onCreate();
    }
}
