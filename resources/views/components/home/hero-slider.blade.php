@props(['featuredPosts'])

{{-- =========================================================
    SECTION 1: HERO SLIDER (Redesign: Full-Width)
========================================================== --}}
@if ($featuredPosts?->count())

    <section class="relative w-full py-2">

        <div class="swiper mySwiper h-[600px] lg:h-[750px] overflow-hidden relative group">

            <div class="swiper-wrapper">
                @foreach ($featuredPosts as $featured)
                    <div class="swiper-slide relative group">
                        <a href="{{ route('post.show', $featured) }}" class="block h-full">

                            <img src="{{ $featured->image_path ? Storage::url($featured->image_path) : asset('images/placeholder-large.jpg') }}"
                                alt="{{ $featured->title }}"
                                class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105" />

                            <div
                                class="absolute inset-x-0 bottom-0 bg-gradient-to-t from-black/90 via-black/60 to-transparent">

                                <div class="container mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-10 md:py-16 text-white">
                                    <span
                                        class="bg-tech-green/90 text-xs px-3 py-1 rounded-full uppercase tracking-wider">
                                        {{ $featured->category?->name ?? 'ข่าวสาร' }}
                                    </span>
                                    <h3 class="mt-3 text-2xl md:text-4xl font-bold line-clamp-2">{{ $featured->title }}
                                    </h3>
                                    <p class="mt-2 text-sm md:text-base text-gray-200 line-clamp-3 hidden sm:block">
                                        {{ Str::limit(strip_tags($featured->content), 120) }}
                                    </p>
                                    <span class="mt-4 inline-block text-xs text-gray-300">อ่านเพิ่มเติม →</span>
                                </div>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>

            <div
                class="swiper-button-prev absolute left-4 top-1/2 -translate-y-1/2 z-20 w-12 h-12 rounded-full bg-white/20 hover:bg-white/50 flex items-center justify-center transition-opacity opacity-0 group-hover:opacity-100">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5"
                    stroke="currentColor" class="w-6 h-6 text-white">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5" />
                </svg>
            </div>
            <div
                class="swiper-button-next absolute right-4 top-1/2 -translate-y-1/2 z-20 w-12 h-12 rounded-full bg-white/20 hover:bg-white/50 flex items-center justify-center transition-opacity opacity-0 group-hover:opacity-100">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5"
                    stroke="currentColor" class="w-6 h-6 text-white">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                </svg>
            </div>

            <div class="swiper-pagination !bottom-5 !left-1/2 !-translate-x-1/2 !w-auto z-10"></div>
        </div>

    </section>

    {{-- =========================================================
        SWIPER SCRIPTS (ไม่แก้ไข)
    ========================================================== --}}
    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                const swiper = new Swiper('.mySwiper', {
                    loop: true,
                    speed: 700,
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
                });
            });
        </script>
    @endpush
@endif
