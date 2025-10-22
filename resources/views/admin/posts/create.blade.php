<x-admin-layout>
    <div class="bg-white p-6 rounded-lg shadow-md">
        <h2 class="text-xl font-semibold mb-4">เพิ่มข่าวสารใหม่</h2>

        <form action="{{ route('admin.posts.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="mb-4">
                <x-input-label for="category_id" :value="__('ประเภทข่าว')" />
                <select name="category_id" id="category_id" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                    <option value="">-- เลือกประเภท --</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
                <x-input-error :messages="$errors->get('category_id')" class="mt-2" />
            </div>

            <div class="mb-4">
                <x-input-label for="title" :value="__('หัวข้อ')" />
                <x-text-input id="title" class="block mt-1 w-full" type="text" name="title" :value="old('title')" required />
                <x-input-error :messages="$errors->get('title')" class="mt-2" />
            </div>

            <div class="mb-4">
                <x-input-label for="content" :value="__('เนื้อหา')" />
                <textarea id="content" name="content" rows="10" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">{{ old('content') }}</textarea>
                <x-input-error :messages="$errors->get('content')" class="mt-2" />
            </div>

            <div class="mb-4">
                <x-input-label for="image" :value="__('รูปภาพประกอบ (ถ้ามี)')" />
                <input id="image" class="block mt-1 w-full border p-2 rounded" type="file" name="image" accept="image/*"> {{-- เพิ่ม accept="image/*" --}}
                <x-input-error :messages="$errors->get('image')" class="mt-2" />
            </div>

            <div class="mb-4"> {{-- <-- เพิ่มส่วนนี้ --}}
                <x-input-label for="pdf" :value="__('ไฟล์ PDF (ถ้ามี)')" />
                <input id="pdf" class="block mt-1 w-full border p-2 rounded" type="file" name="pdf" accept=".pdf"> {{-- เพิ่ม accept=".pdf" --}}
                <x-input-error :messages="$errors->get('pdf')" class="mt-2" />
            </div>

            <div class="mb-4">
                <x-input-label for="embed_link" :value="__('ลิงก์ (Facebook/YouTube ถ้ามี)')" />
                <x-text-input id="embed_link" class="block mt-1 w-full" type="text" name="embed_link" :value="old('embed_link')" />
                <x-input-error :messages="$errors->get('embed_link')" class="mt-2" />
            </div>

            <div class="flex items-center justify-end mt-4">
                <x-primary-button>
                    {{ __('บันทึก') }}
                </x-primary-button>
            </div>
        </form>
    </div>
</x-admin-layout>