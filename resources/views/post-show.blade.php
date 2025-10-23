<x-public-layout>
    {{-- RE-DESIGN: (จาก Layout ล่าสุด) พื้นหลังสีเทาอ่อน --}}
    <div class="bg-tech-slate-light py-8 sm:py-12">
        {{-- RE-DESIGN: การ์ดสีขาวสำหรับเนื้อหา --}}
        <div class="container mx-auto max-w-4xl px-0 sm:px-6 lg:px-8">
            <div class="bg-white rounded-lg shadow-xl overflow-hidden">

                @if ($post->image_path)
                    <img class="h-96 w-full object-cover" src="{{ Storage::url($post->image_path) }}"
                        alt="{{ $post->title }}">
                @endif

                <div class="p-6 md:p-10">
                    {{-- RE-THEME: เปลี่ยนสี Category เป็นสีเขียว --}}
                    <span class="text-sm text-tech-green-dark font-semibold">{{ $post->category->name }}</span>
                    
                    {{-- RE-THEME: เปลี่ยนสีหัวข้อเป็นสีเทาเข้ม --}}
                    <h1 class="mt-2 text-3xl font-bold text-tech-slate-dark">{{ $post->title }}</h1>
                    
                    <div class="mt-2 text-sm text-gray-500">
                        เผยแพร่เมื่อ: {{ $post->created_at->format('d M Y') }}
                    </div>

                    <hr class="my-6">

                    {{-- ส่วนเนื้อหา (ใช้ @tailwindcss/typography) --}}
                    <div class="prose max-w-none text-gray-700">
                        {!! nl2br(e($post->content)) !!}
                        {{-- 
                            หมายเหตุ: ถ้าเนื้อหาใน $post->content เป็น HTML (เช่น จาก CKEditor)
                            ให้ใช้ {!! $post->content !!} แทนครับ
                            (แต่ต้องมั่นใจว่าข้อมูลสะอาด ปลอดภัยจาก XSS)
                        --}}
                    </div>

                    {{-- ส่วนไฟล์ PDF (RE-THEME: เปลี่ยนปุ่มเป็นสีเขียว) --}}
                    @if ($post->pdf_path)
                        <hr class="my-6">
                        <h3 class="text-xl font-semibold mb-4 text-tech-slate-dark">ไฟล์แนบ (PDF)</h3>
                        <div>
                            <a href="{{ Storage::url($post->pdf_path) }}" target="_blank"
                               class="inline-flex items-center px-4 py-2 bg-tech-green border border-transparent rounded-md 
                                      font-semibold text-xs text-white uppercase tracking-widest 
                                      hover:bg-tech-green-dark transition ease-in-out duration-150">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                                ดาวน์โหลด PDF
                            </a>
                        </div>
                    @endif

                    {{-- ส่วน Embed Link --}}
                    @if ($post->embed_link)
                        <hr class="my-6">
                        <h3 class="text-xl font-semibold mb-4 text-tech-slate-dark">ไฟล์แนบ (วิดีโอ/โพสต์)</h3>
                        @php
                            // (โค้ด PHP สำหรับ embed ของคุณเหมือนเดิม)
                            $embedHtml = '';
                            if (Str::contains($post->embed_link, ['youtube.com', 'youtu.be'])) {
                                preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $post->embed_link, $matches);
                                $youtubeId = $matches[1] ?? null;
                                if ($youtubeId) {
                                    $embedHtml = '<iframe class="w-full aspect-video rounded-lg" src="https://www.youtube.com/embed/' . $youtubeId . '" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>';
                                }
                            } elseif (Str::contains($post->embed_link, 'facebook.com')) {
                                $embedHtml = '<div class="fb-post" data-href="' . e($post->embed_link) . '" data-show-text="true" data-width="auto"></div>';
                            }
                        @endphp

                        @if ($embedHtml)
                            <div class="w-full">
                                {!! $embedHtml !!}
                            </div>
                        @else
                            <p class="text-gray-600">ไม่รองรับการแสดงผลลิงก์นี้: <a href="{{ $post->embed_link }}"
                                    target="_blank" class="text-tech-green-dark">{{ $post->embed_link }}</a></p>
                        @endif
                    @endif


                    {{-- ===== (ส่วนที่เพิ่มเข้ามา) ข่าวที่เกี่ยวข้อง ===== --}}
                    @if ($post->count() > 0)
                        <hr class="my-8">
                        <h2 class="text-2xl font-bold text-tech-slate-dark mb-4">ข่าวอื่นในประเภทนี้</h2>
                        
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            @foreach ($post as $related)
                                <a href="{{ route('post.show', $related) }}" 
                                   class="bg-white rounded-lg shadow-lg overflow-hidden group border border-gray-200 
                                          transition-all duration-300 hover:shadow-xl hover:-translate-y-1">
                                    <img class="h-32 w-full object-cover" 
                                         src="{{ $related->image_path ? Storage::url($related->image_path) : asset('images/placeholder-small.jpg') }}" 
                                         alt="{{ $related->title }}">
                                    <div class="p-4">
                                        <h4 class="font-semibold text-gray-900 group-hover:text-tech-green-dark transition-colors text-sm leading-tight">
                                            {{ $related->title }}
                                        </h4>
                                        <div class="mt-2 text-xs text-gray-500">
                                            {{ $related->created_at->diffForHumans() }}
                                        </div>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    @endif
                    {{-- ===== จบส่วนข่าวที่เกี่ยวข้อง ===== --}}


                    <div class="mt-10">
                        {{-- RE-THEME: เปลี่ยนสีลิงก์กลับ --}}
                        <a href="{{ route('home') }}" class="text-tech-green-dark hover:text-tech-green-dark font-semibold hover:underline">&larr; กลับหน้าหลัก</a>
                    </div>
                </div>

            </div> {{-- จบการ์ดสีขาว --}}
        </div> {{-- จบ Container --}}
    </div> {{-- จบพื้นหลังสีเทา --}}
</x-public-layout>