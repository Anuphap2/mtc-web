@php
    $director = \App\Models\DirectorMessage::first();
@endphp

<section class="py-16 bg-gray-50">
    <div class="container mx-auto max-w-7xl px-4">
        <div
            class="flex flex-col md:flex-row items-center gap-12 bg-white/80 backdrop-blur-xl p-10 rounded-3xl shadow-2xl border border-gray-200">
            <div class="md:w-1/3 text-center md:flex-shrink-0">
                <img src="{{ $director && $director->image ? asset('storage/' . $director->image) : asset('images/images.jpg') }}"
                    alt="{{ $director?->name ?? 'ผู้อำนวยการ' }}"
                    class="w-60 h-60 md:w-64 md:h-64 rounded-full object-cover shadow-xl border-4 border-white hover:scale-105 transition-transform duration-300 mx-auto">
            </div>
            <div class="md:w-2/3 text-center md:text-left">
                <div class="relative inline-block mb-6">
                    <h2 class="text-3xl md:text-4xl font-bold text-tech-slate-dark">
                        ยินดีต้อนรับ
                    </h2>
                    <span
                        class="absolute bottom-[-6px] left-1/2 -translate-x-1/2 md:left-0 md:translate-x-0 h-1 w-20 bg-tech-green rounded-full"></span>
                </div>
                <p class="text-xl font-semibold text-gray-800">{{ $director?->name }}</p>
                <p class="text-gray-600 mb-4">{{ $director?->position }}</p>
                <blockquote class="text-gray-700 italic border-l-4 border-tech-green pl-4 py-2 text-base md:text-lg">
                    “{{ $director?->message }}”
                </blockquote>
            </div>
        </div>
    </div>
</section>
