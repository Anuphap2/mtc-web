<x-public-layout>
    <style>
        .prose a {
            color: #2563eb;

            position: relative;
            transition: color 0.2s;
        }

        .prose a::after {
            content: "";
            position: absolute;
            bottom: 0;
            left: 0;
            width: 0%;
            height: 2px;
            background-color: #2563eb;
            /* Tailwind: blue-600 */
            transition: width 0.3s ease;
        }

        .prose a:hover::after {
            width: 100%;
        }
    </style>


    {{-- พื้นหลังสีเทาอ่อน --}}
    <div class="bg-tech-slate-light py-8 sm:py-12">
        {{-- การ์ดสีขาวสำหรับเนื้อหา --}}
        <div class="container mx-auto max-w-4xl px-0 sm:px-6 lg:px-8">
            <div class="bg-white rounded-lg shadow-xl overflow-hidden">


                <div class="w-full h-64 md:h-96 bg-gray-100 flex items-center justify-center overflow-hidden">
                    <img class="h-full w-auto object-contain"
                        src="{{ $post->image_path ? Storage::url($post->image_path) : asset('images/nopic.png') }}"
                        alt="{{ $post->title }}" loading="lazy">
                </div>

                <div class="p-6 md:p-10">

                    <div class="flex items-center space-x-4 text-sm text-gray-500 mb-2">
                        @if ($post->category)
                            <span class="inline-flex items-center font-medium text-tech-green-dark">
                                {{-- Optional: Icon for category --}}
                                <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10">
                                    </path>
                                </svg>
                                {{ $post->category->name }}
                            </span>
                            <span>|</span>
                        @endif
                        <span class="inline-flex items-center">
                            {{-- Optional: Icon for date --}}
                            <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                                </path>
                            </svg>
                            เผยแพร่: {{ $post->created_at?->format('d M Y') ?? 'N/A' }}
                        </span>
                    </div>

                    {{-- หัวข้อ --}}
                    <h1 class="mt-1 text-3xl md:text-4xl font-bold text-tech-slate-dark">{{ $post->title }}</h1>

                    <hr class="my-6 border-gray-200">

                    {{-- [ปรับปรุง] 2. ส่วนเนื้อหา: ใช้ {!! !!} (ถ้ามั่นใจว่า Sanitize แล้ว) + prose-lg + แต่งสีลิงก์ --}}
                    <div
                        class="prose prose-lg max-w-none text-gray-700
           prose-a:text-blue-600 prose-a:no-underline
           hover:prose-a:underline hover:prose-a:text-blue-800
           prose-img:rounded-lg prose-img:shadow-md
           break-words">
                        {!! $post->content !!}
                    </div>

                    {{-- ส่วนไฟล์ PDF --}}
                    @if ($post->pdf_path)
                        <hr class="my-6 border-gray-200">
                        <h3 class="text-xl font-semibold mb-4 text-tech-slate-dark">ไฟล์แนบ (PDF)</h3>
                        <div>
                            <a href="{{ Storage::url($post->pdf_path) }}" target="_blank"
                                class="inline-flex items-center px-4 py-2 bg-tech-green border border-transparent rounded-md
                                       font-semibold text-xs text-white uppercase tracking-widest
                                       hover:bg-tech-green-dark transition ease-in-out duration-150 shadow-sm hover:shadow-md">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                                </svg>
                                ดาวน์โหลด PDF
                            </a>
                        </div>
                    @endif


                    <hr class="my-8 border-gray-200">

                    {{-- [ปรับปรุง] 3. ส่วนโพสต์ที่เกี่ยวข้อง --}}

                    {{-- แถวที่ 1: กิจกรรมและประชาสัมพันธ์ (ใช้ตัวแปรเดิม) --}}
                    <h2 class="text-2xl font-bold mb-4">กิจกรรมและประชาสัมพันธ์</h2>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        @foreach ($relatedPosts as $related)
                            <x-post-card :post="$related" />
                        @endforeach
                    </div>

                    <hr class="my-8">

                    {{-- แถวที่ 2: ประกาศวิทยาลัยฯ (เพิ่มเข้ามาใหม่) --}}
                    <h2 class="text-2xl font-bold mb-4">ประกาศวิทยาลัยเทคนิคแม่สอด</h2>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        @foreach ($announcements as $announcement)
                            <x-post-card :post="$announcement" />
                        @endforeach
                    </div>

                    {{-- [ปรับปรุง] 4. ปุ่มกลับหน้าหลัก --}}
                    <div class="mt-10 pt-6 border-t border-gray-200">
                        <a href="{{ route('home') }}"
                            class="inline-flex items-center px-4 py-2 bg-gray-100 border border-gray-300 rounded-md
                                   font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm
                                   hover:bg-gray-200 transition ease-in-out duration-150">
                            <svg class="w-4 h-4 mr-2 rotate-180" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"></path>
                            </svg>
                            กลับหน้าหลัก
                        </a>
                    </div>
                </div>

            </div> {{-- จบการ์ดสีขาว --}}
        </div> {{-- จบ Container --}}
    </div> {{-- จบพื้นหลังสีเทา --}}
</x-public-layout>
