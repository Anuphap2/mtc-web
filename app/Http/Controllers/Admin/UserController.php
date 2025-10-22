<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules;


class UserController extends Controller
{
    public function index()
    {
        $users = User::latest()->paginate(10);
        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        return view('admin.users.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users',
            'email' => 'nullable|string|email|max:255|unique:users',
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        User::create([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('admin.users.index')->with('success', 'สร้างผู้ใช้งานสำเร็จ');
    }

    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            // ตรวจสอบ username ว่าซ้ำหรือไม่ โดย "ยกเว้น" ID ของตัวเอง
            'username' => ['required', 'string', 'max:255', Rule::unique('users')->ignore($user->id)],
            'email' => ['nullable', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            // รหัสผ่าน "ไม่บังคับ" กรอกตอนแก้ไข
            'password' => ['nullable', 'confirmed', Rules\Password::defaults()],
        ]);

        // เตรียมข้อมูล
        $data = [
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
        ];

        // ตรวจสอบว่ามีการกรอกรหัสผ่านใหม่หรือไม่
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return redirect()->route('admin.users.index')->with('success', 'อัปเดตผู้ใช้งานสำเร็จ');
    }

    public function destroy(User $user)
    {
        // (แนะนำ) เพิ่มเงื่อนไขว่าห้ามลบตัวเอง หรือห้ามลบ Admin คนสุดท้าย
        if (auth()->id() === $user->id) {
            return redirect()->route('admin.users.index')->with('error', 'ไม่สามารถลบตัวเองได้');
        }

        $user->delete();
        return redirect()->route('admin.users.index')->with('success', 'ลบผู้ใช้งานสำเร็จ');
    }
}