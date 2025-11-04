<x-admin-layout>
    <div class="bg-white p-6 rounded-lg shadow-md max-w-4xl mx-auto">
        <h2 class="text-xl font-semibold mb-6 text-gray-700">เพิ่มข่าวสารใหม่</h2>

        <form action="{{ route('admin.posts.store') }}" method="POST" enctype="multipart/form-data"
            onsubmit="return syncQuillContent()">
            @csrf

            {{-- Category --}}
            <div class="mb-4">
                <x-input-label for="category_id" :value="__('ประเภทข่าว')" />
                <select name="category_id" id="category_id"
                    class="block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                    required>
                    <option value="">-- เลือกประเภท --</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>

            {{-- Title --}}
            <div class="mb-4">
                <x-input-label for="title" :value="__('หัวข้อ')" />
                <x-text-input id="title" class="block w-full" type="text" name="title" required />
            </div>

            {{-- ✅ Quill Editor --}}
            <div class="mb-4">
                <x-input-label :value="__('เนื้อหา')" />
                <div id="editor" class="min-h-[300px] border rounded-md p-3 bg-white"></div>
                <textarea name="content" id="content" class="hidden"></textarea>
            </div>

            {{-- Image --}}
            <div class="mb-4 p-4 border border-dashed rounded-md">
                <x-input-label for="image" :value="__('รูปภาพประกอบ (ถ้ามี)')" />
                <input id="image" name="image" type="file" accept="image/*"
                    class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0
                           file:text-sm file:font-semibold file:bg-violet-50 file:text-violet-700 hover:file:bg-violet-100" />
                <p class="mt-2 text-xs text-gray-500">📁 รองรับ JPG, PNG, GIF ขนาดไม่เกิน 10MB ขนาดไฟล์ต้องไม่เกิน <span
                        class="font-semibold">10 MB</span>
                </p>

            </div>

            {{-- PDF --}}
            <div class="mb-4 p-4 border border-dashed rounded-md">
                <x-input-label for="pdf" :value="__('ไฟล์ PDF (ถ้ามี)')" />
                <input id="pdf" name="pdf" type="file" accept=".pdf"
                    class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0
                           file:text-sm file:font-semibold file:bg-red-50 file:text-red-700 hover:file:bg-red-100" />
                <p class="mt-2 text-xs text-gray-500">📁 ขนาดไฟล์ต้องไม่เกิน <span class="font-semibold">10 MB</span>
                </p>

            </div>

            {{-- Featured --}}
            <div class="mb-4">
                <label for="is_featured" class="inline-flex items-center">
                    <input type="checkbox" id="is_featured" name="is_featured" value="1"
                        class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500">
                    <span class="ms-2 text-sm text-gray-600">เป็นข่าวเด่น (แสดงในสไลด์หน้าแรก)</span>
                </label>
            </div>



            <div class="flex items-center justify-end mt-6">
                <a href="{{ route('admin.posts.index') }}"
                    class="text-sm text-gray-600 hover:text-gray-900 mr-4">ยกเลิก</a>
                <x-primary-button>{{ __('บันทึก') }}</x-primary-button>
            </div>
        </form>
    </div>

    {{-- ✅ 2. ติดตั้ง Quill ผ่าน CDN --}}
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
