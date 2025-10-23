<x-public-layout>

    {{-- ===== 1. HERO SLIDER SECTION ===== --}}
    @if (isset($featuredPosts) && $featuredPosts->count() > 0)
        {{-- [ปรับปรุง] เปลี่ยนพื้นหลังเป็นสีขาว (bg-white) เพื่อความสะอาดตา --}}
        <section class="bg-white py-10 md:py-16">
            <div class="container mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <h2 class="text-3xl md:text-4xl font-bold text-tech-slate-dark mb-8 text-center">
                    ข่าวเด่น
                </h2>

                {{-- Swiper Slider --}}
                <div class="swiper mySwiper relative rounded-2xl shadow-xl overflow-hidden">
                    <div class="swiper-wrapper">
                        @foreach ($featuredPosts as $featured)
                            {{-- [ปรับปรุง] เพิ่ม 'group' class สำหรับ hover effect ที่รูปภาพ --}}
                            <div class="swiper-slide relative group">
                                <a href="{{ route('post.show', $featured) }}">
                                    <img src="{{ $featured->image_path ? Storage::url($featured->image_path) : asset('images/placeholder.jpg') }}"
                                        alt="{{ $featured->title }}" {{-- [ปรับปรุง] เพิ่ม transition-transform ให้รูปภาพ --}}
                                        class="w-full aspect-video object-cover transition-transform duration-500 group-hover:scale-105">

                                    {{-- [ปรับปรุง] เปลี่ยนจาก Gradient เป็น Glassmorphism Card (แบบ maesod) --}}
                                    <div
                                        class="absolute bottom-6 left-6 right-6 md:bottom-10 md:left-10 md:w-2/3 lg:w-1/2 p-6 md:p-8 
                                               rounded-lg text-white 
                                               bg-black/30 backdrop-blur-md border border-white/20">
                                        <span
                                            class="inline-block bg-tech-green text-xs font-semibold px-3 py-1 rounded-full mb-2 uppercase tracking-wide">
                                            {{ $featured->category->name }}
                                        </span>
                                        <h3 class="mt-1 text-2xl md:text-3xl font-bold line-clamp-2">
                                            {{ $featured->title }}
                                        </h3>
                                        <p class="mt-2 text-sm text-gray-200 line-clamp-2 hidden sm:block">
                                            {{ Str::limit(strip_tags($featured->content), 100) }}
                                        </p>
                                    </div>
                                </a>
                            </div>
                        @endforeach
                    </div>

                    {{-- Navigation --}}
                    {{-- [ปรับปรุง] ปรับดีไซน์ปุ่ม Navigation ให้เป็น Glassmorphism เข้าชุดกัน --}}
                    <div
                        class="swiper-button-prev flex items-center justify-center bg-white/20 hover:bg-white/40 backdrop-blur-sm rounded-full w-10 h-10 absolute left-4 top-1/2 -translate-y-1/2 z-10 transition">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5"
                            stroke="currentColor" class="w-5 h-5 text-white">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                        </svg>
                    </div>
                    <div
                        class="swiper-button-next flex items-center justify-center bg-white/20 hover:bg-white/40 backdrop-blur-sm rounded-full w-10 h-10 absolute right-4 top-1/2 -translate-y-1/2 z-10 transition">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5"
                            stroke="currentColor" class="w-5 h-5 text-white">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                        </svg>
                    </div>

                    {{-- Pagination --}}
                    <div class="swiper-pagination !bottom-4"></div>
                </div>
            </div>
        </section>
    @endif

    {{-- ===== 2. POSTS BY CATEGORY SECTION ===== --}}
    <section class="py-12 sm:py-16 bg-white">
        <div class="container mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 space-y-12">

            @isset($categoriesWithPosts)
                @foreach ($categoriesWithPosts as $category)
                    <div>
                        <div class="flex justify-between items-center mb-6">
                            {{-- [ปรับปรุง] เปลี่ยน Layout Header เป็นแบบเส้นใต้ (maesod style) --}}
                            <div class="relative">
                                <h2 class="text-3xl font-bold text-tech-slate-dark">
                                    {{ $category->name }}
                                </h2>
                                {{-- เส้นใต้สำหรับ Header --}}
                                <div class="absolute bottom-[-8px] left-0 h-1 w-20 bg-tech-green rounded-full"></div>
                            </div>

                            <a href="{{ route('category.show', $category) }}"
                                class="text-sm font-semibold text-tech-green-dark hover:underline flex items-center gap-1">
                                ดูทั้งหมด
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                                    stroke="currentColor" class="w-4 h-4">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                                </svg>
                            </a>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                            @forelse ($category->posts as $post)
                                <div
                                    class="bg-white rounded-lg border border-gray-200 shadow-sm overflow-hidden group transition-transform duration-300 hover:shadow-xl hover:-translate-y-1">
                                    {{-- [ปรับปรุง] เพิ่ม 'relative' เพื่อให้ Category Tag ลอยทับได้ --}}
                                    <a href="{{ route('post.show', $post) }}" class="block overflow-hidden relative">
                                        <img src="{{ $post->image_path ? Storage::url($post->image_path) : asset('images/placeholder.jpg') }}"
                                            alt="{{ $post->title }}" {{-- [ปรับปรุง] เปลี่ยนเป็น aspect-video (16:9) ให้เหมือน Slider --}}
                                            class="aspect-video w-full object-cover transition-transform duration-300 group-hover:scale-105">

                                        {{-- [เพิ่มใหม่] Category Tag บนรูปภาพ --}}
                                        <span
                                            class="absolute top-4 left-4 inline-block bg-tech-green text-xs font-semibold px-3 py-1 rounded-full uppercase tracking-wide text-gray-900">
                                            {{ $post->category->name }}
                                        </span>
                                    </a>
                                    <div class="p-6 flex flex-col">
                                        <h3 class="font-bold text-lg text-gray-900 mb-2">
                                            <a href="{{ route('post.show', $post) }}"
                                                class="hover:text-tech-green-dark transition duration-150 line-clamp-2">
                                                {{ $post->title }}
                                            </a>
                                        </h3>
                                        <p class="text-gray-600 text-sm flex-grow leading-relaxed line-clamp-3">
                                            {{ Str::limit(strip_tags($post->content), 120) }}
                                        </p>
                                        <div class="mt-4 pt-4 border-t border-gray-100 text-sm text-gray-500">
                                            {{ $post->created_at->diffForHumans() }}
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <p class="md:col-span-2 lg:col-span-3 text-center text-gray-500">
                                    ไม่มีข่าวในหมวดหมู่นี้
                                </p>
                            @endforelse
                        </div>
                    </div>
                @endforeach
            @else
                <p class="text-center text-gray-500 text-lg">
                    ยังไม่มีข่าวสารในขณะนี้
                </p>
            @endisset

        </div>
    </section>

    {{-- ===== Swiper JS Initialization ===== --}}
    @push('head')
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css">
        {{-- [เพิ่มใหม่] CSS สำหรับ Pagination ของ Swiper ให้เป็นสีที่เข้ากัน --}}
        <style>
            .swiper-pagination-bullet-active {
                background-color: #34D399 !important;
                /* tech-green */
            }
        </style>
    @endpush

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                new Swiper('.mySwiper', {
                    loop: true,
                    speed: 600,
                    autoplay: {
                        delay: 5000,
                        disableOnInteraction: false
                    },
                    pagination: {
                        el: '.swiper-pagination',
                        clickable: true
                    },
                    navigation: {
                        nextEl: '.swiper-button-next',
                        prevEl: '.swiper-button-prev'
                    },
                    effect: 'slide',
                });
            });
        </script>
    @endpush

</x-public-layout>
