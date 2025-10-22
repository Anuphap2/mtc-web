<x-admin-layout>
    <div class="bg-white p-6 rounded-lg shadow-md">
        <h2 class="text-xl font-semibold mb-4">เพิ่มประเภทข่าวใหม่</h2>

        <form action="{{ route('admin.categories.store') }}" method="POST">
            @csrf

            <!-- Name -->
            <div class="mb-4">
                <x-input-label for="name" :value="__('Name')" />
                <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus />
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>

            {{-- Removed Slug input block --}}

            <div class="flex items-center justify-end mt-4">
                <x-primary-button>
                    {{ __('บันทึก') }}
                </x-primary-button>
            </div>
        </form>
    </div>
</x-admin-layout>
