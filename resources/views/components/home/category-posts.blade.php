@props(['categoriesWithPosts'])

@php
    /**
     * ---------------------------------------------------------
     * ตั้งค่าลำดับหมวดหมู่ที่จะแสดงผล
     * ---------------------------------------------------------
     */
    $mainOrder = [5, 1]; // Main Content: [5] ประกาศ, [1] กิจกรรม
    $sidebarOrder = [2, 4]; // Sidebar: [2] ข่าวประชาสัมพันธ์, [4] ITA

    /**
     * ---------------------------------------------------------
     * ฟังก์ชันช่วย: ใช้สำหรับเรียง Collection ตามลำดับที่กำหนด
     * ---------------------------------------------------------
     */
    $sortByOrder = function ($collection, $order) {
        return $collection->sortBy(fn($item) => array_search($item->id, $order));
    };

    /**
     * ---------------------------------------------------------
     * แยกหมวดหมู่หลักออกจากหมวดอื่น
     * ---------------------------------------------------------
     */
    [$mainCategories, $remainingCategories] = $categoriesWithPosts->partition(
        fn($category) => in_array($category->id, $mainOrder),
    );

    /**
     * ---------------------------------------------------------
     * แยกหมวด Sidebar ออกมา (เฉพาะที่เลือกไว้)
     * ---------------------------------------------------------
     */
    [$sidebarCategories, $otherCategories] = $remainingCategories->partition(
        fn($category) => in_array($category->id, $sidebarOrder),
    );

    /**
     * ---------------------------------------------------------
     * เรียงลำดับหมวดหมู่ให้ตรงตามที่กำหนด
     * ---------------------------------------------------------
     */
    $mainCategories = $sortByOrder($mainCategories, $mainOrder);
    $sidebarCategories = $sortByOrder($sidebarCategories, $sidebarOrder);
@endphp


<section class="py-16 bg-gray-50">
    <div class="container mx-auto max-w-7xl px-6 lg:px-12">

        <div class="flex flex-col lg:flex-row lg:space-x-12">

            {{-- ================= Main Content ================= --}}
            <div class="flex-1 space-y-8">
                @foreach ($mainCategories as $mainCategory)
                    <div
                        class="bg-white/90 backdrop-blur-sm rounded-3xl border border-gray-200 p-6 md:p-8 shadow-md hover:shadow-lg transition-shadow duration-300">
                        <div class="flex justify-between items-center mb-6">
                            <h2 class="text-2xl sm:text-3xl font-bold text-tech-slate-dark relative">
                                {{ $mainCategory->name }}
                                <span class="absolute bottom-[-6px] left-0 h-1 w-20 bg-tech-green rounded-full"></span>
                            </h2>
                            <a href="{{ route('category.show', $mainCategory) }}"
                                class="text-tech-green font-semibold flex items-center hover:underline group">
                                ดูทั้งหมด
                                <svg xmlns="http://www.w3.org/2000/svg"
                                    class="w-4 h-4 ml-1 transition-transform group-hover:translate-x-1" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                                </svg>
                            </a>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 md:gap-8">
                            @foreach ($mainCategory->posts as $post)
                                <x-post-card :post="$post" />
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- ================= Sidebar ================= --}}
            <aside class="lg:w-1/3 flex flex-col gap-8 mt-12 lg:mt-0">

                @foreach ($sidebarCategories as $category)
                    <div
                        class="bg-white/90 backdrop-blur-sm rounded-2xl p-4 md:p-6 shadow-sm hover:shadow-md transition-shadow duration-300">

                        {{-- Header --}}
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-lg md:text-xl font-bold text-tech-slate-dark">{{ $category->name }}</h3>
                            <a href="{{ route('category.show', $category) }}"
                                class="text-sm text-tech-green font-semibold hover:underline">
                                ดูทั้งหมด
                            </a>
                        </div>

                        {{-- List Post --}}
                        <ul class="space-y-3">
                            @foreach ($category->posts as $post)
                                <li>
                                    <a href="{{ route('post.show', $post) }}"
                                        class="flex items-center gap-3 hover:bg-gray-50 p-2 rounded-lg transition-colors duration-200">

                                        {{-- Thumbnail --}}
                                        <img src="{{ $post->image_path ? Storage::url($post->image_path) : asset('images/nopic.png') }}"
                                            alt="{{ $post->title }}"
                                            class="w-16 h-16 rounded-xl object-cover flex-shrink-0">

                                        {{-- Title & Date --}}
                                        <div class="flex-1">
                                            <p
                                                class="text-sm md:text-base font-medium line-clamp-2 text-gray-800 group-hover:text-tech-green">
                                                {{ $post->title }}
                                            </p>
                                            <span class="text-xs text-gray-500">
                                                {{ $post->created_at->format('d M Y') }}
                                            </span>
                                        </div>

                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endforeach

            </aside>


        </div>
    </div>

    <div class="container mx-auto max-w-7xl py-6 px-6 lg:px-12">
        <h2 class="text-2xl font-bold text-tech-slate-dark mb-6">
            หมวดหมู่ข่าวทั้งหมด
        </h2>
        <div class="flex flex-wrap gap-3">
            @foreach ($categoriesWithPosts as $category)
                <a href="{{ route('category.show', $category) }}"
                    class="inline-block bg-gray-100 hover:bg-tech-green hover:text-white text-gray-700 text-sm font-medium px-4 py-2 rounded-full transition-colors duration-200">
                    {{ $category->name }}
                </a>
            @endforeach
        </div>
    </div>
</section>
