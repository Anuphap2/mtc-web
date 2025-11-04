<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="font-kanit">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'วิทยาลัยเทคนิคแม่สอด' }}</title>

    {{-- Google Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Kanit:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    {{-- Tailwind + Vite --}}
    <link rel="stylesheet" href="{{ asset('build/assets/app-B8F3QX7X.css') }}">
    <script src="{{ asset('build/assets/app-CXDpL9bK.js') }}" defer></script>

    {{-- Swiper --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />

    {{-- Facebook SDK --}}
    <div id="fb-root"></div>
    <script async defer crossorigin="anonymous" src="https://connect.facebook.net/th_TH/sdk.js#xfbml=1&version=v18.0">
    </script>

    <style>
        body {
            font-family: 'Kanit', 'Figtree', sans-serif;
        }

        /* [ปรับปรุง] เพิ่มสไตล์สำหรับ .swiper-pagination ที่ใช้งานบ่อย */
        .swiper-pagination-bullet-active {
            background-color: #00A96E !important;
            /* สี tech-green */
        }
    </style>

    @stack('styles')
</head>

<body class="bg-gray-50 text-gray-700">
    <div class="min-h-screen flex flex-col">

        {{-- [ปรับปรุง] 1. เพิ่ม x-data="{ mobileOpen: false }" เพื่อควบคุมเมนูมือถือ --}}
        <header x-data="{ mobileOpen: false }" class="bg-white shadow-sm sticky top-0 z-50 border-b border-gray-200">
            <div class="container mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between items-center h-20">
                    {{-- Logo --}}
                    <a href="{{ route('home') }}" class="flex items-center space-x-3">
                        <img class="h-14 w-auto" src="{{ asset('images/logo.png') }}" alt="Logo MTC">
                        <span class="font-bold text-lg text-tech-slate-dark">วิทยาลัยเทคนิคแม่สอด</span>
                    </a>

                    {{-- Desktop Navigation --}}
                    <nav class="hidden md:flex space-x-2 items-center">
                        @isset($public_menus)
                            @foreach ($public_menus as $menu)
                                @if ($menu->children->isEmpty())
                                    {{-- [ปรับปรุง] 2. เพิ่มเงื่อนไข Active State (ไฮไลท์เมนูปัจจุบัน) --}}
                                    <a href="{{ url($menu->url) }}"
                                        class="px-4 py-2 text-sm font-medium rounded-lg transition
                                        {{ request()->is(ltrim($menu->url, '/'))
                                            ? 'bg-tech-green/10 text-tech-green-dark font-semibold'
                                            : 'text-gray-600 hover:bg-tech-slate-light hover:text-tech-green-dark' }}">
                                        {{ $menu->name }}
                                    </a>
                                @else
                                    {{-- [ปรับปรุง] 3. เช็ค Active State สำหรับ Dropdown (ถ้ามีเมนูลูก active) --}}
                                    @php
                                        $isDropdownActive = $menu->children->contains(
                                            fn($child) => request()->is(ltrim($child->url, '/')),
                                        );
                                    @endphp
                                    <div x-data="{ open: false }" class="relative">
                                        <button @click="open = !open" @click.away="open = false"
                                            class="flex items-center px-4 py-2 text-sm font-medium rounded-lg transition
                                            {{ $isDropdownActive
                                                ? 'bg-tech-green/10 text-tech-green-dark font-semibold'
                                                : 'text-gray-600 hover:bg-tech-slate-light hover:text-tech-green-dark' }}">
                                            {{ $menu->name }}
                                            <svg class="w-4 h-4 ml-1" fill="currentColor" viewBox="0 0 20 20"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <path fill-rule="evenodd"
                                                    d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                                    clip-rule="evenodd"></path>
                                            </svg>
                                        </button>
                                        <div x-show="open" x-transition:enter="transition ease-out duration-100"
                                            x-transition:enter-start="transform opacity-0 scale-95"
                                            x-transition:enter-end="transform opacity-100 scale-100"
                                            x-transition:leave="transition ease-in duration-75"
                                            x-transition:leave-start="transform opacity-100 scale-100"
                                            x-transition:leave-end="transform opacity-0 scale-95"
                                            class="absolute left-0 mt-2 w-56 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 z-40 origin-top-left"
                                            style="display: none;">
                                            <div class="py-1">
                                                @foreach ($menu->children as $child)
                                                    <a href="{{ url($child->url) }}"
                                                        class="block px-4 py-2 text-sm
                                                        {{ request()->is(ltrim($child->url, '/')) ? 'text-tech-green-dark font-semibold' : 'text-gray-700' }}
                                                        hover:bg-gray-100 hover:text-tech-green-dark">
                                                        {{ $child->name }}
                                                    </a>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        @else
                            <a href="{{ route('home') }}"
                                class="px-4 py-2 text-sm font-medium text-gray-600 rounded-lg
                                hover:bg-tech-slate-light hover:text-tech-green-dark transition">หน้าหลัก</a>
                        @endisset
                    </nav>

                    {{-- [ปรับปรุง] 4. เพิ่มปุ่ม Hamburger สำหรับ Mobile --}}
                    <div class="md:hidden">
                        <button @click="mobileOpen = true"
                            class="text-gray-600 hover:text-tech-green-dark p-2 rounded-md">
                            <span class="sr-only">เปิดเมนู</span>
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 6h16M4 12h16m-7 6h7"></path>
                            </svg>
                        </button>
                    </div>

                </div>
            </div>

            {{-- [ปรับปรุง] 5. เพิ่มแผงเมนูสำหรับ Mobile (Fullscreen) --}}
            <div x-show="mobileOpen" x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 transform -translate-x-full"
                x-transition:enter-end="opacity-100 transform translate-x-0"
                x-transition:leave="transition ease-in duration-200"
                x-transition:leave-start="opacity-100 transform translate-x-0"
                x-transition:leave-end="opacity-0 transform -translate-x-full"
                class="fixed inset-0 z-[100] bg-white p-6 md:hidden" style="display: none;">

                {{-- Mobile Menu Header (Logo + Close Button) --}}
                <div class="flex justify-between items-center mb-8">
                    <a href="{{ route('home') }}" class="flex items-center space-x-3">
                        <img class="h-12 w-auto" src="{{ asset('images/logo.png') }}" alt="Logo MTC">
                        <span class="font-bold text-base text-tech-slate-dark">วิทยาลัยเทคนิคแม่สอด</span>
                    </a>
                    <button @click="mobileOpen = false" class="text-gray-500 hover:text-tech-green-dark p-2">
                        <span class="sr-only">ปิดเมนู</span>
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>

                {{-- Mobile Menu Links --}}
                <nav class="flex flex-col space-y-2">
                    @isset($public_menus)
                        @foreach ($public_menus as $menu)
                            @if ($menu->children->isEmpty())
                                <a href="{{ url($menu->url) }}"
                                    class="block px-4 py-3 text-base rounded-lg
                                    {{ request()->is(ltrim($menu->url, '/'))
                                        ? 'bg-tech-green/10 text-tech-green-dark font-semibold'
                                        : 'text-gray-700 hover:bg-tech-slate-light' }}">
                                    {{ $menu->name }}
                                </a>
                            @else
                                <div x-data="{ open: false }">
                                    <button @click="open = !open"
                                        class="flex justify-between items-center w-full px-4 py-3 text-base text-left rounded-lg text-gray-700 hover:bg-tech-slate-light">
                                        <span>{{ $menu->name }}</span>
                                        <svg class="w-5 h-5 transition-transform" :class="{ 'rotate-180': open }"
                                            fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                                clip-rule="evenodd"></path>
                                        </svg>
                                    </button>
                                    <div x-show="open" x-transition
                                        class="mt-2 space-y-1 pl-6 border-l-2 border-tech-green/50 ml-4">
                                        @foreach ($menu->children as $child)
                                            <a href="{{ url($child->url) }}"
                                                class="block px-4 py-2 text-sm rounded-md
                                                {{ request()->is(ltrim($child->url, '/'))
                                                    ? 'text-tech-green-dark font-semibold'
                                                    : 'text-gray-600 hover:bg-tech-slate-light/50' }}">
                                                {{ $child->name }}
                                            </a>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    @endisset
                </nav>
            </div>
        </header>

        {{-- Main Content --}}
        <main class="flex-grow">
            {{ $slot }}
        </main>

        {{-- Footer --}}
        <footer class="bg-tech-slate-dark text-gray-300 mt-8">
            <div class="container mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-12">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                    <div class="md:col-span-2">
                        <h5 class="text-lg font-semibold text-white mb-3">วิทยาลัยเทคนิคแม่สอด</h5>
                        <p class="text-sm">เลขที่ 133 หมู่ 8 ถนนแม่สอด-แม่ระมาด ต.แม่ปะ อ.แม่สอด จ.ตาก 63110</p>
                        <p class="text-sm mt-2">โทร: 055-531-180 | อีเมล: maesot.tec@ms.vec.go.th</p>

                        {{-- [ปรับปรุง] 6. เพิ่ม Social Icons --}}
                        <div class="flex space-x-4 mt-6">
                            <a href="https://www.facebook.com/MTC.Maesot" target="_blank" rel="noopener"
                                class="text-gray-400 hover:text-white transition-colors" title="Facebook">
                                <span class="sr-only">Facebook</span>
                                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M12 2.04C6.5 2.04 2 6.53 2 12.06C2 17.06 5.66 21.21 10.44 21.96V14.96H7.9V12.06H10.44V9.81C10.44 7.31 11.93 5.96 14.22 5.96C15.31 5.96 16.45 6.15 16.45 6.15V8.62H15.19C13.95 8.62 13.56 9.39 13.56 10.18V12.06H16.34L15.89 14.96H13.56V21.96C18.34 21.21 22 17.06 22 12.06C22 6.53 17.5 2.04 12 2.04Z">
                                    </path>
                                </svg>
                            </a>
                            <a href="https://www.youtube.com/@mtcchannel134" target="_blank" rel="noopener"
                                class="text-gray-400 hover:text-white transition-colors" title="YouTube">
                                <span class="sr-only">YouTube</span>
                                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136C4.495 20.455 12 20.455 12 20.455s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z">
                                    </path>
                                </svg>
                            </a>
                        </div>
                    </div>
                    <div>
                        <h5 class="text-base font-semibold text-gray-200 mb-3">เกี่ยวกับ</h5>
                        <ul class="space-y-2 text-sm">
                            <li><a href="#" class="hover:text-white hover:underline">ประวัติ</a></li>
                            <li><a href="#" class="hover:text-white hover:underline">ติดต่อเรา</a></li>
                        </ul>
                    </div>
                    <div>
                        <h5 class="text-base font-semibold text-gray-200 mb-3">หลักสูตร</h5>
                        <ul class="space-y-2 text-sm">
                            <li><a href="#" class="hover:text-white hover:underline">ปวช.</a></li>
                            <li><a href="#" class="hover:text-white hover:underline">ปวส.</a></li>
                        </ul>
                    </div>
                </div>
                <hr class="border-gray-700 my-8">
                <div class="text-center text-sm">&copy; {{ date('Y') }} วิทยาลัยเทคนิคแม่สอด. สงวนลิขสิทธิ์.</div>
            </div>
        </footer>
    </div>

    {{-- Swiper JS --}}
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    @stack('scripts')
</body>

</html>
