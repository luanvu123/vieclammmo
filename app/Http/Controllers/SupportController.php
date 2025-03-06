<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Support;

class SupportController extends Controller
{
    public function index()
    {
        $supports = Support::orderBy('created_at', 'desc')->paginate(10);
        return view('admin.support.index', compact('supports'));
    }

    public function edit($id)
    {
        $support = Support::findOrFail($id);
        return view('admin.support.edit', compact('support'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:Đã phản hồi,Chưa phản hồi',
        ]);

        $support = Support::findOrFail($id);
        $support->update(['status' => $request->status]);

        return redirect()->route('supports.index')->with('success', 'Cập nhật trạng thái thành công!');
    }

    public function destroy($id)
    {
        $support = Support::findOrFail($id);
        $support->delete();

        return redirect()->route('supports.index')->with('success', 'Xóa thành công!');
    }
}
