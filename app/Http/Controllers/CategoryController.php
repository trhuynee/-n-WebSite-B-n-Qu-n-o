<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    public function edit($id)
    {
        $category = Category::find($id);
        return view('admin.chinh-sua-chung', [
            'type' => 'loại sản phẩm',
            'updateRoute' => route('cap-nhat-loai', ['id' => $category->id]),
            'nameField' => 'tenloaisp',
            'item' => $category
        ]);
    }
    public function update(Request $request, string $id)
    {
        $request->validate(
            [
                'tenloaisp' => 'required|max:30|unique:category,tenloaisp,' . $id,
                'trangthai' => 'required',
            ],
            [
                'trangthai.required' => 'Không được để trống',
                'tenloaisp.unique' => 'Tên nhãn hiệu sản phẩm đã tồn tại',
                'tenloaisp.max' => 'Không quá 30 ký tự',
                'tenloaisp.required' => 'Không được để trống'
            ]
        );

        $category = Category::findOrFail($id);
        $category->update($request->all());

        alert()->success('Thành công', 'Cập nhật loại sản phẩm thành công');
        return \redirect()->back();
    }

    public function destroy(Request $request, $id)
    {
        $category = Category::findOrFail($id);
        $category->delete();
        alert()->success('Thành công', 'Xóa loại sản phẩm thành công');
        return redirect()->back();
    }
}
