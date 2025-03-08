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

    foreach ($uids as $line) {
        $parts = explode('|', $line);
        if (count($parts) < 2) {
            continue; // Bỏ qua dòng không hợp lệ
        }

        $uid = trim($parts[0]);
        $value = implode('|', array_slice($parts, 1)); // Ghép phần còn lại thành value

        $existsInCurrentStock = UidFacebook::where('stock_id', $stock->id)->where('uid', $uid)->exists();

        if ($existsInCurrentStock) {
            $results[] = "Duplicate|$uid";
            $duplicateCount++;
        } else {
            UidFacebook::create([
                'stock_id' => $stock->id,
                'uid' => $uid,
                'value' => $value,
            ]);
            $results[] = "Success|$uid";
            $successCount++;
        }
    }

    $results[] = "TOTAL:" . count($uids) . "|SUCCESS:$successCount|DUPLICATE:$duplicateCount";

    // Lưu kết quả vào file
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
        ->with('success', "Đã lưu UID thành công! ($successCount UID mới)")
        ->with('file_url', asset("storage/$filePath"));
}
public function uidEmailStore(Request $request, Stock $stock)
{
    $request->validate([
        'uids' => 'required|string',
    ]);

    $uids = preg_split('/\r\n|\r|\n/', $request->uids);
    $uids = array_filter(array_map('trim', $uids));

    $results = [];
    $successCount = 0;
    $duplicateCount = 0;

    foreach ($uids as $line) {
        $parts = explode('|', $line);
        if (count($parts) < 2) {
            continue; // Bỏ qua dòng không hợp lệ
        }

        $email = trim($parts[0]);
        $value = implode('|', array_slice($parts, 1)); // Ghép phần còn lại thành value

        $existsInCurrentStock = UidEmail::where('stock_id', $stock->id)->where('email', $email)->exists();

        if ($existsInCurrentStock) {
            $results[] = "Duplicate|$email";
            $duplicateCount++;
        } else {
            UidEmail::create([
                'stock_id' => $stock->id,
                'email' => $email,
                'value' => $value,
            ]);
            $results[] = "Success|$email";
            $successCount++;
        }
    }

    $results[] = "TOTAL:" . count($uids) . "|SUCCESS:$successCount|DUPLICATE:$duplicateCount";

    // Lưu kết quả vào file
    $fileName = "{$successCount}_uids_email.txt";
    $filePath = "stocks/$fileName";
    Storage::disk('public')->put($filePath, implode("\n", $results));

    $stock->update([
        'file' => $filePath,
        'quantity_success' => $successCount,
        'quantity_error' => $duplicateCount,
        'status' => 'active',
    ]);

    return redirect()->route('stock.uid_index', $stock->id)
        ->with('success', "Đã lưu Email thành công! ($successCount email mới)")
        ->with('file_url', asset("storage/$filePath"));
}

}

