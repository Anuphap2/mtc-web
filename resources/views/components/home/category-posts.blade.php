@props(['categoriesWithPosts'])

{{-- =========================================================
    SECTION 3: POSTS BY CATEGORY (Redesign: Minimal)
========================================================== --}}
<section class="py-16 bg-gray-50">
    <div class="container mx-auto max-w-7xl px-4 space-y-12">
        @foreach ($categoriesWithPosts as $category)
            <div class="bg-white rounded-3xl border border-gray-200 p-6 md:p-8 transition-all hover:border-gray-300/80">

                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl sm:text-3xl font-bold text-tech-slate-dark relative">
                        {{ $category->name }}
                        <span class="absolute bottom-[-6px] left-0 h-1 w-20 bg-tech-green rounded-full"></span>
                    </h2>
                    <a href="{{ route('category.show', $category) }}"
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

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    {{-- วนลูป Post โดยเรียกใช้ Post Card Component --}}
                    @foreach ($category->posts as $post)
                        <x-post-card :post="$post" />
                    @endforeach
                </div>
            </div>
        @endforeach
    </div>
</section>
