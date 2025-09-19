<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PanerRequest extends FormRequest
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
            'image'=>'required|image|mimes:jpg,jpeg,png,gif|max:2048'
        ];
    }

    protected function onUpdate(): array
    {
        return [
            'image'=>'required|image|mimes:jpg,jpeg,png,gif|max:2048'
        ];
    }

    public function rules(): array
    {
        return request()->isMethod('PUT') || request()->isMethod('PATCH') ? $this->onUpdate() : $this->onCreate();
    }
}
