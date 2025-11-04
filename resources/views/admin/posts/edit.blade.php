<x-admin-layout>
    <div class="bg-white p-6 rounded-lg shadow-md max-w-3xl mx-auto">
        <h2 class="text-xl font-semibold mb-6 text-gray-700">
            ✏️ แก้ไขข่าวสาร: {{ $post->title }}
        </h2>

        <form action="{{ route('admin.posts.update', $post) }}" method="POST" enctype="multipart/form-data"
            onsubmit="return syncQuillContent()">
            @csrf
            @method('PUT')

            {{-- Category --}}
            <div class="mb-4">
                <x-input-label for="category_id" :value="__('ประเภทข่าว')" class="mb-1" />
                <select name="category_id" id="category_id"
                    class="block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                    required>
                    <option value="">-- เลือกประเภท --</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}"
                            {{ old('category_id', $post->category_id) == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
                <x-input-error :messages="$errors->get('category_id')" class="mt-2" />
            </div>

            {{-- Title --}}
            <div class="mb-4">
                <x-input-label for="title" :value="__('หัวข้อ')" class="mb-1" />
                <x-text-input id="title" class="block w-full" type="text" name="title" :value="old('title', $post->title)"
                    required />
                <x-input-error :messages="$errors->get('title')" class="mt-2" />
            </div>

            {{-- ✅ Quill Editor --}}
            <div class="mb-4">
                <x-input-label :value="__('เนื้อหา')" class="mb-1" />
                <div id="editor" class="min-h-[300px] border rounded-md p-3 bg-white">{!! old('content', $post->content) !!}</div>
                <textarea name="content" id="content" class="hidden"></textarea>
                <x-input-error :messages="$errors->get('content')" class="mt-2" />
            </div>

            {{-- Image --}}
            <div class="mb-4 p-4 border border-dashed rounded-md">
                <x-input-label for="image" :value="__('รูปภาพประกอบ (อัปโหลดใหม่ถ้าต้องการเปลี่ยน)')" />
                <input id="image" name="image" type="file" accept="image/*"
                    class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0
                           file:text-sm file:font-semibold file:bg-violet-50 file:text-violet-700 hover:file:bg-violet-100" />
                <p class="mt-1 text-xs text-gray-500"></p>
                <p class="mt-2 text-xs text-gray-500">📁 รองรับ JPG, PNG, GIF ขนาดไม่เกิน 10MB ขนาดไฟล์ต้องไม่เกิน <span
                        class="font-semibold">10 MB</span>
                </p>

                @if ($post->image_path)
                    <div class="mt-3">
                        <p class="text-xs font-medium text-gray-500 mb-1">รูปปัจจุบัน:</p>
                        <img src="{{ Storage::url($post->image_path) }}" alt="{{ $post->title }}"
                            class="h-24 w-auto object-contain rounded border p-1">
                    </div>
                @endif
            </div>

            {{-- PDF --}}
            <div class="mb-4 p-4 border border-dashed rounded-md">
                <x-input-label for="pdf" :value="__('ไฟล์ PDF (อัปโหลดใหม่ถ้าต้องการเปลี่ยน)')" />
                <input id="pdf" name="pdf" type="file" accept=".pdf"
                    class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0
                           file:text-sm file:font-semibold file:bg-red-50 file:text-red-700 hover:file:bg-red-100" />
                <p class="mt-2 text-xs text-gray-500">📁 ขนาดไฟล์ต้องไม่เกิน <span class="font-semibold">10 MB</span>
                </p>


                @if ($post->pdf_path)
                    <div class="mt-4">
                        <p class="text-xs font-medium text-gray-500 mb-1">
                            ไฟล์ PDF ปัจจุบัน:
                            <a href="{{ Storage::url($post->pdf_path) }}" target="_blank"
                                class="text-blue-500 hover:text-blue-700 ml-2">[ ดูไฟล์ ]</a>
                        </p>
                        <label for="remove_pdf" class="inline-flex items-center mt-1">
                            <input type="checkbox" id="remove_pdf" name="remove_pdf" value="1"
                                class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500 h-4 w-4">
                            <span class="ms-2 text-xs text-gray-600">ลบไฟล์ PDF นี้</span>
                        </label>
                    </div>
                @endif
            </div>

            {{-- Featured --}}
            <div class="mb-4">
                <label for="is_featured" class="inline-flex items-center">
                    <input type="checkbox" id="is_featured" name="is_featured" value="1"
                        class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500"
                        {{ old('is_featured', $post->is_featured) ? 'checked' : '' }}>
                    <span class="ms-2 text-sm text-gray-600">เป็นข่าวเด่น (แสดงในสไลด์หน้าแรก)</span>
                </label>
            </div>



            <div class="flex items-center justify-end mt-6">
                <a href="{{ route('admin.posts.index') }}"
                    class="text-sm text-gray-600 hover:text-gray-900 mr-4">ยกเลิก</a>
                <x-primary-button>อัปเดต</x-primary-button>
            </div>
        </form>
    </div>

    {{-- ✅ รวม Quill --}}
    @push('scripts')
        <script>
            document.addEventListener("DOMContentLoaded", () => {
                const BlockEmbed = Quill.import('blots/block/embed');
                const Delta = Quill.import('delta');

                // ✅ สร้าง custom blot สำหรับ iframe
                class IframeBlot extends BlockEmbed {
                    static create(value) {
                        const node = super.create();
                        node.setAttribute('src', value);
                        node.setAttribute('frameborder', '0');
                        node.setAttribute('allowfullscreen', true);
                        node.classList.add('mx-auto', 'my-4', 'rounded-md');
                        node.style.width = '100%';
                        node.style.minHeight = '400px';
                        node.style.display = 'block';
                        return node;
                    }
                    static value(node) {
                        return node.getAttribute('src');
                    }
                }
                IframeBlot.blotName = 'iframe';
                IframeBlot.tagName = 'iframe';
                Quill.register(IframeBlot, true);

                // ✅ สร้าง editor
                const quill = new Quill('#editor', {
                    theme: 'snow',
                    placeholder: 'พิมพ์เนื้อหาข่าวที่นี่...',
                    modules: {
                        toolbar: [
                            ['bold', 'italic', 'underline', 'strike'],
                            [{
                                list: 'ordered'
                            }, {
                                list: 'bullet'
                            }],
                            ['link'],
                            [{
                                align: []
                            }],
                            ['clean']
                        ],
                        clipboard: {
                            matchVisual: false
                        }
                    }
                });

                // ✅ อนุญาตให้ paste iframe ได้ตรง ๆ
                quill.clipboard.addMatcher(Node.ELEMENT_NODE, (node, delta) => {
                    if (node.tagName === 'IFRAME') {
                        const src = node.getAttribute('src');
                        return new Delta().insert({
                            iframe: src
                        });
                    }
                    return delta;
                });

                quill.root.addEventListener('paste', (e) => {
                    if (e.clipboardData && [...e.clipboardData.items].some(item => item.type.includes(
                            'image'))) {
                        e.preventDefault();
                        alert('❌ ไม่อนุญาตให้นำเข้ารูปภาพ');
                    }
                });

                quill.root.addEventListener('drop', (e) => {
                    if ([...e.dataTransfer.items].some(item => item.type.includes('image'))) {
                        e.preventDefault();
                        alert('❌ ไม่อนุญาตให้นำเข้ารูปภาพ');
                    }
                });

                // ✅ ตรวจจับการวางลิงก์
                quill.root.addEventListener('paste', (e) => {
                    const text = (e.clipboardData || window.clipboardData).getData('text');

                    // ---- YouTube ----
                    if (text.match(/(youtube\.com|youtu\.be)/)) {
                        e.preventDefault();

                        let videoId = '';
                        if (text.includes('youtu.be')) {
                            videoId = text.split('youtu.be/')[1].split(/[?&]/)[0];
                        } else if (text.includes('v=')) {
                            videoId = text.split('v=')[1].split('&')[0];
                        }

                        const embedUrl = `https://www.youtube.com/embed/${videoId}`;
                        const range = quill.getSelection(true);
                        quill.insertEmbed(range.index, 'iframe', embedUrl, Quill.sources.USER);
                        quill.setSelection(range.index + 1);
                        return;
                    }

                    // ---- Facebook (post / video) ----
                    if (text.match(/facebook\.com/)) {
                        e.preventDefault();

                        const encoded = encodeURIComponent(text);
                        let embedUrl = '';

                        // ถ้ามี watch?v= → เป็น video
                        if (text.includes('/watch') || text.includes('/videos/')) {
                            embedUrl =
                                `https://www.facebook.com/plugins/video.php?href=${encoded}&show_text=false&width=500`;
                        } else {
                            // เป็นโพสต์ปกติ
                            embedUrl =
                                `https://www.facebook.com/plugins/post.php?href=${encoded}&show_text=true&width=500`;
                        }

                        const range = quill.getSelection(true);
                        quill.insertEmbed(range.index, 'iframe', embedUrl, Quill.sources.USER);
                        quill.setSelection(range.index + 1);
                        return;
                    }
                });

                // ✅ Sync ก่อน submit
                window.syncQuillContent = function() {
                    document.querySelector('#content').value = quill.root.innerHTML.trim();
                    return true;
                };
            });
        </script>
    @endpush
</x-admin-layout>
