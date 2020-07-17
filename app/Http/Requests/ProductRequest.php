<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;
use Symfony\Component\HttpFoundation\Response;

class ProductRequest extends FormRequest
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
            'name' => 'required|min:10|max:50',
            'price'=> 'numeric',
            'status'   =>'boolean',
            'featured_products' => 'boolean'
        ];
    }
    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'errors' => [
                'status' => false,
                'code' => Response::HTTP_UNPROCESSABLE_ENTITY,
                'messages' => $validator->errors()
            ]
        ], Response::HTTP_UNPROCESSABLE_ENTITY));
    }

    public function messages()
    {
        return [
            'name.required' => 'Vui lòng nhập tên sản phẩm',
            'name.min'      => 'Tên không được nhỏ hơn 10 ký tự',
            'name.max'      => 'Tên khồn được quá 50 ký tự',
            'price.numeric'         => 'Số tiền phải là kiểu số',
            'status.boolean' => 'Trạng thái phải là có hoặc không',
            'featured_products.boolean' =>'Sản phẩm nổi bật chỉ chọn có hoặc không'
        ];
    }
}
