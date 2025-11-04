<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="font-kanit h-full bg-gray-100">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Admin - {{ config('app.name', 'Laravel') }}</title>

    {{-- Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Kanit:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    {{-- DataTables CSS --}}
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.dataTables.min.css">
    {{-- Font Awesome (Optional, for icons) --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
    <script src="https://cdn.quilljs.com/1.3.6/quill.min.js"></script>


    {{-- Vite Assets --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            font-family: 'Kanit', sans-serif;
        }

        /* DataTables Tailwind-like Styling */
        .dataTables_wrapper .dataTables_length select,
        .dataTables_wrapper .dataTables_filter input {
            @apply bg-white border border-gray-300 rounded-md shadow-sm py-2 px-3 text-sm focus:border-indigo-500 focus:ring-indigo-500;
        }

        .dataTables_wrapper .dataTables_length,
        .dataTables_wrapper .dataTables_filter {
            margin-bottom: 1.5rem;
        }

        .dataTables_wrapper .dataTables_info,
        .dataTables_wrapper .dataTables_paginate {
            margin-top: 1.5rem;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button {
            @apply px-4 py-2 mx-1 rounded-md text-sm border border-gray-300 bg-white hover:bg-gray-100;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button.current {
            @apply bg-tech-green text-white shadow-sm border-tech-green;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button.disabled {
            @apply opacity-50 cursor-not-allowed;
        }

        table.dataTable.dtr-inline.collapsed>tbody>tr>td.dtr-control:before {
            background-color: #00A96E;
            /* tech-green */
        }

        /* Responsive icon color */

        /* Active Sidebar Link Style */
        .sidebar-active {
            background-color: #00A96E;
            color: white;
        }

        .sidebar-active svg {
            color: white;
        }

        .sidebar-inactive:hover {
            background-color: #f3f4f6;
            /* gray-100 */
            color: #1f2937;
            /* gray-800 */
        }

        .sidebar-inactive:hover svg {
            color: #00A96E;
            /* tech-green */
        }
    </style>
    @stack('styles')
</head>

<body class="font-sans antialiased h-full">

    <div x-data="{ sidebarOpen: false }" @keydown.escape="sidebarOpen = false" class="flex h-screen bg-gray-100">
        {{-- Use h-screen --}}

        {{-- Sidebar Menu Array (Keep as is) --}}
        @php
            $sidebarMenu = [
                [
                    'title' => 'Dashboard',
                    'route' => 'dashboard',
                    'icon' =>
                        'M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1V9a1 1 0 011-1h2a1 1 0 011 1v10a1 1 0 001 1h3a1 1 0 001-1V9a1 1 0 01-1-1h-2a1 1 0 01-1-1V3z',
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
                        'M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 12h6M7 8h6',
                ],
                ['title' => 'จัดการเมนู', 'route' => 'admin.menus.index', 'icon' => 'M4 6h16M4 12h16M4 18h16'],
                [
                    'title' => 'จัดการข้อมูลผู้อำนวยการ',
                    'route' => 'admin.director.edit',
                    'icon' =>
                        'M12 12c2.21 0 4-1.79 4-4S14.21 4 12 4 8 5.79 8 8s1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z',
                ],
                [
                    'title' => 'จัดการผู้ใช้งาน',
                    'route' => 'admin.users.index',
                    'icon' =>
                        'M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 016-6h6a6 6 0 016 6v1h-3M15 21a2 2 0 002-2v-1a2 2 0 00-2-2h-2a2 2 0 00-2 2v1a2 2 0 002 2h2zm-6-9a2 2 0 00-2 2v1a2 2 0 002 2h2a2 2 0 002-2v-1a2 2 0 00-2-2H9z',
                ],
            ];
        @endphp

        {{-- Overlay for mobile sidebar --}}
        <div x-show="sidebarOpen" class="fixed inset-0 z-40 bg-black bg-opacity-30 md:hidden"
            @click="sidebarOpen = false" x-cloak></div>

        {{-- Sidebar --}}
        <aside :class="{ '-translate-x-full': !sidebarOpen }"
            class="fixed inset-y-0 left-0 z-50 w-64 bg-white shadow-lg transform transition-transform duration-300 ease-in-out md:translate-x-0 md:static md:inset-0 md:flex md:flex-col flex-shrink-0"
            x-cloak>

            <div class="flex items-center justify-center px-6 py-4 border-b border-gray-200 flex-shrink-0">
                <a href="{{ route('dashboard') }}"> {{-- Changed route to dashboard --}}
                    <x-application-logo class="block h-10 w-auto fill-current text-gray-800" />
                </a>
            </div>

            {{-- Navigation Links --}}
            <nav class="flex-1 px-4 py-6 space-y-2 overflow-y-auto">
                @foreach ($sidebarMenu as $item)
                    {{-- Use NavLink Component --}}
                    <x-nav-link :href="route($item['route'])" :active="request()->routeIs($item['route'] . '*')" activeClass="sidebar-active"
                        inactiveClass="sidebar-inactive" {{-- Pass classes --}}
                        class="flex items-center space-x-3 group px-3 py-2 rounded-md">
                        <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="{{ $item['icon'] }}"></path>
                        </svg>
                        <span>{{ __($item['title']) }}</span>
                    </x-nav-link>
                @endforeach
            </nav>

            {{-- [ย้ายมา] User Info & Logout --}}
            <div class="px-4 py-4 border-t border-gray-200 flex-shrink-0">
                <div class="flex items-center mb-3">
                    {{-- Avatar Example --}}
                    <img class="h-8 w-8 rounded-full object-cover mr-2"
                        src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name ?? 'U') }}&color=7F9CF5&background=EBF4FF"
                        alt="{{ Auth::user()->name ?? 'User' }}">
                    <div class="text-sm font-medium text-gray-700 truncate">{{ Auth::user()->name ?? 'User' }}</div>
                </div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" onclick="event.preventDefault(); this.closest('form').submit();"
                        class="w-full flex items-center justify-center px-4 py-2 text-sm font-medium text-gray-600 rounded-lg hover:bg-gray-100 hover:text-gray-800 transition group">
                        <i class="fas fa-sign-out-alt w-5 h-5 mr-2 text-gray-400 group-hover:text-gray-500"></i>
                        {{ __('ออกจากระบบ') }}
                    </button>
                </form>
            </div>
        </aside>

        {{-- Main Content Area --}}
        <div class="flex-1 flex flex-col overflow-hidden">

            {{-- [ย้ายมา] Hamburger Button for Mobile --}}
            <div class="md:hidden p-4 bg-white border-b border-gray-100 shadow-sm sticky top-0 z-30">
                <button @click="sidebarOpen = true"
                    class="inline-flex items-center justify-center p-2 rounded-md text-gray-500 hover:text-gray-700 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-tech-green">
                    <span class="sr-only">Open sidebar</span>
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>
            </div>


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
    </div>

    {{-- JS --}}
    <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
    {{-- Font Awesome JS (Optional, if needed elsewhere) --}}
    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/js/all.min.js"></script> --}}

    @stack('scripts')

</body>

</html>
