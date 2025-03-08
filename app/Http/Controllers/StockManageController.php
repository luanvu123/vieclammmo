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
            'uids' => 'required|string',
        ]);
        $uids = preg_split('/\r\n|\r|\n/', $request->uids);
        $uids = array_filter(array_map('trim', $uids));

        $results = [];
        $successCount = 0;
        $duplicateCount = 0;

        foreach ($uids as $uid) {
            $existsInAnyStock = UidFacebook::where('uid', $uid)->exists();
            $existsInCurrentStock = UidFacebook::where('stock_id', $stock->id)->where('uid', $uid)->exists();

            if ($existsInCurrentStock) {
                $results[] = "Duplicate|$uid";
                $duplicateCount++;
            } elseif ($existsInAnyStock) {
                $results[] = "Duplicate (Exists in another stock)|$uid";
                $duplicateCount++;
            } else {
                UidFacebook::create([
                    'stock_id' => $stock->id,
                    'uid' => $uid,
                ]);
                $results[] = "Success|$uid";
                $successCount++;
            }
        }
        $results[] = "TOTAL:" . count($uids) . "|SUCCESS:$successCount|DUPLICATE:$duplicateCount";

        if ($stock->file) {
            Storage::disk('public')->delete($stock->file);
        }

        $fileName = "{$successCount}_uids.txt";
        $filePath = "stocks/$fileName";

        Storage::disk('public')->put($filePath, implode("\n", $results));
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
