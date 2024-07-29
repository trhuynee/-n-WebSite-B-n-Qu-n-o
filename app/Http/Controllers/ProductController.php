<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product;
use App\Models\Image;
use App\Models\Size;
use App\Models\Color;
use App\Models\Brand;
use App\Models\Product_detail;
use App\Models\Cart;
use GuzzleHttp\Handler\Proxy;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{


    public function index_ad(Request $request)
    {
        $query = Product::with(['category', 'brand']);

        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('tensanpham', 'like', '%' . $search . '%')
                    ->orWhereHas('category', function ($q) use ($search) {
                        $q->where('tenloaisp', 'like', '%' . $search . '%');
                    })
                    ->orWhereHas('brand', function ($q) use ($search) {
                        $q->where('tennhanhieu', 'like', '%' . $search . '%');
                    });
            });
        }

        $product = $query->paginate(10);
         // Cập nhật trạng thái sản phẩm
        foreach ($product as $item) {
            if ($item->soluong == 0) {
                $item->trangthai = 1; // Chuyển thành hết hàng
            } elseif ($item->soluong < 5) {
                $item->trangthai = 2; // Sắp hết hàng
            } else {
                $item->trangthai = 0; // Còn hàng
            }
            $item->save();
        }
        return view('admin.quan-li-san-pham', compact('product')); // Truyền biến product tới view
    }
    public function index_user()
    {
        $name_brand = ['Yame', 'Ben&Tod', 'Chuottrang', 'SomeHow', 'Uniqlo'];

        // Lấy thông tin về các nhãn hiệu
        $brands = Brand::whereIn('tennhanhieu', $name_brand)->get();
        // Lấy tất cả các danh mục sản phẩm
        $categories = Category::all();
        // Lấy các sản phẩm thuộc các nhãn hiệu trên
        $brand_ids = $brands->pluck('id');
        $brand_detail = Product::whereIn('nh_id', $brand_ids)->get();

        // Lấy danh sách các sản phẩm chính
        $products = Product::where('trangthai', 0)
            ->whereIn('nh_id', $brand_ids)
            ->orderByDesc('created_at')
            ->with('image') // Load các ảnh liên kết
            ->get();

        // Tính toán số lượng sản phẩm trong giỏ hàng cho người dùng hiện tại
        // $count = Auth::check() ? Cart::where('user_id', Auth::id())->count() : 0;

        return view('user.index', compact('brand_detail', 'brands', 'products','categories'));
    }
    public function brand($id)
    {
        // Lấy danh sách sản phẩm theo brand_id đã chọn
        $products = Product::where('trangthai', 0)
            ->where('nh_id', $id) // Lọc theo nhãn hiệu
            ->with('image') // Load các ảnh liên kết
            ->paginate(12); // Giới hạn 12 sản phẩm mỗi trang

        // Lấy nhãn hiệu hiện tại
        $brand = Brand::findOrFail($id);

        // Lấy danh sách tất cả các brand để hiển thị trong dropdown
        $brands = Brand::all();

        return view('user.brand', compact('products', 'brands', 'brand'));
    }

    public function category($id)
    {
        $products = Product::where('trangthai', 0)
            ->where('loaisp_id', $id)
            ->with('image')
            ->paginate(12);

        $category = Category::findOrFail($id);
        $categories = Category::all();

        return view('user.category', compact('products', 'categories', 'category'));
    }


    public function create()
    {
        $category = Category::where('trangthai', 0)->get();
        $color = Color::where('trangthai', 0)->get();
        $size = Size::where('trangthai', 0)->get();
        $brand = Brand::where('trangthai', 0)->get();
        return view('admin.them-san-pham', compact('category', 'color', 'size', 'brand'));
    }

    public function store(Request $request)
    {
        // Kiểm tra dữ liệu request
        //dd($request->all());

        $request->validate([
            'dongia' => 'required|numeric|min:1',
            'giamgia' => 'required|numeric|max:100',
            'tensanpham' => 'required|unique:product,tensanpham',
            'loaisp_id' => 'required',
            'nh_id' => 'required',
            'mota' => 'required',
            'soluong' => 'required|integer|min:0',
        ], [
            'giamgia.max' => 'Không được quá 100',
            'giamgia.required' => 'Không được để trống',
            'giamgia.numeric' => 'Phải là một số',
            'dongia.min' => 'Phải lớn hơn 0',
            'dongia.required' => 'Không được để trống',
            'loaisp_id.required' => 'Không được để trống',
            'nh_id.required' => 'Không được để trống',
            'mota.required' => 'Không được để trống',
            'tensanpham.required' => 'Không được để trống',
            'tensanpham.unique' => 'Tên sản phẩm đã tồn tại',
            'soluong.required' => 'Không được để trống',
            'soluong.integer' => 'Phải là số nguyên',
            'soluong.min' => 'Không được nhỏ hơn 0',
        ]);

        $product = new Product;
        $product->tensanpham = $request->input('tensanpham');
        $product->loaisp_id = $request->input('loaisp_id');
        $product->nh_id = $request->input('nh_id');
        $product->mota = $request->input('mota');
        $product->dongia = $request->input('dongia');
        $product->giamgia = $request->input('giamgia');
        $product->soluong = $request->input('soluong');
        $product->trangthai = $request->input('trangthai', '0');
        $product->save();


        if ($request->hasFile('image')) {
            foreach ($request->file('image') as $image) {
                $filenameWithExt = $image->getClientOriginalName(); // Lấy tên file gốc với đuôi mở rộng
                $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME); // Lấy tên file không có đuôi mở rộng
                $extension = $image->getClientOriginalExtension(); // Lấy đuôi mở rộng của file
                $fileNameToStore = $filename . '_' . time() . '.' . $extension; // Tên file mới
                $path = $image->storeAs('public/upload', $fileNameToStore); // Lưu ảnh vào thư mục public/upload

                // Lưu đường dẫn ảnh vào cơ sở dữ liệu
                $hinhAnh = new Image;
                $hinhAnh->sp_id = $product->id;
                $hinhAnh->tenimage = 'upload/' . $fileNameToStore;
                $hinhAnh->save();
            }

            Alert()->success('Thành công', 'Thêm sản phẩm thành công');
            return redirect()->back();
        }
    }


    public function show($id)
    {
        $category = Category::where('trangthai', 0)->get();
        $brand = Brand::where('trangthai', 0)->get();
        $product = Product::find($id); // Lấy sản phẩm được chọn
        $image = Image::where('sp_id', $id)->get();
        return view('admin.chi-tiet-san-pham', compact('product', 'category', 'brand', 'image'));
    }

    public function create_child(string $id)
    {
        $product = Product::findOrFail($id);
        $colors = Color::all();
        $sizes = Size::all();
        $subProducts = Product_detail::where('sanpham_id', $id)->with(['color', 'size'])->get();
        // Tính tổng số lượng tồn kho
        $total = $subProducts->sum('soluong');
        $remainingQuantity = $product->soluong - $total;
        return view('admin.them-san-pham-con', compact('product', 'colors', 'sizes', 'subProducts', 'total','remainingQuantity'));
    }

    // Xử lý thêm sản phẩm con
    public function add_child(Request $request, $id)
    {
        $request->validate([
        'size' => 'required|exists:size,id',
        'mau' => 'required|exists:color,id',
        'soluong' => 'required|integer|min:0',
    ], [
        'size.exists' => 'Kích thước không hợp lệ.',
        'size.required' => 'Vui lòng chọn kích thước.',
        'mau.required' => 'Vui lòng chọn màu sắc.',
        'mau.exists' => 'Màu sắc không hợp lệ.',
        'soluong.required' => 'Vui lòng nhập số lượng.',
        'soluong.integer' => 'Số lượng phải là số nguyên.',
        'soluong.min' => 'Số lượng phải lớn hơn 0.',
    ]);
        $product = Product::findOrFail($id);
        $currentTotalQuantity = $this->getTotalQuantityOfChildProducts($id);
        $remainingQuantity = $product->soluong - $currentTotalQuantity;

        if ($request->input('soluong') > $remainingQuantity) {
            Alert()->error('Lỗi', 'Số lượng vượt quá số lượng còn lại của sản phẩm chính.');
            return redirect()->back();
    }

        $existingProductDetail = Product_detail::where('sanpham_id', $id)
            ->where('mau_id', $request->input('mau'))
            ->where('size_id', $request->input('size'))
            ->first();

        if ($existingProductDetail) {
        $newQuantity = $existingProductDetail->soluong + $request->input('soluong');
        if ($newQuantity > $remainingQuantity) {
            Alert()->error('Lỗi', 'Tổng số lượng sản phẩm con vượt quá số lượng sản phẩm chính.');
            return redirect()->back();
        }
        $existingProductDetail->soluong = $newQuantity;
        $existingProductDetail->save();
        Alert()->success('Thành công', 'Số lượng sản phẩm con đã được cập nhật.');
    } else {
            $productDetail = new Product_detail();
            $productDetail->sanpham_id = $id;
            $productDetail->mau_id = $request->input('mau');
            $productDetail->size_id = $request->input('size');
            $productDetail->soluong = $request->input('soluong');
            $productDetail->save();
            Alert()->success('Thành công', 'Sản phẩm con được thêm thành công.');
        }
        return redirect()->back();
    }
    //số lượng hiện tại của sp con
    private function getTotalQuantityOfChildProducts($productId)
    {
        return Product_detail::where('sanpham_id', $productId)->sum('soluong');
    }
    // Xử lý xóa sản phẩm con
    public function delete_child($id)
    {
        $productDetail = Product_detail::findOrFail($id);
        $productDetail->delete();
        Alert()->success('Thành công', 'Xóa sản phẩm con thành công');
        return redirect()->back();
    }
    public function edit($id)
    {
        $product = Product::findOrFail($id);
        $category = Category::all();
        $brand = Brand::all();
        $image = Image::where('sp_id', $id)->get();
        return view('admin.chinh-sua-san-pham', compact('product', 'category', 'brand', 'image'));
    }
    public function update(Request $request, $id)
    {
        //dd($request->all()); // In ra để kiểm tra dữ liệu gửi đi từ form

        $request->validate(
            [
                'dongia' => 'required|numeric|min:1',
                'giamgia' => 'required|numeric|max:100',
                'tensanpham' => 'required|unique:product,tensanpham,' . $id,
                'loaisp_id' => 'required',
                'nhanhieu_id' => 'required',
                'mota' => 'required',
                'soluong' => 'required|integer|min:0',
            ],
            [
                'giamgia.max' => 'Không được quá 100',
                'giamgia.required' => 'Không được để trống',
                'giamgia.numeric' => 'Phải là một số',
                'dongia.min' => 'Phải lớn hơn 0',
                'dongia.required' => 'Không được để trống',
                'loaisp_id.required' => 'Không được để trống',
                'nhanhieu_id.required' => 'Không được để trống',
                'mota.required' => 'Không được để trống',
                'tensanpham.required' => 'Không được để trống',
                'tensanpham.unique' => 'Tên sản phẩm đã tồn tại',
                'soluong.required' => 'Không được để trống',
                'soluong.integer' => 'Phải là số nguyên',
                'soluong.min' => 'Không được nhỏ hơn 0',
            ]
        );

        $product = Product::findOrFail($id);
        $product->fill($request->all());
        $product->trangthai = $request->input('trangthai', '0');
        $product->save();

    // Xử lý xóa ảnh
        if ($request->has('remove_images')) {
            foreach ($request->remove_images as $imageId) {
                $image = Image::find($imageId);
                if ($image) {
                    Storage::delete('public/' . $image->tenimage);
                    $image->delete();
                }
            }
        }

        if ($request->hasFile('image')) {
            foreach ($request->file('image') as $image) {
                $filenameWithExt = $image->getClientOriginalName();
                $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                $extension = $image->getClientOriginalExtension();
                $fileNameToStore = $filename . '_' . time() . '.' . $extension;
                $path = $image->storeAs('public/upload', $fileNameToStore);
                $hinhAnh = new Image;
                $hinhAnh->sp_id = $product->id;
                $hinhAnh->tenimage = 'upload/' . $fileNameToStore;
                $hinhAnh->save();
            }
        }

        Alert()->success('Thành công', 'Cập nhật sản phẩm thành công');
        return redirect()->back();
    }



    public function destroy(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        Image::where('sp_id', $product->id)->delete();
        $product->delete();
        alert()->success('Thành công', 'Xóa sản phẩm thành công');
        return redirect()->back();
    }



    public function detail($id)
    {
        $product = Product::find($id);
        if (!$product) {
            abort(404); // Xử lý khi không tìm thấy sản phẩm
        }

        // Lấy tất cả các chi tiết sản phẩm
        $allDetails = Product_detail::where('sanpham_id', $id)->get();

        // Lấy các chi tiết sản phẩm duy nhất theo màu và kích thước
        $uniqueDetails = $allDetails->unique(function ($item) {
            return $item->mau_id . '-' . $item->size_id;
        });

        // Lấy màu và kích thước mặc định từ chi tiết sản phẩm đầu tiên (nếu có)
        $defaultDetail = $allDetails->first();
        $defaultColor = $defaultDetail ? $defaultDetail->mau_id : null;
        $defaultSize = $defaultDetail ? $defaultDetail->size_id : null;

        // Lấy tên màu và kích thước mặc định
        $color = Color::find($defaultColor);
        $size = Size::find($defaultSize);
        $colorName = $color ? $color->tenmau : null;
        $sizeName = $size ? $size->tensize : null;

        // Lấy danh sách các size và màu sắc có sẵn
        $availableSizes = Product_detail::select('size_id')->where('sanpham_id', $id)
            ->where('mau_id', $defaultColor)->distinct()->get();
        $availableColors = Product_detail::select('mau_id')->where('sanpham_id', $id)
            ->where('size_id', $defaultSize)->distinct()->get();

        // Lấy chi tiết sản phẩm mặc định
        $productDetail = Product_detail::where('sanpham_id', $id)
            ->where('mau_id', $defaultColor)
            ->where('size_id', $defaultSize)->first();

        // Lấy các hình ảnh của sản phẩm
        $image = Image::where('sp_id', $id)->get();

        // Lấy chi tiết sản phẩm mặc định
        $quantity = $productDetail ? $productDetail->soluong : null;

        // Tính tổng số lượng sản phẩm
        $product->totalStock = $allDetails->sum('soluong');

        return view('user.detail', compact('quantity', 'sizeName', 'colorName', 'productDetail', 'image', 'product', 'availableSizes', 'availableColors', 'uniqueDetails'));
    }

    public function shop()
    {
        // Lấy danh sách các sản phẩm chính

        $products = Product::where('trangthai', 0)
            ->with('image') // Load các ảnh liên kết
            ->paginate(9); // Giới hạn 9 sản phẩm mỗi trang
        return view('user.shop', compact('products'));
    }

   public function search(Request $request)
    {
        $searchTerm = $request->input('search');
        $sort = $request->input('sort', 'default');

        $query = Product::where('trangthai', 0);

        if (!empty($searchTerm)) {
            $query->where(function ($q) use ($searchTerm) {
                $q->where('tensanpham', 'like', "%$searchTerm%")
                    ->orWhereHas('category', function ($q) use ($searchTerm) {
                        $q->where('tenloaisp', 'like', "%$searchTerm%");
                    })
                    ->orWhereHas('brand', function ($q) use ($searchTerm) {
                        $q->where('tennhanhieu', 'like', "%$searchTerm%");
                    });
            });
        }

        switch ($sort) {
        case 'asc':
            $query->orderBy('tensanpham', 'asc');
            break;
        case 'desc':
            $query->orderBy('tensanpham', 'desc');
            break;
        case 'price_asc':
            $query->orderByRaw('(dongia * (1 - giamgia / 100)) ASC');
            break;
        case 'price_desc':
            $query->orderByRaw('(dongia * (1 - giamgia / 100)) DESC');
            break;
        default:
            // Mặc định sắp xếp theo id hoặc trường khác
            $query->orderBy('id', 'desc');
            break;
    }

    $products = $query->paginate(12)->appends($request->except('page'));

    return view('user.shop', compact('products', 'searchTerm', 'sort'));
    }

      public function search_user(Request $request)
    {
        $keyword = $request->input('keyword');
        // Tìm sản phẩm có tên chứa từ khóa và thuộc loại sản phẩm hoặc thuộc thương hiệu
        $products = Product::where('tensanpham', 'LIKE', "%$keyword%")
            ->where(function ($query) use ($keyword) {
                $query->whereHas('category', function ($q) use ($keyword) {
                    $q->where('tenloaisp', 'LIKE', "%$keyword%");
                })
                    ->orWhereHas('brand', function ($q) use ($keyword) {
                        $q->where('tennhanhieu', 'LIKE', "%$keyword%");
                    });
            })
            ->get();
        return view('user.search', compact('products'));
    }
    public function filterByPrice(Request $request)
    {
        $query = Product::query();

        // Xử lý lọc theo giá dựa trên dữ liệu từ form
        if ($request->has('price_all')) {
            // Lọc tất cả sản phẩm (không áp dụng filter giá)
        } else {
            // Xử lý các khoảng giá được chọn
            $priceRanges = $request->input('price_range');

            foreach ($priceRanges as $range) {
                if ($range == 2) {
                    $query->orWhereBetween('dongia', [0, 500000]);
                } elseif ($range == 3) {
                    $query->orWhereBetween('dongia', [500001, 1000000]);
                }
                // Thêm các khoảng giá khác tương tự
            }
        }

        $products = $query->paginate(9); // Số sản phẩm trên mỗi trang

        return view('user.shop', compact('products'));
    }
}
