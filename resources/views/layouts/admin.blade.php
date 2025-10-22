<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Admin - {{ config('app.name', 'Laravel') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased">
    <div class="min-h-screen bg-gray-100">
        @include('layouts.navigation') {{-- ใช้ Navigation ของ Breeze --}}

        <main class="max-w-7xl mx-auto py-12 sm:px-6 lg:px-8">
            <div class="flex flex-col sm:flex-row sm:space-x-6">

                <div class="sm:w-1/4 w-full bg-white p-4 shadow-md rounded-lg h-full mb-6 sm:mb-0">
                    <h3 class="font-semibold text-lg mb-4 border-b pb-2">เมนูจัดการ</h3>
                    <ul class="space-y-2">
                        <li>
                            <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                                {{ __('Dashboard') }}
                            </x-nav-link>
                        </li>
                        <li>
                            <x-nav-link :href="route('admin.categories.index')" :active="request()->routeIs('admin.categories.*')">
                                {{ __('จัดการประเภทข่าว') }}
                            </x-nav-link>
                        </li>
                        <li>
                            <x-nav-link :href="route('admin.posts.index')" :active="request()->routeIs('admin.posts.*')">
                                {{ __('จัดการข่าวสาร') }}
                            </x-nav-link>
                        </li>
                        <li>
                            <x-nav-link :href="route('admin.menus.index')" :active="request()->routeIs('admin.menus.*')">
                                {{ __('จัดการเมนู') }}
                            </x-nav-link>
                        </li>
                        <li>
                            <x-nav-link :href="route('admin.users.index')" :active="request()->routeIs('admin.users.*')">
                                {{ __('จัดการผู้ใช้งาน') }}
                            </x-nav-link>
                        </li>
                    </ul>
                </div>

                <div class="sm:w-3/4 w-full">
                    {{-- แสดงข้อความ Success หรือ Error (ถ้ามี) --}}
                    @if (session('success'))
                        <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif
                    @if (session('error'))
                         <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                            {{ session('error') }}
                        </div>
                    @endif
                
                    {{ $slot }}
                </div>
            </div>
        </main>
    </div>
</body>
</html>