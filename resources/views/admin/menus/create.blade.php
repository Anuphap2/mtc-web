<x-admin-layout>
    <div class="bg-white p-6 rounded-lg shadow-md">
        <h2 class="text-xl font-semibold mb-4">เพิ่มเมนูใหม่</h2>

        <form action="{{ route('admin.menus.store') }}" method="POST">
            @csrf

            <div class="mb-4">
                <x-input-label for="name" :value="__('Name')" />
                <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required />
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>

            <div class="mb-4">
                <x-input-label for="url" :value="__('URL (เช่น /contact-us หรือ # สำหรับ Dropdown)')" />
                <x-text-input id="url" class="block mt-1 w-full" type="text" name="url" :value="old('url')" required />
                <x-input-error :messages="$errors->get('url')" class="mt-2" />
            </div>

            <div class="mb-4">
                <x-input-label for="order" :value="__('ลำดับ (Order)')" />
                <x-text-input id="order" class="block mt-1 w-full" type="number" name="order" :value="old('order', 0)" required />
                <x-input-error :messages="$errors->get('order')" class="mt-2" />
            </div>

            {{-- --- เพิ่มส่วนนี้ --- --}}
            <div class="mb-4">
                <x-input-label for="parent_id" :value="__('เมนูหลัก (Parent Menu - ถ้ามี)')" />
                <select name="parent_id" id="parent_id" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                    <option value="">-- ไม่มี (เมนูหลัก) --</option> {{-- ค่าว่างคือ parent_id = NULL --}}
                    @foreach ($parentMenus as $parent)
                        <option value="{{ $parent->id }}" {{ old('parent_id') == $parent->id ? 'selected' : '' }}>
                            {{ $parent->name }}
                        </option>
                    @endforeach
                </select>
                <x-input-error :messages="$errors->get('parent_id')" class="mt-2" />
            </div>
            {{-- --- จบส่วนเพิ่ม --- --}}


            <div class="flex items-center justify-end mt-4">
                <x-primary-button>
                    {{ __('บันทึก') }}
                </x-primary-button>
            </div>
        </form>
    </div>
</x-admin-layout>
