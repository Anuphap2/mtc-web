<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="font-kanit">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? 'วิทยาลัยเทคนิคแม่สอด' }}</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Kanit:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <div id="fb-root"></div>
    <script async defer crossorigin="anonymous" src="https://connect.facebook.net/th_TH/sdk.js#xfbml=1&version=v18.0">
    </script>

    <style>
        body {
            font-family: 'Kanit', 'Figtree', sans-serif;
        }
    </style>
</head>

{{-- RE-DESIGN: ใช้พื้นหลังสีขาวสะอาดตา (bg-white) --}}

<body class="font-sans antialiased bg-white">
    <div class="min-h-screen flex flex-col">

        <header class="bg-white shadow-sm sticky top-0 z-50 border-b border-gray-200">
            <div class="container mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between items-center h-20">

                    {{-- 1. Logo --}}
                    <a href="{{ route('home') }}" class="flex items-center space-x-3">
                        <img class="h-14 w-auto" src="{{ asset('images/logo.png') }}" alt="Logo MTC">
                        <span class="font-bold text-lg text-tech-slate-dark">
                            วิทยาลัยเทคนิคแม่สอด
                        </span>
                    </a>

                    {{-- 2. Desktop Navigation --}}
                    <nav class="hidden md:flex space-x-1">
                        @isset($public_menus)
                            @foreach ($public_menus as $menu)
                                <a href="{{ url($menu->url) }}"
                                    class="px-4 py-2 text-sm font-medium text-gray-600 rounded-lg 
                                          hover:bg-tech-slate-light hover:text-tech-green-dark transition duration-200">
                                    {{ $menu->name }}
                                </a>
                            @endforeach
                        @else
                            <a href="{{ route('home') }}"
                                class="px-4 py-2 text-sm font-medium text-gray-600 rounded-lg 
                                          hover:bg-tech-slate-light hover:text-tech-green-dark transition duration-200">
                                หน้าหลัก
                            </a>
                        @endisset
                    </nav>

                    {{-- 3. Admin Login Button / Mobile Menu --}}
                    <div class="flex items-center space-x-2">
                        {{-- Admin Login (แสดงบน Desktop) --}}
                        <a href="{{ route('login') }}"
                            class="hidden md:inline-flex items-center px-4 py-2 text-sm font-medium text-tech-green-dark 
                                  bg-white border border-tech-green rounded-lg 
                                  hover:bg-tech-green hover:text-white transition duration-200">
                            เข้าสู่ระบบ
                        </a>

                        {{-- Mobile Menu Button (แสดงบน Mobile) --}}
                        <button class="md:hidden text-gray-700 p-2 rounded-md hover:bg-tech-slate-light">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 6h16M4 12h16m-7 6h7"></path>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        </header>
        <main class="flex-grow">
            {{-- เราจะปล่อย $slot ให้โล่ง เพื่อให้ home.blade สร้าง layout เอง --}}
            {{ $slot }}
        </main>


        {{-- RE-DESIGN: Footer สไตล์มินิมอล เทาเข้ม --}}
        <footer class="bg-tech-slate-dark text-gray-400">
            <div class="container mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-12">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                    {{-- Column 1: About --}}
                    <div class="md:col-span-2">
                        <h5 class="text-lg font-semibold text-white mb-3">วิทยาลัยเทคนิคแม่สอด</h5>
                        <p class="text-sm">
                            เลขที่ 133 หมู่ 8 ถนนแม่สอด-แม่ระมาด ต.แม่ปะ อ.แม่สอด จ.ตาก 63110
                        </p>
                        <p class="text-sm mt-2">โทร: 055-531-180 | อีเมล: maesot.tec@ms.vec.go.th</p>
                    </div>

                    {{-- Column 2 & 3: Links (ตัวอย่าง) --}}
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
                <div class="text-center text-sm">
                    &copy; {{ date('Y') }} วิทยาลัยเทคนิคแม่สอด. สงวนลิขสิทธิ์.
                </div>
            </div>
        </footer>
    </div>
</body>

</html>
