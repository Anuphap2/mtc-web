<x-admin-layout>
    <div class="bg-white p-6 rounded-lg shadow-md">
        <h2 class="text-xl font-semibold mb-4">แก้ไขเมนู: {{ $menu->name }}</h2>

        <form action="{{ route('admin.menus.update', $menu) }}" method="POST">
            @csrf
            @method('PUT') {{-- ใช้ PUT สำหรับ Update --}}

            <div class="mb-4">
                <x-input-label for="name" :value="__('Name')" />
                <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name', $menu->name)" required />
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>

            <div class="mb-4">
                <x-input-label for="url" :value="__('URL (เช่น /contact-us หรือ # สำหรับ Dropdown)')" />
                <x-text-input id="url" class="block mt-1 w-full" type="text" name="url" :value="old('url', $menu->url)" required />
                <x-input-error :messages="$errors->get('url')" class="mt-2" />
            </div>

            <div class="mb-4">
                <x-input-label for="order" :value="__('ลำดับ (Order)')" />
                <x-text-input id="order" class="block mt-1 w-full" type="number" name="order" :value="old('order', $menu->order)" required />
                <x-input-error :messages="$errors->get('order')" class="mt-2" />
            </div>

            {{-- --- เพิ่ม/แก้ไขส่วนนี้ --- --}}
            <div class="mb-4">
                <x-input-label for="parent_id" :value="__('เมนูหลัก (Parent Menu - ถ้ามี)')" />
                <select name="parent_id" id="parent_id" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                    <option value="">-- ไม่มี (เมนูหลัก) --</option>
                    @foreach ($parentMenus as $parent)
                        {{-- เช็คค่าเก่า หรือ ค่าปัจจุบันของ $menu --}}
                        <option value="{{ $parent->id }}" {{ old('parent_id', $menu->parent_id) == $parent->id ? 'selected' : '' }}>
                            {{ $parent->name }}
                        </option>
                    @endforeach
                </select>
                <x-input-error :messages="$errors->get('parent_id')" class="mt-2" />
            </div>
            {{-- --- จบส่วนเพิ่ม/แก้ไข --- --}}

            <div class="flex items-center justify-end mt-4">
                <x-primary-button>
                    {{ __('อัปเดต') }}
                </x-primary-button>
            </div>
        </form>
    </div>
</x-admin-layout>
