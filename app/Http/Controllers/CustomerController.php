<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use PragmaRX\Google2FA\Google2FA;



class CustomerController extends Controller
{
    public function dashboard()
    {
        return view('admin_customer.index');
    }


    public function profile()
    {
        $customer = Auth::guard('customer')->user();

        $loginHistories = $customer->loginHistories()->orderBy('login_time', 'desc')->take(5)->get();

        return view('pages.profile', compact('customer', 'loginHistories'));
    }
    public function profileEdit()
    {
        $customer = Auth::guard('customer')->user();
        return view('pages.profile_edit', compact('customer'));
    }

    public function profileUpdate(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'url_facebook' => 'nullable|url',
        ]);

        $customer = Auth::guard('customer')->user();
        $customer->update([
            'name' => $request->name,
            'phone' => $request->phone,
            'url_facebook' => $request->url_facebook,
        ]);

        return redirect()->route('profile.site')->with('success', 'Cập nhật hồ sơ thành công.');
    }
    public function editKYC(Request $request)
    {
        $customer = Auth::guard('customer')->user();

        // Kiểm tra và lưu ảnh mặt trước CMND
        if ($request->hasFile('Front_ID_card_image')) {
            $frontImage = $request->file('Front_ID_card_image');
            $frontImageName = time() . '_front.' . $frontImage->getClientOriginalExtension();
            $frontImage->move(public_path('uploads/kyc'), $frontImageName);
            $customer->Front_ID_card_image = 'uploads/kyc/' . $frontImageName;
        }

        // Kiểm tra và lưu ảnh mặt sau CMND
        if ($request->hasFile('Back_ID_card_image')) {
            $backImage = $request->file('Back_ID_card_image');
            $backImageName = time() . '_back.' . $backImage->getClientOriginalExtension();
            $backImage->move(public_path('uploads/kyc'), $backImageName);
            $customer->Back_ID_card_image = 'uploads/kyc/' . $backImageName;
        }

        // Kiểm tra và lưu ảnh chân dung
        if ($request->hasFile('Portrait_image')) {
            $portraitImage = $request->file('Portrait_image');
            $portraitImageName = time() . '_portrait.' . $portraitImage->getClientOriginalExtension();
            $portraitImage->move(public_path('uploads/kyc'), $portraitImageName);
            $customer->Portrait_image = 'uploads/kyc/' . $portraitImageName;
        }

        // Cập nhật isEkyc nếu đã có đủ 3 ảnh
        if ($customer->Front_ID_card_image && $customer->Back_ID_card_image && $customer->Portrait_image) {
            $customer->isEkyc = true;
        }

        $customer->save();

        return redirect()->back()->with('success', 'Đã cập nhật eKYC thành công!');
    }


    // Phương thức tạo secret key cho 2FA
    public function generate2faSecret(Request $request)
    {
        $customer = Auth::guard('customer')->user();

        // Kiểm tra nếu người dùng đã có secret key
        if ($customer->google2fa_secret) {
            return response()->json([
                'success' => false,
                'message' => 'Bạn đã có secret key 2FA',
            ]);
        }

        // Tạo secret key mới
        $google2fa = new Google2FA();
        $secretKey = $google2fa->generateSecretKey();

        // Lưu secret key vào session
        $request->session()->put('2fa_secret', $secretKey);

        // Tạo QR code
        $qrCodeUrl = $google2fa->getQRCodeUrl(
            'TapHoaMmo', // Tên ứng dụng của bạn
            $customer->email, // Email người dùng
            $secretKey // Secret key
        );

        return response()->json([
            'success' => true,
            'secret' => $secretKey,
            'qrCodeUrl' => $qrCodeUrl,
        ]);
    }

    // Phương thức bật 2FA
    public function enable2fa(Request $request)
    {
        $customer = Auth::guard('customer')->user();

        // Validate dữ liệu
        $request->validate([
            'verification_code' => 'required|string|size:6',
        ]);

        // Lấy secret key từ session
        $secretKey = $request->session()->get('2fa_secret');

        if (!$secretKey) {
            return response()->json([
                'success' => false,
                'message' => 'Không tìm thấy secret key, vui lòng tạo lại',
            ]);
        }

        // Xác nhận mã OTP
        $google2fa = new Google2FA();
        $valid = $google2fa->verifyKey($secretKey, $request->verification_code);

        if (!$valid) {
            return response()->json([
                'success' => false,
                'message' => 'Mã xác thực không đúng, vui lòng thử lại',
            ]);
        }

        // Cập nhật dữ liệu người dùng
        $customer->google2fa_secret = $secretKey;
        $customer->is2Fa = true;
        $customer->save();

        // Xóa secret key khỏi session
        $request->session()->forget('2fa_secret');

        return response()->json([
            'success' => true,
            'message' => 'Bảo mật 2 lớp đã được bật thành công',
        ]);
    }

    // Phương thức tắt 2FA
    public function disable2fa(Request $request)
    {
        $customer = Auth::guard('customer')->user();

        // Validate dữ liệu
        $request->validate([
            'verification_code' => 'required|string|size:6',
        ]);

        // Xác nhận mã OTP
        $google2fa = new Google2FA();
        $valid = $google2fa->verifyKey($customer->google2fa_secret, $request->verification_code);

        if (!$valid) {
            return response()->json([
                'success' => false,
                'message' => 'Mã xác thực không đúng, vui lòng thử lại',
            ]);
        }

        // Cập nhật dữ liệu người dùng
        $customer->google2fa_secret = null;
        $customer->is2Fa = false;
        $customer->save();

        return response()->json([
            'success' => true,
            'message' => 'Bảo mật 2 lớp đã được tắt thành công',
        ]);
    }
    // Add these methods to your CustomerController class
    public function show2faVerify()
    {
        return view('pages.2fa_verify');
    }

    public function verify2fa(Request $request)
    {
        $request->validate([
            'verification_code' => 'required|string|size:6',
        ]);

        $customer = Auth::guard('customer')->user();
        $google2fa = new Google2FA();

        $valid = $google2fa->verifyKey($customer->google2fa_secret, $request->verification_code);

        if ($valid) {
            $request->session()->put('2fa_verified', true);
            return redirect()->intended(route('profile.site'));
        }

        return back()->withErrors(['verification_code' => 'Mã xác thực không đúng']);
    }
}
