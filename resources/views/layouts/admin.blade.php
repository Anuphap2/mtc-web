<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

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

    {{-- Vite Assets --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            font-family: 'Kanit', sans-serif;
        }

        .dataTables_wrapper .dataTables_length select,
        .dataTables_wrapper .dataTables_filter input {
            @apply bg-white border border-gray-300 rounded-md shadow-sm py-2 px-3 text-sm;
            @apply focus:border-indigo-500 focus:ring-indigo-500;
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
            @apply px-4 py-2 mx-1 rounded-md text-sm;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button.current {
            @apply bg-tech-green text-white shadow-sm;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
            @apply bg-gray-200;
        }

        table.dataTable.dtr-inline.collapsed>tbody>tr>td.dtr-control:before {
            background-color: #10B981;
        }
    </style>
</head>

<body class="font-sans antialiased">

    {{-- Alpine.js Sidebar --}}
    <div x-data="{ sidebarOpen: false }" class="min-h-screen bg-gray-100">

        {{-- Navigation Top Bar --}}
        <nav class="bg-white border-b border-gray-100 shadow-md">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex items-center">
                        <a href="{{ route('dashboard') }}">
                            <x-application-logo class="block h-9 w-auto fill-current text-gray-800" />
                        </a>
                    </div>
                    {{-- User Info --}}
                    <div class="hidden sm:flex sm:items-center sm:ms-6">
                        <div class="px-3 py-2 text-sm font-medium text-gray-500">
                            {{ Auth::user()->name }}
                        </div>
                        <form method="POST" action="{{ route('logout') }}" class="ms-3">
                            @csrf
                            <x-primary-button type="submit"
                                onclick="event.preventDefault(); this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-primary-button>
                        </form>
                    </div>
                    {{-- Hamburger --}}
                    <div class="-me-2 flex items-center sm:hidden">
                        <button @click="sidebarOpen = ! sidebarOpen"
                            class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100">
                            <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                                <path :class="{ 'hidden': sidebarOpen, 'inline-flex': !sidebarOpen }"
                                    class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 6h16M4 12h16M4 18h16" />
                                <path :class="{ 'hidden': !sidebarOpen, 'inline-flex': sidebarOpen }" class="hidden"
                                    stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        </nav>

        {{-- Sidebar Menu Array --}}
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
                    'title' => 'จัดการผู้ใช้งาน',
                    'route' => 'admin.users.index',
                    'icon' =>
                        'M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 016-6h6a6 6 0 016 6v1h-3M15 21a2 2 0 002-2v-1a2 2 0 00-2-2h-2a2 2 0 00-2 2v1a2 2 0 002 2h2zm-6-9a2 2 0 00-2 2v1a2 2 0 002 2h2a2 2 0 002-2v-1a2 2 0 00-2-2H9z',
                ],
            ];
        @endphp

        <div class="flex" style="height: calc(100vh - 65px);">

            {{-- Desktop Sidebar --}}
            <aside class="w-64 bg-white shadow-lg h-full overflow-y-auto flex-shrink-0 hidden md:flex md:flex-col">
                <nav class="flex-1 px-4 py-6 space-y-2">
                    @foreach ($sidebarMenu as $item)
                        <x-nav-link :href="route($item['route'])" :active="request()->routeIs($item['route'] . '*')" class="flex items-center space-x-3 group">
                            <svg class="w-5 h-5 text-gray-500 group-hover:text-tech-green" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="{{ $item['icon'] }}"></path>
                            </svg>
                            <span>{{ __($item['title']) }}</span>
                        </x-nav-link>
                    @endforeach
                </nav>
            </aside>

            {{-- Mobile Sidebar --}}
            <div x-show="sidebarOpen" x-transition class="fixed inset-0 flex z-50 md:hidden" x-cloak>
                <!-- Background overlay -->
                <div @click="sidebarOpen=false" x-transition class="fixed inset-0 bg-black bg-opacity-30"></div>

                <!-- Sidebar panel -->
                <div class="relative flex-1 max-w-xs w-64 bg-white shadow-lg overflow-y-auto">
                    <!-- Close button -->
                    <div class="absolute top-2 right-2">
                        <button @click="sidebarOpen=false" class="p-1 rounded-full hover:bg-gray-200">
                            ✕
                        </button>
                    </div>

                    <!-- Logo & User -->
                    <div class="flex items-center px-4 py-3 border-b border-gray-200">
                        <img class="h-10 w-10 rounded-full object-cover" src="{{ asset('images/logo.png') }}"
                            alt="My Avatar">
                        <span class="ml-3 font-semibold text-gray-700">Admin MTC</span>
                    </div>

                    <!-- Menu -->
                    <nav class="mt-4 px-2 space-y-1">
                        @foreach ($sidebarMenu as $item)
                            <x-nav-link :href="route($item['route'])" :active="request()->routeIs($item['route'] . '*')"
                                class="flex items-center space-x-3 group px-3 py-2 rounded-md hover:bg-gray-100">
                                <svg class="w-5 h-5 text-gray-500 group-hover:text-tech-green" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="{{ $item['icon'] }}"></path>
                                </svg>
                                <span>{{ __($item['title']) }}</span>
                            </x-nav-link>
                        @endforeach
                    </nav>

                    <!-- Logout button -->
                    <div class="mt-auto px-4 py-4 border-t border-gray-200">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-primary-button type="submit" class="w-full">
                                {{ __('Log Out') }}
                            </x-primary-button>
                        </form>
                    </div>
                </div>
            </div>


            {{-- Main Content --}}
            <main class="flex-1 h-full overflow-y-auto p-6 md:p-10">
                <div class="container mx-auto max-w-7xl">
                    @if (session('success'))
                        <div class="mb-6 bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded-md shadow-sm"
                            role="alert">
                            {{ session('success') }}
                        </div>
                    @endif
                    @if (session('error'))
                        <div class="mb-6 bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded-md shadow-sm"
                            role="alert">
                            {{ session('error') }}
                        </div>
                    @endif
                    {{ $slot }}
                </div>
            </main>

        </div>
    </div>

    {{-- JS --}}
    <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
    @stack('scripts')
</body>

</html>
