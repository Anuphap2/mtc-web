<x-admin-layout>
    <div class="bg-white p-6 rounded-lg shadow-md">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-xl font-semibold">จัดการข่าวสาร</h2>
            <a href="{{ route('admin.posts.create') }}">
                <x-primary-button>เพิ่มใหม่</x-primary-button>
            </a>
        </div>

        <table class="w-full border-collapse">
            <thead>
                <tr class="bg-gray-100">
                    <th class="border p-2 text-left">รูป</th>
                    <th class="border p-2 text-left">หัวข้อ</th>
                    <th class="border p-2 text-left">ประเภท</th>
                    <th class="border p-2">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($posts as $post)
                    <tr>
                        <td class="border p-2">
                            @if($post->image_path)
                                <img src="{{ Storage::url($post->image_path) }}" alt="{{ $post->title }}" class="h-16 w-16 object-cover">
                            @else
                                (ไม่มีรูป)
                            @endif
                        </td>
                        <td class="border p-2">{{ $post->title }}</td>
                        <td class="border p-2">{{ $post->category->name }}</td>
                        <td class="border p-2 text-center space-x-2">
                            <a href="{{ route('admin.posts.edit', $post) }}" class="text-blue-500 hover:text-blue-700">แก้ไข</a>
                            <form action="{{ route('admin.posts.destroy', $post) }}" method="POST" class="inline" onsubmit="return confirm('คุณแน่ใจหรือไม่ที่จะลบ?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-500 hover:text-red-700">ลบ</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="border p-4 text-center text-gray-500">ยังไม่มีข่าวสาร</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
         <div class="mt-4">
            {{ $posts->links() }}
        </div>
    </div>
</x-admin-layout>