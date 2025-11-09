@props(['featuredPosts'])

@unless ($featuredPosts->isEmpty())
    @push('styles')
        <style>
            /* Swiper Pagination ปรับให้ minimal & elegant */
            .hero-slider .swiper-pagination-bullet {
                width: 10px;
                height: 10px;
                background-color: rgba(255, 255, 255, 0.5);
                transition: all 0.3s;
            }

            .hero-slider .swiper-pagination-bullet-active {
                width: 28px;
                height: 10px;
                border-radius: 9999px;
                background-color: #22c55e;
                /* ใช้สีหลักของสถาบัน */
                opacity: 1;
            }

            /* overlay gradient smoother */
            .hero-slide-overlay {
                background: linear-gradient(to top, rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.3), transparent);
            }
        </style>
    @endpush

    <section class="relative w-full">
        <div class="swiper mySwiper h-[600px] hero-slider relative">

            <div class="swiper-wrapper">
                @foreach ($featuredPosts as $featured)
                    <div class="swiper-slide relative group">
                        <a href="{{ route('post.show', $featured) }}" class="block w-full h-full relative overflow-hidden">

                            {{-- Image --}}
                            <img src="{{ $featured->image_path ? Storage::url($featured->image_path) : asset('images/nopic.png') }}"
                                alt="{{ $featured->title }}"
                                class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105"
                                fetchpriority="high">

                            {{-- Overlay gradient + text --}}
                            <div class="absolute inset-0 hero-slide-overlay flex justify-center items-center">
                                <div class="text-center max-w-3xl px-4 text-white">
                                    <span class="bg-tech-green/90 text-xs px-3 py-1 rounded-full uppercase tracking-wider">
                                        {{ $featured->category?->name ?? 'ข่าวสาร' }}
                                    </span>
                                    <h3 class="mt-3 text-3xl sm:text-4xl font-bold line-clamp-2 drop-shadow-lg">
                                        {{ $featured->title }}
                                    </h3>
                                    <p class="mt-2 text-sm sm:text-base text-gray-200 line-clamp-3">
                                        {{ Str::limit(strip_tags($featured->content), 120) }}
                                    </p>
                                    <p class="mt-2 text-xs text-gray-300">
                                        {{ $featured->created_at?->format('d/m/Y') }}
                                    </p>
                                    <span class="inline-block mt-4 text-xs text-gray-300">อ่านเพิ่มเติม →</span>
                                </div>
                            </div>


                        </a>
                    </div>
                @endforeach
            </div>

            {{-- Navigation --}}
            <button
                class="swiper-button-prev absolute left-4 top-1/2 -translate-y-1/2 z-20 w-12 h-12 rounded-full bg-black/30 hover:bg-black/50 flex items-center justify-center transition-opacity opacity-0 group-hover:opacity-100">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24"
                    stroke-width="2.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5" />
                </svg>
            </button>
            <button
                class="swiper-button-next absolute right-4 top-1/2 -translate-y-1/2 z-20 w-12 h-12 rounded-full bg-black/30 hover:bg-black/50 flex items-center justify-center transition-opacity opacity-0 group-hover:opacity-100">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24"
                    stroke-width="2.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                </svg>
            </button>

            {{-- Pagination --}}
            <div class="swiper-pagination !bottom-5 !left-1/2 !-translate-x-1/2 !w-auto z-10"></div>
        </div>
    </section>


@endunless

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            new Swiper('.mySwiper', {
                loop: true,
                speed: 1000,
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
