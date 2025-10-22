<x-admin-layout>
    <div class="bg-white p-6 rounded-lg shadow-md">
        <h2 class="text-xl font-semibold mb-4">แก้ไขเมนู: {{ $menu->name }}</h2>

        <form action="{{ route('admin.menus.update', $menu) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="mb-4">
                <x-input-label for="name" :value="__('Name')" />
                <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name', $menu->name)" required />
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>

            <div class="mb-4">
                <x-input-label for="url" :value="__('URL')" />
                <x-text-input id="url" class="block mt-1 w-full" type="text" name="url" :value="old('url', $menu->url)" required />
                <x-input-error :messages="$errors->get('url')" class="mt-2" />
            </div>

            <div class="mb-4">
                <x-input-label for="order" :value="__('ลำดับ (Order)')" />
                <x-text-input id="order" class="block mt-1 w-full" type="number" name="order" :value="old('order', $menu->order)" required />
                <x-input-error :messages="$errors->get('order')" class="mt-2" />
            </div>

            <div class="flex items-center justify-end mt-4">
                <x-primary-button>
                    {{ __('อัปเดต') }}
                </x-primary-button>
            </div>
        </form>
    </div>
</x-admin-layout>