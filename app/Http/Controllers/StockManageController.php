<?php

namespace App\Http\Controllers;

use App\Models\ProductVariant;
use App\Models\Stock;
use App\Models\UidEmail;
use App\Models\UidFacebook;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class StockManageController extends Controller
{
    public function index(ProductVariant $variant)
    {
        $stocks = $variant->stocks()->with(['uidFacebooks', 'uidEmails'])->get();
        return view('admin.stock.index', compact('stocks', 'variant'));
    }
    public function indexAll()
{
    $stocks = Stock::with(['productVariant.product.customer'])->get();
    return view('admin.stock.indexAll', compact('stocks'));
}

    public function UidIndex($stockId)
    {
        $stock = Stock::with('uidFacebooks')->findOrFail($stockId); // Lấy Stock và danh sách UID Facebook
        return view('admin.stock.uid_index', compact('stock'));
    }
    public function uidEmailIndex($stockId)
    {
        $stock = Stock::with('uidEmails')->findOrFail($stockId); // Lấy Stock và danh sách UID Email
        return view('admin.stock.uid_email_index', compact('stock'));
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

            // Kiểm tra nếu UID đã tồn tại trong bất kỳ stock_id nào
            $existsInAnyStock = UidFacebook::where('uid', $uid)->exists();

            if ($existsInAnyStock) {
                $results[] = "Duplicate|$line";
                $duplicateCount++;
                continue; // Bỏ qua toàn bộ dòng
            }

            // Nếu UID chưa tồn tại, tiến hành thêm vào database
            UidFacebook::create([
                'stock_id' => $stock->id,
                'uid' => $uid,
                'value' => implode('|', array_slice($parts, 1)), // Ghép phần còn lại thành value
            ]);

            $results[] = "Success|$line";
            $successCount++;
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

            $uid = trim($parts[0]);

            // Kiểm tra nếu UID đã tồn tại trong bất kỳ stock_id nào
            $existsInAnyStock = UidEmail::where('email', $uid)->exists();

            if ($existsInAnyStock) {
                $results[] = "Duplicate|$line";
                $duplicateCount++;
                continue; // Bỏ qua toàn bộ dòng
            }

            // Nếu UID chưa tồn tại, tiến hành thêm vào database
            UidEmail::create([
                'stock_id' => $stock->id,
                'email' => $uid,
                'value' => implode('|', array_slice($parts, 1)), // Ghép phần còn lại thành value
            ]);

            $results[] = "Success|$line";
            $successCount++;
        }

        $results[] = "TOTAL:" . count($uids) . "|SUCCESS:$successCount|DUPLICATE:$duplicateCount";

        // Lưu kết quả vào file
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

        return redirect()->route('stock.uid_email_index', $stock->id)
            ->with('success', "Đã lưu Email thành công! ($successCount email mới)")
            ->with('file_url', asset("storage/$filePath"));
    }



}

