<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
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
            'image'=>'required|image|mimes:jpg,jpeg,png,gif|max:2048',
            'name'=>'required|string|max:255',
            'price'=>'required|decimal|min:1',
            'offer_price'=>'decimal|min:1',
            // 'has_offer'=>'boolean',
            // 'best_selling'=>'boolean',
            'brand_id'=>'required|integer|exists:brands,id',
            'sub_category_id'=>'required|integer|exists:sub_categories,id'
        ];
    }

    protected function onUpdate(): array
    {
        return [
            'image'=>'required|image|mimes:jpg,jpeg,png,gif|max:2048',
            'name'=>'required|string|max:255',
            'price'=>'required|decimal|min:1',
            'offer_price'=>'decimal|min:1',
            'has_offer'=>'boolean',
            'best_selling'=>'boolean',
            'brand_id'=>'required|integer|exists:brands,id',
            'sub_category_id'=>'required|integer|exists:sub_categories,id'
        ];
    }

    public function rules(): array
    {
        return request()->isMethod('PUT') || request()->isMethod('PATCH') ? $this->onUpdate() : $this->onCreate();
    }
}
