<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CheckoutRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'customer.name' => 'required|string|max:255',
            'customer.email' => 'required|email',
            'customer.phone' => 'nullable|string|max:50',
            'customer.address' => 'required|string|max:500',
            'customer.city' => 'required|string|max:100',
            'customer.zipCode' => 'nullable|string|max:20',
            'paymentMethod' => 'required|in:cod,bank_transfer',
            'couponCode' => 'nullable|string',
            'notes' => 'nullable|string|max:500',
        ];
    }
}
