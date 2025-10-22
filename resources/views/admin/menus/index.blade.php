<x-admin-layout>
    <div class="bg-white p-6 rounded-lg shadow-md">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-xl font-semibold">จัดการเมนู</h2>
            <a href="{{ route('admin.menus.create') }}">
                <x-primary-button>เพิ่มใหม่</x-primary-button>
            </a>
        </div>

        <table class="w-full border-collapse">
            <thead>
                <tr class="bg-gray-100">
                    <th class="border p-2 text-left">ลำดับ (Order)</th>
                    <th class="border p-2 text-left">Name</th>
                    <th class="border p-2 text-left">URL</th>
                    <th class="border p-2">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($menus as $menu)
                    <tr>
                        <td class="border p-2">{{ $menu->order }}</td>
                        <td class="border p-2">{{ $menu->name }}</td>
                        <td class="border p-2">{{ $menu->url }}</td>
                        <td class="border p-2 text-center space-x-2">
                            <a href="{{ route('admin.menus.edit', $menu) }}" class="text-blue-500 hover:text-blue-700">แก้ไข</a>
                            <form action="{{ route('admin.menus.destroy', $menu) }}" method="POST" class="inline" onsubmit="return confirm('คุณแน่ใจหรือไม่ที่จะลบ?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-500 hover:text-red-700">ลบ</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
         <div class="mt-4">
            {{ $menus->links() }}
        </div>
    </div>
</x-admin-layout>