<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DirectorMessage;
use Illuminate\Http\Request;

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

        if ($request->hasFile('image')) {

            // ลบรูปเก่า ถ้ามี
            if ($director && $director->image && file_exists(public_path('storage/' . $director->image))) {
                unlink(public_path('storage/' . $director->image));
            }

            // บันทึกรูปใหม่ตรง public/storage/director
            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('storage/director'), $imageName);

            $validated['image'] = 'director/' . $imageName;
        }

        if ($director) {
            $director->update($validated);
        } else {
            DirectorMessage::create($validated);
        }

        return redirect()->route('admin.director.edit')->with('success', 'อัปเดตข้อมูลเรียบร้อย');
    }
}
