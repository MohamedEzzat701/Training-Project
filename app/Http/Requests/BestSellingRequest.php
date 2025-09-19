<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BestSellingRequest extends FormRequest
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
            'product_id'=>'required|exists:products,id'
        ];
    }

    protected function onUpdate(): array
    {
        return [
            'product_id'=>'required|exists:products,id'
        ];
    }

    public function rules(): array
    {
        return request()->isMethod('PUT') || request()->isMethod('PATCH') ? $this->onUpdate() : $this->onCreate();
    }
}
