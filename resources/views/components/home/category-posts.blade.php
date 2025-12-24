@props(['categoriesWithPosts'])

@php
    /**
     * 1. ตั้งค่าลำดับหมวดหมู่
     */
    $mainOrder = [5, 1];
    $sidebarOrder = [4]; // ITA

    $sortByOrder = function ($collection, $order) {
        return $collection->sortBy(fn($item) => array_search($item->id, $order));
    };

    /**
     * 2. ข้อมูลหน่วยงานที่เกี่ยวข้อง
     */
    $externalLinks = [
        ['name' => 'สำนักงานคณะกรรมการการอาชีวศึกษา', 'url' => 'https://vec.go.th/Default.aspx?tabid=55'],
        ['name' => 'กองบริหารงานบุคคล (HR-VEC)', 'url' => 'https://hr.vec.go.th/'],
        ['name' => 'สถาบันการอาชีวศึกษา (IPA)', 'url' => 'https://ipa.vec.go.th/'],
        ['name' => 'ศูนย์ความปลอดภัย (V-COP)', 'url' => 'https://v-cop.go.th/'],
    ];

    /**
     * 3. จัดการ Collection
     */
    $mainCategories = $categoriesWithPosts->filter(fn($c) => in_array($c->id, $mainOrder));
    $mainCategories = $sortByOrder($mainCategories, $mainOrder);

    $sidebarCategories = $categoriesWithPosts->filter(fn($c) => in_array($c->id, $sidebarOrder));
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
                <div class="bg-white/90 backdrop-blur-sm rounded-2xl p-6 shadow-sm border border-gray-100">
                    <h3 class="text-xl font-bold text-tech-slate-dark mb-5 flex items-center">
                        <span class="w-2 h-6 bg-tech-green rounded-full mr-3"></span>
                        หน่วยงานที่เกี่ยวข้อง
                    </h3>
                    <div class="grid grid-cols-1 gap-3">
                        @foreach ($externalLinks as $link)
                            <a href="{{ $link['url'] }}" target="_blank" rel="noopener"
                                class="flex items-center justify-between p-4 bg-gray-50 rounded-xl border border-transparent hover:border-tech-green hover:bg-white hover:shadow-md transition-all group">
                                <span
                                    class="text-sm font-semibold text-gray-700 group-hover:text-tech-green">{{ $link['name'] }}</span>
                                <svg xmlns="http://www.w3.org/2000/svg"
                                    class="w-4 h-4 text-gray-400 group-hover:text-tech-green transition-transform group-hover:translate-x-1"
                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                                </svg>
                            </a>
                        @endforeach
                    </div>
                </div>
                {{-- ITA (แบบมีรูป Thumbnail) --}}
                @foreach ($sidebarCategories as $category)
                    <div class="bg-white/90 backdrop-blur-sm rounded-2xl p-4 md:p-6 shadow-sm border border-gray-100">
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-lg md:text-xl font-bold text-tech-slate-dark">{{ $category->name }}</h3>
                            <a href="{{ route('category.show', $category) }}"
                                class="text-sm text-tech-green font-semibold hover:underline">
                                ดูทั้งหมด
                            </a>
                        </div>

                        <ul class="space-y-4">
                            @foreach ($category->posts->take(4) as $post)
                                <li>
                                    <a href="{{ route('post.show', $post) }}"
                                        class="flex items-center gap-3 hover:bg-gray-50 p-2 rounded-lg transition-all group">
                                        {{-- Thumbnail --}}
                                        <img src="{{ $post->image_path ? Storage::url($post->image_path) : asset('images/nopic.webp') }}"
                                            alt="{{ $post->title }}"
                                            class="w-16 h-16 rounded-xl object-cover flex-shrink-0 shadow-sm group-hover:ring-2 group-hover:ring-tech-green/30 transition-all">

                                        {{-- Title & Date --}}
                                        <div class="flex-1">
                                            <p
                                                class="text-sm font-medium line-clamp-2 text-gray-800 group-hover:text-tech-green transition-colors">
                                                {{ $post->title }}
                                            </p>
                                            <span class="text-xs text-gray-400 mt-1 block">
                                                {{ $post->created_at->format('d M Y') }}
                                            </span>
                                        </div>
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endforeach

                {{-- หน่วยงานที่เกี่ยวข้อง --}}


            </aside>
        </div>
    </div>
</section>
