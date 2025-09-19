<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BrandRequest extends FormRequest
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
            'name'=>'required|string|max:255'
        ];
    }

    protected function onUpdate(): array
    {
        return [
            'name'=>'required|string|max:255'
        ];
    }

    public function rules(): array
    {
        return request()->isMethod('PUT') || request()->isMethod('PATCH') ? $this->onUpdate() : $this->onCreate();
    }
}
