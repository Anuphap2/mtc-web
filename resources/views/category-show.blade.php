<x-public-layout>
    {{-- Section Header (ไม่แก้ไข) --}}
    <section class="bg-tech-slate-light py-10">
        <div class="container mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 text-center">
            <div class="relative inline-block mb-4">
                {{-- [ปรับปรุง] ถ้าเป็นหน้า Category ให้แสดงชื่อ Category --}}
                @isset($category)
                    <h1 class="text-4xl font-bold text-tech-slate-dark">หมวดหมู่: {{ $category->name }}</h1>
                @else
                    <h1 class="text-4xl font-bold text-tech-slate-dark">ข่าวสารทั้งหมด</h1>
                @endisset
                <div class="absolute bottom-[-10px] left-1/2 -translate-x-1/2 h-1 w-24 bg-tech-green rounded-full"></div>
            </div>
            @isset($category)
                {{-- Optional: Add category description if available --}}
            @else
                <p class="mt-8 text-lg text-gray-600">รวมข่าวสารและกิจกรรมทั้งหมดจาก MTC</p>
            @endisset
        </div>
    </section>

    {{-- Section Content --}}
    <section class="py-12 sm:py-16 bg-gray-50">
        <div class="container mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            {{-- Grid แสดงข่าว (3 columns) --}}
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @forelse ($posts as $post)
                    {{-- [ปรับปรุง] 2. เรียกใช้ <x-post-card> Component --}}
                    <x-post-card :post="$post" />
                @empty
                    <p class="md:col-span-2 lg:col-span-3 text-center text-gray-500 text-lg py-10">
                        @isset($category)
                            ยังไม่มีข่าวสารในหมวดหมู่ "{{ $category->name }}"
                        @else
                            ยังไม่มีข่าวสารในขณะนี้
                        @endisset
                    </p>
                @endforelse
            </div>

            {{-- Pagination --}}
            <div class="mt-12">
                @if (method_exists($posts, 'links'))
                    {{ $posts->links() }} {{-- Tailwind styled pagination --}}
                @endif
            </div>
        </div>
    </section>
</x-public-layout>
