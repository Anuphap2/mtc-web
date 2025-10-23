<x-public-layout>
    {{-- Section Header --}}
    <section class="bg-tech-slate-light py-10">
        <div class="container mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 text-center">
            <h1 class="text-4xl font-bold text-tech-slate-dark">ข่าวสารทั้งหมด</h1>
            <p class="mt-2 text-lg text-gray-600">รวมข่าวสารและกิจกรรมทั้งหมดจาก MTC</p>
        </div>
    </section>

    {{-- Section Content --}}
    <section class="py-12 sm:py-16 bg-white">
        <div class="container mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            {{-- Grid แสดงข่าว (3 columns) --}}
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @forelse ($posts as $post)
                    <div
                        class="bg-white rounded-lg shadow-lg overflow-hidden flex flex-col group border border-gray-200 transition-all duration-300 hover:shadow-2xl hover:-translate-y-2">
                        <a href="{{ route('post.show', $post) }}" class="block overflow-hidden">
                            <img class="h-56 w-full object-cover transition duration-300 ease-in-out group-hover:scale-105"
                                src="{{ $post->image_path ? Storage::url($post->image_path) : asset('images/placeholder.jpg') }}"
                                alt="{{ $post->title }}">
                        </a>
                        <div class="p-6 flex-1 flex flex-col">
                            <span class="text-sm text-tech-green-dark font-semibold">
                                {{ $post->category->name }}
                            </span>
                            <h3 class="mt-2 font-bold text-xl text-gray-900">
                                <a href="{{ route('post.show', $post) }}"
                                    class="hover:text-tech-green-dark transition duration-150 line-clamp-2">
                                    {{-- Add line-clamp --}}
                                    {{ $post->title }}
                                </a>
                            </h3>
                            <p class="mt-3 text-gray-600 text-sm flex-grow line-clamp-3"> {{-- Add line-clamp --}}
                                {{ Str::limit(strip_tags($post->content), 120) }}
                            </p>
                            <div class="mt-4 pt-4 border-t border-gray-100 text-sm text-gray-500">
                                {{ $post->created_at->diffForHumans() }}
                            </div>
                        </div>
                    </div>
                @empty
                    <p class="md:col-span-2 lg:col-span-3 text-center text-gray-500 text-lg">
                        ยังไม่มีข่าวสารในขณะนี้
                    </p>
                @endforelse
            </div>

            {{-- Pagination --}}
            <div class="mt-12">
                {{ $posts->links() }} {{-- Tailwind styled pagination --}}
            </div>
        </div>
    </section>
</x-public-layout>
