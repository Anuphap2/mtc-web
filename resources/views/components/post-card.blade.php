@props(['post'])

<a href="{{ route('post.show', $post) }}"
    class="group relative block rounded-2xl overflow-hidden shadow-md hover:shadow-2xl transition transform hover:-translate-y-1">
    <div class="relative h-60 overflow-hidden">
        <img src="{{ $post->image_path ? Storage::url($post->image_path) : asset('images/placeholder.jpg') }}"
            alt="{{ $post->title }}"
            class="w-full h-full object-cover transition-transform duration-500">
        <div
            class="absolute inset-0 bg-black/25 backdrop-blur-sm opacity-0 group-hover:opacity-100 transition-opacity duration-300">
        </div>
    </div>
    <div
        class="absolute bottom-0 left-0 right-0 p-5 bg-gradient-to-t from-black/70 to-transparent text-white">
        <h3 class="font-semibold text-lg line-clamp-2">{{ $post->title }}</h3>
        <p class="text-xs text-gray-300 mt-1">{{ $post->created_at?->diffForHumans() }}</p>
    </div>
</a>