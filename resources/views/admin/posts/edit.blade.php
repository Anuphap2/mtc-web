<x-admin-layout>
    <div class="bg-white p-6 rounded-lg shadow-md">
        <h2 class="text-xl font-semibold mb-4">แก้ไขข่าวสาร: {{ $post->title }}</h2>

        <form action="{{ route('admin.posts.update', $post) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            <div class="mb-4">
                <x-input-label for="category_id" :value="__('ประเภทข่าว')" />
                <select name="category_id" id="category_id" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ old('category_id', $post->category_id) == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
                <x-input-error :messages="$errors->get('category_id')" class="mt-2" />
            </div>

            <div class="mb-4">
                <x-input-label for="title" :value="__('หัวข้อ')" />
                <x-text-input id="title" class="block mt-1 w-full" type="text" name="title" :value="old('title', $post->title)" required />
                <x-input-error :messages="$errors->get('title')" class="mt-2" />
            </div>

            <div class="mb-4">
                <x-input-label for="content" :value="__('เนื้อหา')" />
                <textarea id="content" name="content" rows="10" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">{{ old('content', $post->content) }}</textarea>
                <x-input-error :messages="$errors->get('content')" class="mt-2" />
            </div>

            <div class="mb-4">
                <x-input-label for="image" :value="__('รูปภาพประกอบ (อัปโหลดใหม่ถ้าต้องการเปลี่ยน)')" />
                <input id="image" class="block mt-1 w-full" type="file" name="image">
                <x-input-error :messages="$errors->get('image')" class="mt-2" />
                
                @if($post->image_path)
                    <div class="mt-4">
                        <p class="text-sm font-medium text-gray-700">รูปปัจจุบัน:</p>
                        <img src="{{ Storage::url($post->image_path) }}" alt="{{ $post->title }}" class="h-32 w-auto object-cover mt-2 rounded">
                    </div>
                @endif
            </div>

            <div class="mb-4">
                <x-input-label for="embed_link" :value="__('ลิงก์ (Facebook/YouTube ถ้ามี)')" />
                <x-text-input id="embed_link" class="block mt-1 w-full" type="url" name="embed_link" :value="old('embed_link', $post->embed_link)" />
                <x-input-error :messages="$errors->get('embed_link')" class="mt-2" />
            </div>

            <div class="flex items-center justify-end mt-4">
                <x-primary-button>
                    {{ __('อัปเดต') }}
                </x-primary-button>
            </div>
        </form>
    </div>
</x-admin-layout>