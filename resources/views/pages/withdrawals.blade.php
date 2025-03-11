@extends('layout')

@section('content')
    <div class="post-container">
        <h1 class="text-2xl font-bold mb-6">Rút tiền</h1>

        @if(session('error'))
            <div class="text-red-500">{{ session('error') }}</div>
        @endif

        <form action="{{ route('withdrawals.store') }}" method="POST">
            @csrf
            <div class="mb-4">
                <label for="bank" class="block text-sm font-medium text-gray-700">Tên Ngân Hàng</label>
                <select name="bank" id="bank" class="form-control custom-select w-full border p-2" required>
                    <option value="">Chọn...</option>
                    <option value="ICB">VietinBank</option>
                    <option value="VCB">Vietcombank</option>
                    <option value="BIDV">BIDV</option>
                    <option value="VBA">Agribank</option>
                    <option value="OCB">OCB</option>
                    <option value="MB">MBBank</option>
                    <option value="TCB">Techcombank</option>
                    <option value="ACB">ACB</option>
                    <option value="VPB">VPBank</option>
                    <option value="TPB">TPBank</option>
                    <option value="STB">Sacombank</option>
                    <option value="Khac">Khác</option>
                </select>
            </div>

            <div class="mb-4">
                <label for="bankAccName" class="block text-sm font-medium text-gray-700">Tên Chủ Tài Khoản</label>
                <input type="text" name="bankAccName" id="bankAccName" class="border p-2 w-full" required>
            </div>

            <div class="mb-4">
                <label for="bankAccNum" class="block text-sm font-medium text-gray-700">Số Tài Khoản</label>
                <input type="text" name="bankAccNum" id="bankAccNum" class="border p-2 w-full" required>
            </div>

            <div class="mb-4">
                <label for="amount" class="block text-sm font-medium text-gray-700">Số Tiền</label>
                <input type="number" name="amount" id="amount" class="border p-2 w-full" min="0" required>
            </div>

            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Rút tiền</button>
        </form>
    </div>
@endsection
