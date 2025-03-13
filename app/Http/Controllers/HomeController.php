<?php
namespace App\Http\Controllers;

use App\Models\Complaint;
use App\Models\Customer;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Withdrawal;
use Carbon\Carbon;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        // Lấy dữ liệu trong vòng 30 ngày qua
        $startDate = Carbon::now()->subDays(30);
        $orders = Order::where('created_at', '>=', $startDate)->get();

        // Thống kê số lượng đơn hàng thành công và thất bại theo ngày
        $completedOrders = $orders->where('status', 'completed')->groupBy(function ($date) {
            return Carbon::parse($date->created_at)->format('Y-m-d');
        })->map->count();

        $canceledOrders = $orders->where('status', 'canceled')->groupBy(function ($date) {
            return Carbon::parse($date->created_at)->format('Y-m-d');
        })->map->count();

        // Tổng doanh thu từ các đơn hàng thành công
        $totalRevenue = $orders->where('status', 'completed')->sum('total');

        return view('home', compact('completedOrders', 'canceledOrders', 'totalRevenue'));
    }
    /**
     * Display a listing of complaints.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function indexComplaint()
    {
        $complaints = Complaint::with(['customer', 'order'])->get();
        return view('admin.complaint.index', compact('complaints'));
    }
    public function indexOrderDetail()
    {
        $orderDetails = OrderDetail::with('order.customer')->get();
        return view('admin.order_detail.index', compact('orderDetails'));
    }
    public function IndexOrder()
    {
        $orders = Order::with(['orderDetails', 'productVariant.product.customer'])
            ->get();

        return view('admin.order.index', compact('orders'));
    }

   public function OrderDetail($orderId)
{
    $order = Order::with([
        'orderDetails',
        'productVariant.product.customer',
        'productVariant.product.category'  // Thêm cái này
    ])->where('id', $orderId)->first();

    if (!$order) {
        abort(404);
    }

    return view('admin.order.detail_index', compact('order'));
}

   public function IndexWithdrawal()
{
    $withdrawals = Withdrawal::with('customer')->get();
    return view('admin.withdrawal.index', compact('withdrawals'));
}

    public function updateWithdrawalStatus(Request $request, $id)
    {
        $withdrawal = Withdrawal::findOrFail($id);
        $withdrawal->status = $request->status;
        $withdrawal->save();

        return redirect()->back()->with('success', 'Cập nhật trạng thái thành công.');
    }

 public function indexCustomer()
{
    $customers = Customer::whereNotNull('account_number')->get();


    return view('admin.customers.seller', compact('customers'));
}


    public function updateIsseller(Request $request, $id)
    {
        $customer = Customer::findOrFail($id);
        $customer->isSeller = !$customer->isSeller; // Đổi trạng thái isSeller
        $customer->save();

        return redirect()->route('admin.customers.index')->with('success', 'Trạng thái người bán đã được cập nhật!');
    }

}
