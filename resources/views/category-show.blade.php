<x-public-layout>
    {{-- Section Header --}}
    <section class="bg-tech-slate-light py-10">
        <div class="container mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 text-center">
            {{-- [ปรับปรุง] เพิ่มเส้นใต้ Header (Maesod Style) --}}
            <div class="relative inline-block mb-4">
                <h1 class="text-4xl font-bold text-tech-slate-dark">ข่าวสารทั้งหมด</h1>
                <div class="absolute bottom-[-10px] left-1/2 -translate-x-1/2 h-1 w-24 bg-tech-green rounded-full"></div>
            </div>
            <p class="mt-8 text-lg text-gray-600">รวมข่าวสารและกิจกรรมทั้งหมดจาก MTC</p>
        </div>
    </section>

    {{-- Section Content --}}
    <section class="py-12 sm:py-16 bg-white">
        <div class="container mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            {{-- Grid แสดงข่าว (3 columns) --}}
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @forelse ($posts as $post)
                    {{-- [ปรับปรุง] ปรับดีไซน์การ์ดให้เหมือนหน้าแรก (Section 2) --}}
                    <div
                        class="bg-white rounded-xl shadow-md overflow-hidden border border-gray-100 hover:shadow-lg transition-all duration-300 transform hover:-translate-y-1 group">
                        <a href="{{ route('post.show', $post) }}" class="block overflow-hidden relative">
                            {{-- [ปรับปรุง] เปลี่ยนเป็น aspect-[4/3] (อัตราส่วน 4:3) --}}
                            <img class="aspect-[4/3] w-full object-cover transition-transform duration-300 group-hover:scale-105"
                                src="{{ $post->image_path ? Storage::url($post->image_path) : asset('images/placeholder.jpg') }}"
                                alt="{{ $post->title }}">

                            {{-- [ปรับปรุง] เพิ่ม Category Tag ลอยทับบนรูป --}}
                            <span
                                class="absolute top-3 left-3 inline-block bg-tech-green/90 backdrop-blur-sm text-white text-xs font-semibold px-2.5 py-1 rounded-full uppercase tracking-wide">
                                {{ $post->category?->name ?? 'ข่าวสาร' }}
                            </span>
                        </a>
                        <div class="p-5 flex-1 flex flex-col justify-between"> {{-- Use justify-between --}}
                            <div>
                                <h3 class="font-semibold text-lg text-gray-800 line-clamp-2 mb-2">
                                    <a href="{{ route('post.show', $post) }}"
                                        class="hover:text-tech-green-dark transition duration-150">
                                        {{ $post->title }}
                                    </a>
                                </h3>
                                {{-- [ปรับปรุง] เอาเนื้อหาย่อออก ให้การ์ดดูสะอาดตา (เหมือนหน้าแรก) --}}
                                {{-- <p class="mt-3 text-gray-600 text-sm flex-grow line-clamp-3">
                                    {{ Str::limit(strip_tags($post->content), 120) }}
                                </p> --}}
                            </div>
                            <div class="mt-4 pt-3 border-t border-gray-100 text-xs text-gray-500">
                                {{-- Use text-xs --}}
                                {{ $post->created_at?->diffForHumans() ?? '-' }}
                            </div>
                        </div>
                    </div>
                @empty
                    <p class="md:col-span-2 lg:col-span-3 text-center text-gray-500 text-lg py-10">
                        ยังไม่มีข่าวสารในขณะนี้
                    </p>
                @endforelse
            </div>

            {{-- Pagination --}}
            <div class="mt-12">
                {{-- ตรวจสอบว่า $posts มี links() method (ถ้ามาจาก allPosts() จะมี) --}}
                @if (method_exists($posts, 'links'))
                    {{ $posts->links() }} {{-- Tailwind styled pagination --}}
                @endif
            </div>
        </div>
    </section>
</x-public-layout>
