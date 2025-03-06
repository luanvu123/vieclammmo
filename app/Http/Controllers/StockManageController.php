<?php

namespace App\Http\Controllers;

use App\Models\ProductVariant;
use App\Models\Stock;
use App\Models\UidFacebook;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class StockManageController extends Controller
{
    public function index(ProductVariant $variant)
    {
        $stocks = $variant->stocks()->with('uidFacebooks')->get();
        return view('admin.stock.index', compact('stocks', 'variant'));
    }
    public function UidIndex($stockId)
    {
        $stock = Stock::with('uidFacebooks')->findOrFail($stockId); // Lấy Stock và danh sách UID Facebook
        return view('admin.stock.uid_index', compact('stock'));
    }
    public function UidCreate($stockId)
    {
        $stock = Stock::findOrFail($stockId);
        return view('admin.stock.uid_create', compact('stock'));
    }

    // Lưu UID Facebook vào Stock
    public function uidStore(Request $request, Stock $stock)
    {
        $request->validate([
            'uids' => 'required|string', // Dữ liệu phải là chuỗi
        ]);

        // Tách các UID từ request
        $uids = preg_split('/\r\n|\r|\n/', $request->uids);
        $uids = array_filter(array_map('trim', $uids)); // Loại bỏ UID trống

        $results = [];
        $successCount = 0; // Đếm UID lưu thành công
        $duplicateCount = 0; // Đếm UID trùng lặp

        foreach ($uids as $uid) {
    // Kiểm tra xem UID đã tồn tại với bất kỳ stock_id nào chưa
    $existsInAnyStock = UidFacebook::where('uid', $uid)->exists();

    // Kiểm tra xem UID đã tồn tại với stock_id hiện tại chưa
    $existsInCurrentStock = UidFacebook::where('stock_id', $stock->id)->where('uid', $uid)->exists();

    if ($existsInCurrentStock) {
        // Nếu đã tồn tại trong cùng stock_id thì coi là trùng lặp
        $results[] = "Duplicate|$uid";
        $duplicateCount++;
    } elseif ($existsInAnyStock) {
        // Nếu UID tồn tại với stock_id khác thì cũng coi là trùng lặp
        $results[] = "Duplicate (Exists in another stock)|$uid";
        $duplicateCount++;
    } else {
        // Nếu UID chưa tồn tại trong bất kỳ stock nào, lưu vào database
        UidFacebook::create([
            'stock_id' => $stock->id,
            'uid' => $uid,
        ]);
        $results[] = "Success|$uid";
        $successCount++;
    }
}


        // Thêm dòng thống kê cuối file
        $results[] = "TOTAL:" . count($uids) . "|SUCCESS:$successCount|DUPLICATE:$duplicateCount";

        // Xóa file cũ nếu có
        if ($stock->file) {
            Storage::disk('public')->delete($stock->file);
        }

        // Tạo tên file theo số lượng UID thành công
        $fileName = "{$successCount}_uids.txt";
        $filePath = "stocks/$fileName";

        // Lưu file vào thư mục `storage/app/public/stocks/`
        Storage::disk('public')->put($filePath, implode("\n", $results));

        // Cập nhật stock với file mới, số lượng, và trạng thái
        $stock->update([
            'file' => $filePath,
            'quantity_success' => $successCount,
            'quantity_error' => $duplicateCount,
            'status' => 'active',
        ]);

        return redirect()->route('stock.uid_index', $stock->id)
            ->with('success', "Đã lưu UID và tạo file thành công! ($successCount UID mới)")
            ->with('file_url', asset("storage/$filePath")); // Trả về đường dẫn file
    }
}
