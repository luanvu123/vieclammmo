<?php
namespace App\Http\Controllers;

use App\Models\Complaint;
use App\Models\Order;
use App\Models\OrderDetail;

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
        return view('home');
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
        $order = Order::with(['orderDetails', 'productVariant.product.customer'])
            ->where('id', $orderId)
            ->first();

        if (!$order) {
            abort(404);
        }

        return view('admin.order.detail_index', compact('order'));
    }

}
