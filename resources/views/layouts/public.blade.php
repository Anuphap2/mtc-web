<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="font-kanit">

<head>
    {{-- (Head content remains the same) --}}
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
                    {{-- --- UPDATED Dropdown Logic --- --}}
                    <nav class="hidden md:flex space-x-1 items-center">
                        @isset($public_menus)
                            @foreach ($public_menus as $menu)
                                {{-- Check if the menu has children --}}
                                @if ($menu->children->isEmpty())
                                    {{-- 2.1 No Children: Render as a simple link --}}
                                    <a href="{{ url($menu->url) }}"
                                        class="px-4 py-2 text-sm font-medium text-gray-600 rounded-lg
                                              hover:bg-tech-slate-light hover:text-tech-green-dark transition duration-200">
                                        {{ $menu->name }}
                                    </a>
                                @else
                                    {{-- 2.2 Has Children: Render as a dropdown --}}
                                    <div x-data="{ open: false }" class="relative">
                                        {{-- Dropdown Trigger Button --}}
                                        <button @click="open = !open" @click.away="open = false"
                                            class="flex items-center px-4 py-2 text-sm font-medium text-gray-600 rounded-lg
                                                       hover:bg-tech-slate-light hover:text-tech-green-dark transition duration-200 focus:outline-none">
                                            <span>{{ $menu->name }}</span>
                                            <svg class="w-4 h-4 ml-1" fill="currentColor" viewBox="0 0 20 20"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <path fill-rule="evenodd"
                                                    d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                                    clip-rule="evenodd"></path>
                                            </svg>
                                        </button>

                                        {{-- Dropdown Panel --}}
                                        <div x-show="open" x-transition:enter="transition ease-out duration-100"
                                            x-transition:enter-start="transform opacity-0 scale-95"
                                            x-transition:enter-end="transform opacity-100 scale-100"
                                            x-transition:leave="transition ease-in duration-75"
                                            x-transition:leave-start="transform opacity-100 scale-100"
                                            x-transition:leave-end="transform opacity-0 scale-95"
                                            class="absolute left-0 mt-2 w-56 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 z-40 origin-top-left"
                                            style="display: none;">
                                            <div class="py-1">
                                                {{-- Loop through children --}}
                                                @foreach ($menu->children as $child)
                                                    <a href="{{ url($child->url) }}"
                                                        class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-tech-green-dark">
                                                        {{ $child->name }}
                                                    </a>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        @else
                            {{-- Fallback if $public_menus is not set --}}
                            <a href="{{ route('home') }}"
                                class="px-4 py-2 text-sm font-medium text-gray-600 rounded-lg
                                          hover:bg-tech-slate-light hover:text-tech-green-dark transition duration-200">
                                หน้าหลัก
                            </a>
                        @endisset
                    </nav>
                    {{-- --- END UPDATED Dropdown Logic --- --}}


                </div>
            </div>
        </header>

        {{-- Main Content --}}
        <main class="flex-grow">
            {{ $slot }}
        </main>

        {{-- Footer --}}
        <footer class="bg-tech-slate-dark text-gray-400">
            <div class="container mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-12">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                    <div class="md:col-span-2">
                        <h5 class="text-lg font-semibold text-white mb-3">วิทยาลัยเทคนิคแม่สอด</h5>
                        <p class="text-sm">
                            เลขที่ 133 หมู่ 8 ถนนแม่สอด-แม่ระมาด ต.แม่ปะ อ.แม่สอด จ.ตาก 63110
                        </p>
                        <p class="text-sm mt-2">โทร: 055-531-180 | อีเมล: maesot.tec@ms.vec.go.th</p>
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
                <div class="text-center text-sm">
                    &copy; {{ date('Y') }} วิทยาลัยเทคนิคแม่สอด. สงวนลิขสิทธิ์.
                </div>
            </div>
        </footer>
    </div>
</body>

</html>
