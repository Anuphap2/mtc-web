@props(['featuredPosts'])

{{-- =========================================================
    SECTION 1: HERO SLIDER (Full-Width)
========================================================== --}}
@unless ($featuredPosts->isEmpty())

    {{-- 
        COMMENT: เพิ่ม CSS สำหรับแต่ง Pagination
        เราใช้ @push('styles') เพื่อส่ง style ไปยัง @stack('styles') ใน layout หลัก
        ถ้าไม่มี สามารถใช้ <style>...</style> ธรรมดาได้ครับ
    --}}
    @push('styles')
        <style>
            .hero-slider .swiper-pagination-bullet {
                width: 8px;
                height: 8px;
                background-color: #fff;
                opacity: 0.5;
                transition: all 0.3s ease;
            }

            .hero-slider .swiper-pagination-bullet-active {
                width: 24px;
                border-radius: 99px;
                opacity: 1;
            }
        </style>
    @endpush

    <section class="relative w-full">
        <div class="swiper mySwiper h-[600px] overflow-hidden relative group hero-slider">

            <div class="swiper-wrapper">
                @foreach ($featuredPosts as $featured)
                    <div class="swiper-slide relative">
                        <a href="{{ route('post.show', $featured) }}"
                            class="block h-full w-full relative overflow-hidden group">

                            {{-- wrapper ครอบรูป ให้สูงเท่ากับ container --}}
                            <div class="w-full h-[600px] overflow-hidden">
                                <img src="{{ $featured->image_path ? Storage::url($featured->image_path) : asset('images/placeholder-large.jpg') }}"
                                    alt="{{ $featured->title }}"
                                    class="w-full h-full object-cover transition-transform duration-700 " />
                            </div>

                            {{-- gradient overlay --}}
                            <div
                                class="absolute inset-x-0 bottom-0 bg-gradient-to-t from-black/90 via-black/60 to-transparent">
                                <div class="container mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-10 md:py-16 text-white">
                                    <span class="bg-tech-green/90 text-xs px-3 py-1 rounded-full uppercase tracking-wider">
                                        {{ $featured->category?->name ?? 'ข่าวสาร' }}
                                    </span>
                                    <h3 class="mt-3 text-2xl md:text-4xl font-bold line-clamp-2">
                                        {{ $featured->title }}
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

            {{-- navigation --}}
            <button type="button"
                class="swiper-button-prev absolute left-4 top-1/2 -translate-y-1/2 z-20 w-12 h-12 rounded-full bg-black/20 hover:bg-black/50 backdrop-blur-sm flex items-center justify-center transition-opacity opacity-0 group-hover:opacity-100"
                aria-label="Previous slide">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5"
                    stroke="currentColor" class="w-6 h-6 text-white" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5" />
                </svg>
            </button>
            <button type="button"
                class="swiper-button-next absolute right-4 top-1/2 -translate-y-1/2 z-20 w-12 h-12 rounded-full bg-black/20 hover:bg-black/50 backdrop-blur-sm flex items-center justify-center transition-opacity opacity-0 group-hover:opacity-100"
                aria-label="Next slide">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5"
                    stroke="currentColor" class="w-6 h-6 text-white" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                </svg>
            </button>

            {{-- pagination --}}
            <div class="swiper-pagination !bottom-5 !left-1/2 !-translate-x-1/2 !w-auto z-10"></div>
        </div>
    </section>


@endunless

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            new Swiper('.mySwiper', {
                loop: true,
                speed: 1000, // CHANGED: ปรับความเร็ว transition

                // CHANGED: เพิ่ม effect fade
                effect: 'fade',
                fadeEffect: {
                    crossFade: true
                },

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
