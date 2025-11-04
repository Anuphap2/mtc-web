<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DirectorMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DirectorMessageController extends Controller
{
    public function edit()
    {
        $director = DirectorMessage::first();
        return view('admin.director.edit', compact('director'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'position' => 'nullable|string|max:255',
            'message' => 'nullable|string',
            'image' => 'nullable|image|max:2048',
        ]);

        $director = DirectorMessage::first();

        // ✅ ถ้ามีการอัปโหลดรูปใหม่
        if ($request->hasFile('image')) {

            // 🔹 ลบรูปเก่าก่อน (ถ้ามีอยู่)
            if ($director && $director->image && Storage::disk('public')->exists($director->image)) {
                Storage::disk('public')->delete($director->image);
            }

            // 🔹 บันทึกรูปใหม่
            $validated['image'] = $request->file('image')->store('director', 'public');
        }

        // ✅ อัปเดตหรือสร้างใหม่
        if ($director) {
            $director->update($validated);
        } else {
            DirectorMessage::create($validated);
        }

        return redirect()->route('admin.director.edit')->with('success', 'อัปเดตข้อมูลเรียบร้อย');
    }
}
