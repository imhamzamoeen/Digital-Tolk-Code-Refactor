<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BookingControllerIndexRequest extends FormRequest
{
    public function authorize()
    {
        return auth()->user()->hasPermission('booking-index');
    }

    public function rules()
    {
        return [
            'user_id' => ['sometimes','required','integer','exists:users,id'],
        ];
    }
    public function messages(){
        return [
            'user_id.*'=>__('bookingController.user_id.*'),
        ];
    }
}