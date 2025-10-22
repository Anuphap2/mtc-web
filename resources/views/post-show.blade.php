<x-public-layout>
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        @if($post->image_path)
            <img class="h-96 w-full object-cover" src="{{ Storage::url($post->image_path) }}" alt="{{ $post->title }}">
        @endif

        <div class="p-6 md:p-10">
            <span class="text-sm text-gray-500">{{ $post->category->name }}</span>
            <h1 class="mt-2 text-3xl font-bold text-gray-900">{{ $post->title }}</h1>
            <div class="mt-2 text-sm text-gray-500">
                เผยแพร่เมื่อ: {{ $post->created_at->format('d M Y') }}
            </div>

            <hr class="my-6">

            {{-- ส่วนเนื้อหา --}}
            <div class="prose max-w-none text-gray-700">
                {!! nl2br(e($post->content)) !!} {{-- แสดงผลเนื้อหา (ป้องกัน XSS) --}}
            </div>

            {{-- ส่วน Embed Link --}}
            @if($post->embed_link)
                <hr class="my-6">
                <h3 class="text-xl font-semibold mb-4">ไฟล์แนบ (วิดีโอ/โพสต์)</h3>
                
                @php
                    $embedHtml = '';
                    // ตรวจสอบ YouTube
                    if (Str::contains($post->embed_link, ['youtube.com', 'youtu.be'])) {
                        preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $post->embed_link, $matches);
                        $youtubeId = $matches[1] ?? null;
                        if ($youtubeId) {
                            $embedHtml = '<iframe class="w-full aspect-video" src="https://www.youtube.com/embed/' . $youtubeId . '" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>';
                        }
                    } 
                    // ตรวจสอบ Facebook (แบบง่าย)
                    elseif (Str::contains($post->embed_link, 'facebook.com')) {
                        // Facebook embed ต้องใช้ JS SDK ซึ่งซับซ้อน
                        // วิธีที่ง่ายที่สุดคือการใช้ <iframe> แบบง่าย
                        $embedHtml = '<iframe src="https://www.facebook.com/plugins/post.php?href=' . urlencode($post->embed_link) . '&show_text=true&width=500" width="500" height="600" style="border:none;overflow:hidden" scrolling="no" frameborder="0" allowfullscreen="true" allow="autoplay; clipboard-write; encrypted-media; picture-in-picture; web-share"></iframe>';
                    }
                @endphp

                @if($embedHtml)
                    <div>
                        {!! $embedHtml !!}
                    </div>
                @else
                    <p class="text-gray-600">ไม่รองรับการแสดงผลลิงก์นี้: <a href="{{ $post->embed_link }}" target="_blank" class="text-blue-500">{{ $post->embed_link }}</a></p>
                @endif
            @endif

            <div class="mt-8">
                <a href="{{ route('home') }}" class="text-blue-500 hover:text-blue-700">&larr; กลับหน้าหลัก</a>
            </div>
        </div>
    </div>
</x-public-layout>