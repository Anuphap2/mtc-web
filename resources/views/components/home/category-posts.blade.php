@props(['categoriesWithPosts'])

@php
    // แยก "กิจกรรมและประชาสัมพันธ์" ออกจากหมวดหมู่อื่นๆ
    [$prCollection, $otherCategories] = $categoriesWithPosts->partition(function ($category) {
        return $category->name === 'กิจกรรมและประชาสัมพันธ์';
    });

    $prCategory = $prCollection->first();
@endphp

<section class="py-16 bg-gray-50">
    <div class="container mx-auto max-w-7xl px-6 lg:px-12">

        {{-- Flex หลัก: มือถือ ซ้อนกัน, Desktop ข้างกัน --}}
        <div class="flex flex-col lg:flex-row lg:space-x-12">

            {{-- ================= Main Content ================= --}}
            <div class="flex-1 space-y-12">
                @if ($prCategory)
                    <div
                        class="bg-white rounded-3xl border border-gray-200 p-6 md:p-8 transition-all hover:border-gray-300/80">
                        {{-- Header --}}
                        <div class="flex justify-between items-center mb-6">
                            <h2 class="text-2xl sm:text-3xl font-bold text-tech-slate-dark relative">
                                {{ $prCategory->name }}
                                <span class="absolute bottom-[-6px] left-0 h-1 w-20 bg-tech-green rounded-full"></span>
                            </h2>
                            <a href="{{ route('category.show', $prCategory) }}"
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

                        {{-- Grid Post Card --}}
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                            @foreach ($prCategory->posts as $post)
                                <x-post-card :post="$post" />
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>

            {{-- ================= Sidebar ================= --}}
            <div class="lg:w-1/3 flex flex-col space-y-12 mt-12 lg:mt-0">
                @foreach ($otherCategories as $category)
                    <div>
                        <div class="flex justify-between items-center mb-4">
                            <h2 class="text-xl font-bold text-tech-slate-dark">{{ $category->name }}</h2>
                            <a href="{{ route('category.show', $category) }}"
                                class="text-sm text-tech-green font-semibold hover:underline">
                                ดูทั้งหมด
                            </a>
                        </div>
                        <ul class="space-y-4">
                            @foreach ($category->posts as $post)
                                <li>
                                    <a href="{{ route('post.show', $post) }}"
                                        class="flex items-center group space-x-3 hover:text-tech-green transition-colors">
                                        <img src="{{ $post->image_path ? Storage::url($post->image_path) : asset('images/placeholder.jpg') }}"
                                            alt="{{ $post->title }}"
                                            class="w-16 h-16 rounded-xl object-cover flex-shrink-0">
                                        <div>
                                            <p class="text-base font-medium line-clamp-2">{{ $post->title }}</p>
                                            <span
                                                class="text-sm text-gray-500">{{ $post->created_at->format('d M Y') }}</span>
                                        </div>
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endforeach
            </div>


        </div>
    </div>
</section>
