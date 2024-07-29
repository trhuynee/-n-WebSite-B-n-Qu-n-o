<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Color;

class ColorController extends Controller
{
    public function edit($id)
    {
        $color = Color::find($id);
        return view('admin.chinh-sua-chung', [
            'type' => 'màu sắc',
            'updateRoute' => route('cap-nhat-mau-sac', ['id' => $color->id]),
            'nameField' => 'tenmau',
            'item' => $color
        ]);
    }

    public function update(Request $request, string $id)
    {
        $request->validate(
            [
                'tenmau' => 'required|max:30|unique:color,tenmau,' . $id,
                'trangthai' => 'required',
            ],
            [
                'trangthai.required' => 'Không được để trống',
                'tenmau.unique' => 'Tên nhãn hiệu sản phẩm đã tồn tại',
                'tenmau.max' => 'Không quá 30 ký tự',
                'tenmau.required' => 'Không được để trống'
            ]
        );

        $color = Color::findOrFail($id);
        $color->update($request->all());

        alert()->success('Thành công', 'Cập nhật màu sắc thành công');
        return \redirect()->back();
    }

    public function destroy(Request $request, $id)
    {
        $color = Color::findOrFail($id);
        $color->delete();
        alert()->success('Thành công', 'Xóa màu thành công');
        return redirect()->back();
    }
}
