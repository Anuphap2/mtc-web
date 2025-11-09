<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="font-kanit">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'วิทยาลัยเทคนิคแม่สอด' }}</title>
    <meta name="description"
        content="วิทยาลัยเทคนิคแม่สอด แหล่งรวมข่าวสาร กิจกรรม และข้อมูลการศึกษา สำหรับนักเรียนและประชาชน">
    <meta name="keywords" content="วิทยาลัย, แม่สอด, การศึกษา, ข่าวสาร, กิจกรรม">
    <meta name="robots" content="index, follow">

    <!-- Open Graph -->
    <meta property="og:title" content="วิทยาลัยเทคนิคแม่สอด">
    <meta property="og:description" content="ข่าวสาร กิจกรรม และข้อมูลการศึกษา">
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:image" content="{{ asset('images/logo.png') }}">

    {{-- Google Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Kanit:wght@300;400;500;600;700&display=swap" rel="stylesheet">



    <link rel="preload" href="{{ asset('build/assets/app-B8F3QX7X.css') }}" as="style">
    <link rel="stylesheet" href="{{ asset('build/assets/app-B8F3QX7X.css') }}">
    <script src="{{ asset('build/assets/app-CXDpL9bK.js') }}" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js" defer></script>

    {{-- Tailwind + Vite --}}
    <link rel="stylesheet" href="{{ asset('build/assets/app-B8F3QX7X.css') }}">
    <script src="{{ asset('build/assets/app-CXDpL9bK.js') }}" defer></script>

    {{-- Swiper --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />

    {{-- Facebook SDK --}}
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
                        <img class="h-14 w-auto" src="{{ asset('images/logo.webp') }}" alt="Logo MTC" loading="lazy">
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

                {{-- Footer Content --}}
                <div class="grid grid-cols-1 md:grid-cols-4 gap-8">

                    {{-- ข้อมูลติดต่อ --}}
                    <div>
                        <h5 class="text-lg font-semibold text-white mb-3">ข้อมูลติดต่อ</h5>
                        <p class="text-sm"><i class="fas fa-map-marker-alt mr-1"></i> หมู่ที่ 10 ถนนสายแม่สอด-แม่ปะใต้
                            ตำบลแม่ปะ, Maesod, Tak 63110</p>
                        <p class="text-sm mt-1"><i class="fas fa-phone mr-1"></i> โทรศัพท์: 055-532-644</p>
                        <p class="text-sm mt-1"><i class="fas fa-fax mr-1"></i> โทรสาร: 055-532-644</p>
                        {{-- <p class="text-sm mt-1"><i class="fas fa-envelope mr-1"></i> อีเมล: example@email.com</p> --}}
                    </div>

                    {{-- ลิงค์หน่วยงานภายนอก --}}
                    <div>
                        <h5 class="text-lg font-semibold text-white mb-3">ลิงค์หน่วยงานภายนอก</h5>
                        <ul class="space-y-2 text-sm">
                            <li><a href="http://www.vec.go.th/" target="_blank"
                                    class="hover:text-white hover:underline">สำนักงานคณะกรรมการการอาชีวศึกษา</a></li>
                            <li><a href="http://www.vec.go.th/boga/%E0%B8%AB%E0%B8%99%E0%B9%89%E0%B8%B2%E0%B9%81%E0%B8%A3%E0%B8%81.aspx"
                                    target="_blank" class="hover:text-white hover:underline">สำนักอำนวยการ</a></li>
                            <li><a href="http://bpcd.vec.go.th/" target="_blank"
                                    class="hover:text-white hover:underline">สำนักพัฒนาสมรรถนะครูและบุคลากรอาชีวศึกษา</a>
                            </li>
                            <li><a href="https://www.studentloan.or.th/" target="_blank"
                                    class="hover:text-white hover:underline">กองทุนกู้ยืมเพื่อการศึกษา</a></li>
                        </ul>
                    </div>

                    {{-- ระบบงานออนไลน์ --}}
                    <div>
                        <h5 class="text-lg font-semibold text-white mb-3">ระบบงานออนไลน์</h5>
                        <ul class="space-y-2 text-sm">
                            <li><a href="/maesod/detailsnews?ids=202"
                                    class="hover:text-white hover:underline">ระบบรับสมัครนักเรียนนักศึกษาวิทยาลัยเทคนิคแม่สอด</a>
                            </li>
                            <li><a href="/maesod/detailsnews?ids=201"
                                    class="hover:text-white hover:underline">ระบบฐานข้อมูลอาชีวศึกษา</a></li>
                            <li><a href="/maesod/detailsnews?ids=200"
                                    class="hover:text-white hover:underline">ระบบติดตามผู้เรียนสำหรับครูและเจ้าหน้าที่</a>
                            </li>
                            <li><a href="/maesod/detailsnews?ids=199"
                                    class="hover:text-white hover:underline">ระบบติดตามผู้เรียนสำหรับนักเรียน/นักศึกษา</a>
                            </li>
                            <li><a href="/maesod/detailsnews?ids=198"
                                    class="hover:text-white hover:underline">ระบบติดตามผู้เรียนสำหรับผู้ปกครอง</a></li>
                        </ul>
                    </div>

                    {{-- อาชีวศึกษาจังหวัดตาก --}}
                    <div>
                        <h5 class="text-lg font-semibold text-white mb-3">อาชีวศึกษาจังหวัดตาก</h5>
                        <ul class="space-y-2 text-sm">
                            <li><a href="http://www.maesod.ac.th" target="_blank"
                                    class="hover:text-white hover:underline">วิทยาลัยเทคนิคแม่สอด</a></li>
                            <li><a href="http://www.taktc.ac.th/" target="_blank"
                                    class="hover:text-white hover:underline">วิทยาลัยเทคนิคตาก</a></li>
                            <li><a href="http://www.bantak.ac.th/" target="_blank"
                                    class="hover:text-white hover:underline">วิทยาลัยการอาชีพบ้านตาก</a></li>
                            <li><a href="http://www.kasettak.ac.th/" target="_blank"
                                    class="hover:text-white hover:underline">วิทยาลัยเกษตรและเทคโนโลยีตาก</a></li>
                        </ul>
                    </div>

                </div> {{-- End Footer Content --}}

                <hr class="border-gray-700 my-8">

                <div class="text-center text-sm">&copy; 2568 วิทยาลัยเทคนิคแม่สอด | สงวนลิขสิทธิ์ทุกประการ</div>

            </div>
        </footer>

    </div>
    <div id="fb-root"></div>

    {{-- Swiper JS --}}
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    @stack('scripts')
</body>

</html>
