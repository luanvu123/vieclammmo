<?php

namespace App\Http\Controllers;

use Laravel\Socialite\Facades\Socialite;
use App\Models\Customer;
use App\Models\Message;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Validation\ValidationException;

class CustomerAuthController extends Controller
{
    // Đăng ký
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:customers,email',
            'password' => 'required|confirmed|min:6',
        ]);

        $customer = Customer::create([
            'idCustomer' => Customer::generateUniqueId(), // Gọi hàm tạo mã ngẫu nhiên
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // Gửi tin nhắn chào mừng từ Admin (ID = 5)
        Message::create([
            'sender_id' => 5, // ID của admin
            'receiver_id' => $customer->id, // ID của khách hàng mới
            'message' => "Chào mừng bạn đến với taphoammo. Nếu có khó khăn gì trong quá trình sử dụng trang, nhắn tin cho mình ngay nhé. Bạn có thể tham khảo thêm về các câu hỏi thường gặp trên menu chính (FAQs). Xin cảm ơn.",
            'status' => 'sent', // hoặc 1 nếu bạn dùng kiểu boolean
        ]);

        return redirect()->route('login.customer')->with('success', 'Đăng ký thành công!');
    }



    // Đăng nhập
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::guard('customer')->attempt($request->only('email', 'password'))) {
            $customer = Auth::guard('customer')->user();

            // Cập nhật thời gian hoạt động gần nhất
            $customer->update(['last_active_at' => now()]);

            // Lưu lịch sử đăng nhập
            \App\Models\LoginHistory::create([
                'customer_id' => $customer->id,
                'device' => $request->header('User-Agent'),
            ]);

            return redirect()->route('profile.site')->with('success', 'Xin chào, ' . $customer->email);
        }

        return redirect()->back()->with('error', 'Thông tin đăng nhập không chính xác.');
    }


    public function authenticated(Request $request, $customer)
    {
        if ($customer->is2Fa) {
            return redirect()->route('2fa.setup');
        }

        return redirect()->route('profile.site');
    }


    // Đăng xuất
    public function logout()
    {
        Auth::guard('customer')->logout();
        return redirect()->route('login.customer');
    }
    // Chuyển hướng đến trang đăng nhập Google
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    // Xử lý callback từ Google
    public function handleGoogleCallback()
    {
        try {
            $user = Socialite::driver('google')->stateless()->user();
            $existingCustomer = Customer::where('google_id', $user->id)->first();

            if ($existingCustomer) {
                // Đăng nhập nếu đã tồn tại tài khoản
                Auth::guard('customer')->login($existingCustomer);
                return redirect()->route('profile.site')->with('success', 'Xin chào, ' . $existingCustomer->email);
            } else {
                // Tạo tài khoản mới nếu chưa có
                $newCustomer = Customer::create([
                    'idCustomer' => Customer::generateUniqueId(),
                    'name' => $user->name,
                    'email' => $user->email,
                    'google_id' => $user->id,
                    'password' => Hash::make('defaultpassword'), // Đặt mật khẩu mặc định (có thể thay đổi sau)
                ]);

                Auth::guard('customer')->login($newCustomer);
                return redirect()->route('profile.site')->with('success', 'Xin chào, ' . $newCustomer->email);
            }
        } catch (\Exception $e) {
            return redirect()->route('login.customer')->with('error', 'Đăng nhập Google thất bại.');
        }
    }
}
