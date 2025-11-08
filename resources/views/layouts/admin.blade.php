<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full font-kanit">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Admin - {{ config('app.name', 'Laravel') }}</title>

    {{-- Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Kanit:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    {{-- DataTables --}}
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.dataTables.min.css">

    {{-- Quill Editor --}}
    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
    <script src="https://cdn.quilljs.com/1.3.6/quill.min.js"></script>

    {{-- Tailwind / App CSS --}}
    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

    <link rel="stylesheet" href="{{ asset('build/assets/app-B8F3QX7X.css') }}">
    <script src="{{ asset('build/assets/app-CXDpL9bK.js') }}" defer></script>

    <style>
        body {
            font-family: 'Kanit', sans-serif;
        }

        /* Sidebar */
        .sidebar-active {
            background-color: #00A96E;
            color: #fff;
        }

        .sidebar-active svg {
            color: #fff;
        }

        .sidebar-inactive:hover {
            background-color: #f3f4f6;
            color: #1f2937;
        }

        .sidebar-inactive:hover svg {
            color: #00A96E;
        }

        /* DataTables */
        .dataTables_wrapper select,
        .dataTables_wrapper input {
            @apply bg-white border border-gray-300 rounded-md shadow-sm px-3 py-2 focus:ring-2 focus:ring-tech-green focus:border-tech-green;
        }

        .dataTables_wrapper .paginate_button {
            @apply px-4 py-2 mx-1 rounded-md text-sm border border-gray-300 bg-white hover:bg-gray-100;
        }

        .dataTables_wrapper .paginate_button.current {
            @apply bg-tech-green text-white border-tech-green shadow-sm;
        }

        .dataTables_wrapper .paginate_button.disabled {
            @apply opacity-50 cursor-not-allowed;
        }
    </style>

    @stack('styles')
</head>

<body class="h-full antialiased bg-gray-100">

    @php
        $sidebarMenu = [
            [
                'title' => 'Dashboard',
                'route' => 'dashboard',
                'icon' =>
                    'M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1V9a1 1 0 011-1h2a1 1 0 011 1v10a1 1 0 001 1h3a1 1 0 001-1V9a1 1 0 01-1-1h-2a1 1 0 01-1-1V3z',
            ],
            [
                'title' => 'จัดการเมนู',
                'route' => 'admin.menus.index',
                'icon' => 'M4 6h16M4 12h16M4 18h16',
            ],
            [
                'title' => 'จัดการประเภทข่าว',
                'route' => 'admin.categories.index',
                'icon' =>
                    'M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10',
            ],
            [
                'title' => 'จัดการข่าวสาร',
                'route' => 'admin.posts.index',
                'icon' =>
                    'M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h7l2 2h5a2 2 0 012 2v10a2 2 0 01-2 2zM15 11a3 3 0 11-6 0 3 3 0 016 0z',
            ],
            [
                'title' => 'ผู้อำนวยการ',
                'route' => 'admin.director.edit',
                'icon' => 'M12 4.354a4 4 0 110 5.292M8 20h8a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2z',
            ],
            [
                'title' => 'จัดการผู้ใช้',
                'route' => 'admin.users.index',
                'icon' => 'M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z',
            ],
        ];
    @endphp

    <div x-data="{ sidebarOpen: true }" class="flex h-screen">

        {{-- Sidebar --}}
        <aside :class="sidebarOpen ? 'w-64' : 'w-16'"
            class="bg-white shadow-lg h-full transition-all duration-300 flex flex-col relative">

            {{-- Logo + Toggle --}}
            <div class="flex items-center justify-between h-16 px-4 border-b border-gray-200">

                <button @click="sidebarOpen = !sidebarOpen"
                    class="p-2 bg-gray-200 rounded-full hover:bg-gray-300 shadow">
                    <svg x-show="sidebarOpen" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                    <svg x-show="!sidebarOpen" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
            </div>

            {{-- Menu Items --}}
            <nav class="flex-1 flex flex-col mt-2">
                @foreach ($sidebarMenu as $item)
                    @php $isActive = request()->routeIs($item['route']); @endphp
                    <a href="{{ route($item['route']) }}"
                        class="flex items-center px-4 py-3 mx-2 my-1 rounded-lg transition-colors duration-200
                          {{ $isActive ? 'sidebar-active' : 'sidebar-inactive' }}">
                        <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="{{ $item['icon'] }}" />
                        </svg>
                        <span x-show="sidebarOpen" class="whitespace-nowrap">{{ $item['title'] }}</span>
                    </a>
                @endforeach
            </nav>

            {{-- User Info + Logout --}}
            <div class="px-4 py-4 border-t border-gray-200 flex-shrink-0">
                <div class="flex items-center mb-3">
                    <img class="h-8 w-8 rounded-full object-cover mr-2"
                        src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name ?? 'U') }}&color=7F9CF5&background=EBF4FF"
                        alt="{{ Auth::user()->name ?? 'User' }}">
                    <div x-show="sidebarOpen" class="text-sm font-medium text-gray-700 truncate">
                        {{ Auth::user()->name ?? 'User' }}</div>
                </div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                        class="w-full flex items-center justify-center px-4 py-2 text-sm font-medium text-gray-600 rounded-lg hover:bg-gray-100 hover:text-gray-800 transition">
                        <i class="fas fa-sign-out-alt w-5 h-5 mr-2 text-gray-400"></i>
                        <span x-show="sidebarOpen">ออกจากระบบ</span>
                    </button>
                </form>
            </div>
        </aside>

        {{-- Main Content --}}
        <main class="flex-1 overflow-y-auto p-6 md:p-10"> {{-- Add Padding here --}}
            <div class="container mx-auto max-w-7xl"> {{-- Container for content --}}

                {{-- Page Title & Add Button (If needed) --}}
                <div class="mb-6 flex flex-wrap justify-between items-center gap-4">
                    <h1 class="text-2xl font-semibold text-gray-800 leading-tight">
                        {{ $title ?? 'Admin' }} {{-- Use $title prop --}}
                    </h1>
                    {{-- Display Add Button if provided --}}
                    @isset($addButton)
                        @if (is_array($addButton) && isset($addButton['href']) && isset($addButton['label']))
                            <a href="{{ $addButton['href'] }}" class="flex-shrink-0">
                                <x-primary-button>
                                    <i class="fas fa-plus mr-2 -ml-1"></i>
                                    {{ $addButton['label'] }}
                                </x-primary-button>
                            </a>
                        @endif
                    @endisset
                </div>


                {{-- Flash Messages --}}
                @if (session('success'))
                    <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)" x-transition
                        class="mb-6 bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded-md shadow-sm flex justify-between items-center"
                        role="alert">
                        <span>{{ session('success') }}</span>
                        <button @click="show = false" class="text-green-600 hover:text-green-800">&times;</button>
                    </div>
                @endif
                @if (session('error'))
                    <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)" x-transition
                        class="mb-6 bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded-md shadow-sm flex justify-between items-center"
                        role="alert">
                        <span>{{ session('error') }}</span>
                        <button @click="show = false" class="text-red-600 hover:text-red-800">&times;</button>
                    </div>
                @endif

                {{-- Main Slot Content --}}
                {{ $slot }}

            </div>
        </main>
    </div>




    {{-- JS --}}
    <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>

    @stack('scripts')
</body>

</html>
