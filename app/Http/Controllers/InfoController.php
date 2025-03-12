<?php

namespace App\Http\Controllers;

use App\Models\Info;
use Illuminate\Http\Request;

class InfoController extends Controller
{
    public function edit()
    {
        $info = Info::first();
        return view('admin.infos.edit', compact('info'));
    }

 public function update(Request $request)
{
    $info = Info::first();

    $data = $request->except(['logo_bank', 'qr_code']);

    if ($request->hasFile('logo_bank')) {
        $data['logo_bank'] = $request->file('logo_bank')->store('logos', 'public');
    }

    if ($request->hasFile('qr_code')) {
        $data['qr_code'] = $request->file('qr_code')->store('qr_codes', 'public');
    }

    $info->update($data);

    return redirect()->back()->with('success', 'Info updated successfully.');
}

}
