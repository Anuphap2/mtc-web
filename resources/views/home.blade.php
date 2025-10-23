<x-public-layout>

    {{-- ===== 1. HERO SLIDER SECTION (NEW) ===== --}}
    @if (isset($featuredPosts) && $featuredPosts->count() > 0)
        <section class="bg-tech-slate-light py-8">
            <div class="container mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <h2 class="text-3xl font-bold text-tech-slate-dark mb-6 text-center">ข่าวเด่น</h2>
                {{-- ใส่ Slider Component ที่นี่ (ตัวอย่างง่ายๆ) --}}
                <div class="relative overflow-hidden rounded-lg shadow-lg">
                    {{-- ควรใช้ Library เช่น Swiper.js เพื่อ Slider ที่ดีกว่า --}}
                    <div class="flex transition-transform duration-500 ease-in-out">
                        @foreach ($featuredPosts as $featured)
                            <div class="w-full flex-shrink-0 relative">
                                <a href="{{ route('post.show', $featured) }}">
                                    <img src="{{ $featured->image_path ? Storage::url($featured->image_path) : asset('images/placeholder.jpg') }}"
                                        alt="{{ $featured->title }}" class="w-full h-96 object-cover">
                                    <div
                                        class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/80 to-transparent p-6">
                                        <span
                                            class="text-sm font-semibold text-tech-green uppercase">{{ $featured->category->name }}</span>
                                        <h3 class="mt-1 text-2xl font-bold text-white line-clamp-2">
                                            {{ $featured->title }}</h3>
                                    </div>
                                </a>
                            </div>
                        @endforeach
                    </div>
                    {{-- เพิ่มปุ่ม Navigation/Pagination ของ Slider ที่นี่ --}}
                </div>
            </div>
        </section>
    @endif


    {{-- ===== 2. POSTS BY CATEGORY SECTION (NEW) ===== --}}
    <section class="py-12 sm:py-16 bg-white">
        <div class="container mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 space-y-12">

            {{-- วนลูป Categories ที่มี Posts --}}
            @isset($categoriesWithPosts)
                @foreach ($categoriesWithPosts as $category)
                    <div>
                        {{-- ชื่อ Category และลิงก์ "ดูทั้งหมด" --}}
                        <div class="flex justify-between items-center mb-6">
                            <h2 class="text-3xl font-bold text-tech-slate-dark border-l-4 border-tech-green pl-4">
                                {{ $category->name }}
                            </h2>
                            <a href="{{ route('category.show', $category) }}"
                                class="text-sm font-semibold text-tech-green-dark hover:underline">
                                ดูทั้งหมด &rarr;
                            </a>
                        </div>

                        {{-- Grid แสดงข่าว 3 ข่าวล่าสุดของ Category นี้ --}}
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                            @forelse ($category->posts as $post)
                                <div
                                    class="bg-white rounded-lg shadow-lg overflow-hidden flex flex-col group border border-gray-200 transition-all duration-300 hover:shadow-2xl hover:-translate-y-2">
                                    <a href="{{ route('post.show', $post) }}" class="block overflow-hidden">
                                        <img class="h-56 w-full object-cover transition duration-300 ease-in-out group-hover:scale-105"
                                            src="{{ $post->image_path ? Storage::url($post->image_path) : asset('images/placeholder.jpg') }}"
                                            alt="{{ $post->title }}">
                                    </a>
                                    <div class="p-6 flex-1 flex flex-col">
                                        {{-- ไม่ต้องแสดง Category name อีก เพราะอยู่ใต้หัวข้อแล้ว --}}
                                        <h3 class="font-bold text-xl text-gray-900">
                                            <a href="{{ route('post.show', $post) }}"
                                                class="hover:text-tech-green-dark transition duration-150">
                                                {{ $post->title }}
                                            </a>
                                        </h3>
                                        <p class="mt-3 text-gray-600 text-sm flex-grow">
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

    {{-- (E-Service, Director, Departments, CTA Sections can remain or be removed as needed) --}}
    {{-- ... --}}

</x-public-layout>
