<x-admin-layout>
    <div class="bg-white p-6 rounded-lg shadow-md">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-xl font-semibold">จัดการประเภทข่าว</h2>
            <a href="{{ route('admin.categories.create') }}">
                <x-primary-button>เพิ่มใหม่</x-primary-button>
            </a>
        </div>

        <table class="w-full border-collapse">
            <thead>
                <tr class="bg-gray-100">
                    <th class="border p-2 text-left">ID</th>
                    <th class="border p-2 text-left">Name</th>
                    {{-- Removed Slug column header --}}
                    <th class="border p-2">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($categories as $category)
                    <tr>
                        <td class="border p-2">{{ $category->id }}</td>
                        <td class="border p-2">{{ $category->name }}</td>
                        {{-- Removed Slug column data --}}
                        <td class="border p-2 text-center space-x-2">
                            <a href="{{ route('admin.categories.edit', $category) }}" class="text-blue-500 hover:text-blue-700">แก้ไข</a>
                            <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" class="inline" onsubmit="return confirm('คุณแน่ใจหรือไม่ที่จะลบ?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-500 hover:text-red-700">ลบ</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="border p-4 text-center text-gray-500">ยังไม่มีประเภทข่าว</td> {{-- Adjusted colspan --}}
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div class="mt-4">
            {{ $categories->links() }}
        </div>
    </div>
</x-admin-layout>
