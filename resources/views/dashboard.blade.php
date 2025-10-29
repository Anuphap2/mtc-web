<x-admin-layout :title="'Dashboard'">
    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

            {{-- Greeting --}}
            <div class="bg-white shadow-md rounded-lg p-6">
                <h1 class="text-2xl font-bold text-gray-800">สวัสดี, {{ auth()->user()->name }} 👋</h1>
                <p class="mt-2 text-gray-600">นี่คือแดชบอร์ดของคุณ คุณสามารถดูสรุปข้อมูลและจัดการระบบได้จากที่นี่</p>
            </div>

            {{-- Stats Cards --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">

                {{-- ข่าวสาร --}}
                <div class="bg-indigo-500 text-white p-4 rounded-lg shadow flex items-center justify-between">
                    <div>
                        <h2 class="text-xl font-bold">{{ \App\Models\Post::count() }}</h2>
                        <p class="text-sm">ข่าวสารทั้งหมด</p>
                    </div>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 opacity-50" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 10H5M19 6H5M19 14H5M19 18H5" />
                    </svg>
                </div>

                {{-- หมวดหมู่ --}}
                <div class="bg-green-500 text-white p-4 rounded-lg shadow flex items-center justify-between">
                    <div>
                        <h2 class="text-xl font-bold">{{ \App\Models\Category::count() }}</h2>
                        <p class="text-sm">หมวดหมู่ข่าว</p>
                    </div>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 opacity-50" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </div>

                {{-- เมนู --}}
                <div class="bg-yellow-500 text-white p-4 rounded-lg shadow flex items-center justify-between">
                    <div>
                        <h2 class="text-xl font-bold">{{ \App\Models\Menu::count() }}</h2>
                        <p class="text-sm">เมนูทั้งหมด</p>
                    </div>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 opacity-50" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </div>

                {{-- Featured --}}
                <div class="bg-red-500 text-white p-4 rounded-lg shadow flex items-center justify-between">
                    <div>
                        <h2 class="text-xl font-bold">{{ \App\Models\Post::where('is_featured', true)->count() }}</h2>
                        <p class="text-sm">ข่าวเด่น</p>
                    </div>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 opacity-50" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M11 17l-5-5m0 0l5-5m-5 5h12" />
                    </svg>
                </div>

            </div>

            {{-- Recent Posts --}}
            <div class="bg-white shadow-md rounded-lg p-6">
                <h2 class="text-lg font-semibold mb-4">ข่าวสารล่าสุด</h2>
                <div class="overflow-x-auto">
                    <table class="min-w-full border-collapse table-auto">
                        <thead>
                            <tr class="bg-gray-100">
                                <th class="border px-4 py-2">ID</th>
                                <th class="border px-4 py-2">หัวข้อ</th>
                                <th class="border px-4 py-2">หมวดหมู่</th>
                                <th class="border px-4 py-2">เด่น</th>
                                <th class="border px-4 py-2">วันที่สร้าง</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach (\App\Models\Post::latest()->take(5)->get() as $post)
                                <tr class="hover:bg-gray-50">
                                    <td class="border px-4 py-2">{{ $post->id }}</td>
                                    <td class="border px-4 py-2">{{ $post->title }}</td>
                                    <td class="border px-4 py-2">{{ $post->category?->name ?? '-' }}</td>
                                    <td class="border px-4 py-2 text-center">
                                        @if ($post->is_featured)
                                            <span class="text-green-500 font-bold">✔</span>
                                        @endif
                                    </td>
                                    <td class="border px-4 py-2">{{ $post->created_at->translatedFormat('j M Y') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</x-admin-layout>
