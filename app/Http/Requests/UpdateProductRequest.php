<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        //Trong điều kiện unique loại bỏ tên sản phẩm hiện tại vì có thể
        //chỉ sửa những trường khác, giữ nguyên tên cũ
        return [
            'name' => ['required', Rule::unique('products')->ignore($this->product), 'max:100'],
            'price' => ['required', 'numeric', 'integer', 'min:0'],
            'category' => ['required', 'exists:categories,id'],
            'desc' => ['required'],
            'image' => ['required', 'mimes:png,jpg,bmp']
        ];
    }

    //sửa câu thông báo

    public function messages()
    {
        return [
            'name.required' => 'Tên sản phẩm không được bỏ trống',
            'name.unique' => 'Tên sản phẩm đã tồn tại',
            'name.max' => 'Tên sản phẩm không được quá 100 ký tự',
            'price.required' => 'Tên sản phẩm không được bỏ trống',
            'price.numberic' => 'Giá tiền phải là số',
            'price.integer' => 'Giá tiền phải là số nguyên',
            'price.min' => 'Giá tiền có giá trị nhỏ nhất bằng 0',
            'category.required' => 'Tên sản phẩm không được bỏ trống',
            'category.exists,id' => 'Kết quả trả về theo id',
            'desc.required' => 'Mô tả không được bỏ trống',
            'image.required' => 'Hình ảnh không được bỏ trống',
            'image.mimes' => 'File ảnh phải là dạng .jpg, png, bmp'
        ];
    }
}
