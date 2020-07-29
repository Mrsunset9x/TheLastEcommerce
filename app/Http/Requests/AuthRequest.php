<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Symfony\Component\HttpFoundation\Response;

class AuthRequest extends FormRequest
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
            'name' => 'required|unique:users|min:10',
            'email' => 'required|unique:users',
            'phone'=>'required|unique:users',
        ];
    }

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'errors' => [
                'status'   => false,
                'code'     => Response::HTTP_UNPROCESSABLE_ENTITY,
                'messages' => $validator->errors()
            ]
        ], Response::HTTP_UNPROCESSABLE_ENTITY));
    }
    public function messages()
    {
        return [
            'name.required' => 'Bạn vui lòng nhập tên ! ',
            'name.min'      =>'Họ và Tên phải có ít nhất 20 ký tự',
            'name.unique'   => 'Tên của bạn đã tồn tại !',
            'email.unique'  => 'Email của bạn đã tồn tại !',
            'phone.unique'  => 'Số điện thoại của bạn đã tồn tại !',
            'phone.required'  => 'Vui lòng nhập số điện thoại  !',
        ];
    }

}
