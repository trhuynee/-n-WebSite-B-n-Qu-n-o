<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Size;

class SizeController extends Controller
{


    public function edit($id)
    {
        $size = Size::find($id);
        return view('admin.chinh-sua-chung', [
            'type' => 'kích thước',
            'updateRoute' => route('cap-nhat-kich-thuoc', ['id' => $size->id]),
            'nameField' => 'tensize',
            'item' => $size
        ]);
    }

    public function update(Request $request, string $id)
    {
        $request->validate(
            [
                'tensize' => 'required|max:30|unique:size,tensize,' . $id,
                'trangthai' => 'required',
            ],
            [
                'trangthai.required' => 'Không được để trống',
                'tensize.unique' => 'Tên nhãn hiệu sản phẩm đã tồn tại',
                'tensize.max' => 'Không quá 30 ký tự',
                'tennhanhieutensize.required' => 'Không được để trống'
            ]
        );

        $size = Size::findOrFail($id);
        $size->update($request->all());

        alert()->success('Thành công', 'Cập nhật kích thước thành công');
        return \redirect()->back();
    }

    public function destroy(Request $request, $id)
    {
        $size = Size::findOrFail($id);
        $size->delete();
        alert()->success('Thành công', 'Xóa kích thước thành công');
        return redirect()->back();
    }
}