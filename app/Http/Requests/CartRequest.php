<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CartRequest extends FormRequest
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
            'user_id'=>'required|exists:users,id',
            'product_id'=>'required|exists:products,id',
            'quantity'=>'required|integer|min:1'
        ];
    }

    protected function onUpdate(): array
    {
        return [
            'user_id'=>'required|exists:users,id',
            'product_id'=>'required|exists:products,id',
            'quantity'=>'required|integer|min:1'
        ];
    }

    public function rules(): array
    {
        return request()->isMethod('PUT') || request()->isMethod('PATCH') ? $this->onUpdate() : $this->onCreate();
    }
}
