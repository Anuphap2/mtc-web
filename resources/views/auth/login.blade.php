<x-guest-layout>
    <div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-tech-slate-dark to-gray-800 px-4">
        <div class="w-full max-w-md bg-white/60 backdrop-blur-md rounded-3xl shadow-2xl p-8 sm:p-10">

            {{-- Logo --}}
            <div class="flex justify-center mb-6">
                <a>
                    <x-application-logo class="w-24 h-24 text-tech-green animate-pulse" />
                </a>
            </div>

            {{-- Heading --}}
            <h2 class="text-3xl font-bold text-gray-800 text-center mb-8">เข้าสู่ระบบ</h2>

            {{-- Session Status --}}
            <x-auth-session-status class="mb-4" :status="session('status')" />

            {{-- Login Form --}}
            <form method="POST" action="{{ route('login') }}" class="space-y-6">
                @csrf

                {{-- Username --}}
                <div>
                    <x-input-label for="username" :value="__('Username')" class="text-gray-700" />
                    <x-text-input id="username" type="text" name="username" :value="old('username')" required autofocus
                        autocomplete="username"
                        class="mt-2 block w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-tech-green focus:border-tech-green placeholder-gray-400 transition duration-300 shadow-sm hover:shadow-md"
                        placeholder="กรอก Username ของคุณ" />
                    <x-input-error :messages="$errors->get('username')" class="mt-2 text-red-500 text-sm" />
                </div>

                {{-- Password --}}
                <div>
                    <x-input-label for="password" :value="__('Password')" class="text-gray-700" />
                    <x-text-input id="password" type="password" name="password" required
                        autocomplete="current-password"
                        class="mt-2 block w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-tech-green focus:border-tech-green placeholder-gray-400 transition duration-300 shadow-sm hover:shadow-md"
                        placeholder="กรอก Password ของคุณ" />
                    <x-input-error :messages="$errors->get('password')" class="mt-2 text-red-500 text-sm" />
                </div>

                {{-- Submit Button --}}
                <div>
                    <x-primary-button
                        class="w-full py-3 rounded-xl bg-tech-green hover:bg-tech-green-dark text-white text-lg font-semibold transition transform hover:scale-105 hover:shadow-lg">
                        เข้าสู่ระบบ
                    </x-primary-button>
                </div>
            </form>

            {{-- Footer note --}}
            <p class="text-center text-gray-500 text-sm mt-6">
                &copy; {{ date('Y') }} วิทยาลัยเทคนิคแม่สอด. สงวนลิขสิทธิ์.
            </p>
        </div>
    </div>
</x-guest-layout>
