<x-public-layout>
    {{-- ส่วนหัว (Slot ชื่อ header) --}}
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('ประเภทข่าว: ') }} {{ $category->name }}
        </h2>
    </x-slot>

    {{-- ส่วนเนื้อหา (Slot หลัก) --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse ($posts as $post)
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <a href="{{ route('post.show', $post) }}">
                    @if($post->image_path)
                        <img class="h-48 w-full object-cover" src="{{ Storage::url($post->image_path) }}" alt="{{ $post->title }}">
                    @else
                        <div class="h-48 w-full bg-gray-200 flex items-center justify-center">
                            <span class="text-gray-500">ไม่มีรูปภาพ</span>
                        </div>
                    @endif
                </a>
                <div class="p-6">
                    <span class="text-sm text-gray-500">{{ $post->category->name }}</span>
                    <h3 class="mt-2 font-semibold text-lg text-gray-900">
                        <a href="{{ route('post.show', $post) }}">{{ $post->title }}</a>
                    </h3>
                    <p class="mt-2 text-gray-600 text-sm">
                        {{ Str::limit(strip_tags($post->content), 100) }}
                    </p>
                    <div class="mt-4 text-sm text-gray-500">
                        {{ $post->created_at->diffForHumans() }}
                    </div>
                </div>
            </div>
        @empty
            <p class="col-span-3 text-center text-gray-500">ยังไม่มีข่าวสารในประเภทนี้</p>
        @endforelse
    </div>

    {{-- Pagination --}}
    <div class="mt-8">
        {{ $posts->links() }}
    </div>
</x-public-layout>