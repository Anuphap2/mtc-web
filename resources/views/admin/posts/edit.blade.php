<x-admin-layout>
    <div class="bg-white p-6 rounded-lg shadow-md max-w-2xl mx-auto">
        <h2 class="text-xl font-semibold mb-6 text-gray-700">แก้ไขข่าวสาร: {{ $post->title }}</h2>

        <form action="{{ route('admin.posts.update', $post) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            {{-- Category --}}
            <div class="mb-4">
                <x-input-label for="category_id" :value="__('ประเภทข่าว')" class="mb-1"/>
                <select name="category_id" id="category_id" class="block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                    <option value="">-- เลือกประเภท --</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ old('category_id', $post->category_id) == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
                <x-input-error :messages="$errors->get('category_id')" class="mt-2" />
            </div>

            {{-- Title --}}
            <div class="mb-4">
                <x-input-label for="title" :value="__('หัวข้อ')" class="mb-1"/>
                <x-text-input id="title" class="block w-full" type="text" name="title" :value="old('title', $post->title)" required />
                <x-input-error :messages="$errors->get('title')" class="mt-2" />
            </div>

            {{-- Content --}}
            <div class="mb-4">
                <x-input-label for="content" :value="__('เนื้อหา')" class="mb-1"/>
                <textarea id="content" name="content" rows="10" class="block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">{{ old('content', $post->content) }}</textarea>
                <x-input-error :messages="$errors->get('content')" class="mt-2" />
            </div>

            {{-- Image --}}
            <div class="mb-4 p-4 border border-dashed rounded-md">
                <x-input-label for="image" :value="__('รูปภาพประกอบ (อัปโหลดใหม่ถ้าต้องการเปลี่ยน)')" class="mb-2 text-sm font-medium text-gray-700"/>
                <input id="image" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-violet-50 file:text-violet-700 hover:file:bg-violet-100" type="file" name="image" accept="image/*">
                 <p class="mt-1 text-xs text-gray-500">รองรับ JPG, PNG, GIF ขนาดไม่เกิน 2MB</p>
                <x-input-error :messages="$errors->get('image')" class="mt-2" />
                @if($post->image_path)
                    <div class="mt-4">
                        <p class="text-xs font-medium text-gray-500 mb-1">รูปปัจจุบัน:</p>
                        <img src="{{ Storage::url($post->image_path) }}" alt="{{ $post->title }}" class="h-24 w-auto object-contain rounded border p-1">
                    </div>
                @endif
            </div>

            {{-- PDF File --}}
            <div class="mb-4 p-4 border border-dashed rounded-md">
                <x-input-label for="pdf" :value="__('ไฟล์ PDF (อัปโหลดใหม่ถ้าต้องการเปลี่ยน)')" class="mb-2 text-sm font-medium text-gray-700"/>
                <input id="pdf" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-red-50 file:text-red-700 hover:file:bg-red-100" type="file" name="pdf" accept=".pdf">
                 <p class="mt-1 text-xs text-gray-500">ขนาดไม่เกิน 10MB</p>
                <x-input-error :messages="$errors->get('pdf')" class="mt-2" />
                @if($post->pdf_path)
                    <div class="mt-4">
                        <p class="text-xs font-medium text-gray-500 mb-1">ไฟล์ PDF ปัจจุบัน:
                            <a href="{{ Storage::url($post->pdf_path) }}" target="_blank" class="text-blue-500 hover:text-blue-700 ml-2">[ ดูไฟล์ ]</a>
                        </p>
                        <label for="remove_pdf" class="inline-flex items-center mt-1">
                            <input type="checkbox" id="remove_pdf" name="remove_pdf" value="1" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500 h-4 w-4">
                            <span class="ms-2 text-xs text-gray-600">{{ __('ลบไฟล์ PDF นี้') }}</span>
                        </label>
                    </div>
                @endif
            </div>

             {{-- Is Featured Checkbox --}}
             <div class="mb-4">
                 <label for="is_featured" class="inline-flex items-center">
                     <input type="checkbox" id="is_featured" name="is_featured" value="1"
                            class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500"
                            {{ old('is_featured', $post->is_featured) ? 'checked' : '' }}> {{-- Check old value or current value --}}
                     <span class="ms-2 text-sm text-gray-600">{{ __('เป็นข่าวเด่น (แสดงในสไลด์หน้าแรก)') }}</span>
                 </label>
                 <x-input-error :messages="$errors->get('is_featured')" class="mt-2" />
             </div>

            {{-- Embed Link --}}
            <div class="mb-6">
                <x-input-label for="embed_link" :value="__('ลิงก์ Embed (Facebook/YouTube ถ้ามี)')" class="mb-1"/>
                <x-text-input id="embed_link" class="block w-full" type="text" name="embed_link" :value="old('embed_link', $post->embed_link)" placeholder="https://..." />
                <x-input-error :messages="$errors->get('embed_link')" class="mt-2" />
            </div>

            <div class="flex items-center justify-end mt-6">
                 <a href="{{ route('admin.posts.index') }}" class="text-sm text-gray-600 hover:text-gray-900 mr-4">ยกเลิก</a>
                <x-primary-button>
                    {{ __('อัปเดต') }}
                </x-primary-button>
            </div>
        </form>
    </div>
</x-admin-layout>
