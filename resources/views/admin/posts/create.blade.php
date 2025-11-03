<x-admin-layout>
    <div class="bg-white p-6 rounded-lg shadow-md max-w-2xl mx-auto">
        <h2 class="text-xl font-semibold mb-6 text-gray-700">เพิ่มข่าวสารใหม่</h2>

        <form action="{{ route('admin.posts.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            {{-- Category --}}
            <div class="mb-4">
                <x-input-label for="category_id" :value="__('ประเภทข่าว')" class="mb-1" />
                <select name="category_id" id="category_id" class="block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                    <option value="">-- เลือกประเภท --</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
                <x-input-error :messages="$errors->get('category_id')" class="mt-2" />
            </div>

            {{-- Title --}}
            <div class="mb-4">
                <x-input-label for="title" :value="__('หัวข้อ')" class="mb-1" />
                <x-text-input id="title" class="block w-full" type="text" name="title" :value="old('title')" required />
                <x-input-error :messages="$errors->get('title')" class="mt-2" />
            </div>

            {{-- Content --}}
            <div class="mb-4">
                <x-input-label for="content" :value="__('เนื้อหา')" class="mb-1" />
                {{-- ควรใช้ Rich Text Editor เช่น TinyMCE หรือ CKEditor ที่นี่ --}}
                <textarea id="content" name="content" rows="10" class="block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">{{ old('content') }}</textarea>
                <x-input-error :messages="$errors->get('content')" class="mt-2" />
            </div>

            {{-- Image --}}
            <div class="mb-4 p-4 border border-dashed rounded-md">
                <x-input-label for="image" :value="__('รูปภาพประกอบ (ถ้ามี)')" class="mb-2 text-sm font-medium text-gray-700"/>
                <input id="image" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-violet-50 file:text-violet-700 hover:file:bg-violet-100" type="file" name="image" accept="image/*">
                <p class="mt-1 text-xs text-gray-500">รองรับ JPG, PNG, GIF ขนาดไม่เกิน 10MB</p>
                <x-input-error :messages="$errors->get('image')" class="mt-2" />
            </div>

            {{-- PDF File --}}
            <div class="mb-4 p-4 border border-dashed rounded-md">
                <x-input-label for="pdf" :value="__('ไฟล์ PDF (ถ้ามี)')" class="mb-2 text-sm font-medium text-gray-700"/>
                <input id="pdf" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-red-50 file:text-red-700 hover:file:bg-red-100" type="file" name="pdf" accept=".pdf">
                 <p class="mt-1 text-xs text-gray-500">ขนาดไม่เกิน 10MB</p>
                <x-input-error :messages="$errors->get('pdf')" class="mt-2" />
            </div>

             {{-- Is Featured Checkbox --}}
             <div class="mb-4">
                 <label for="is_featured" class="inline-flex items-center">
                     <input type="checkbox" id="is_featured" name="is_featured" value="1"
                            class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500"
                            {{ old('is_featured') ? 'checked' : '' }}>
                     <span class="ms-2 text-sm text-gray-600">{{ __('เป็นข่าวเด่น (แสดงในสไลด์หน้าแรก)') }}</span>
                 </label>
                 <x-input-error :messages="$errors->get('is_featured')" class="mt-2" />
             </div>

            {{-- Embed Link --}}
            <div class="mb-6">
                <x-input-label for="embed_link" :value="__('ลิงก์ Embed (Facebook/YouTube ถ้ามี)')" class="mb-1"/>
                <x-text-input id="embed_link" class="block w-full" type="text" name="embed_link" :value="old('embed_link')" placeholder="https://..." />
                <x-input-error :messages="$errors->get('embed_link')" class="mt-2" />
            </div>

            <div class="flex items-center justify-end mt-6">
                 <a href="{{ route('admin.posts.index') }}" class="text-sm text-gray-600 hover:text-gray-900 mr-4">ยกเลิก</a>
                <x-primary-button>
                    {{ __('บันทึก') }}
                </x-primary-button>
            </div>
        </form>
    </div>
</x-admin-layout>
