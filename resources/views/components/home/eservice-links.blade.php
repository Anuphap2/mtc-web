@php
    // สร้าง Array ข้อมูล E-Services
    $services = [
        [
            'name' => 'สมัครเรียน',
            'url' => 'https://admission.dbtmaesod.com',
            'icon_color_class' => 'text-tech-green-dark',
            'bg_color_class' => 'bg-emerald-100', // ใช้ emerald ตามเดิมก็ได้ครับ
            'border_color_class' => 'border-emerald-200',
            'svg_path' =>
                '<path stroke-linecap="round" stroke-linejoin="round" d="M4.26 10.147a60.438 60.438 0 00-.491 6.347A48.627 48.627 0 0112 20.904a48.627 48.627 0 018.232-4.41 60.46 60.46 0 00-.491-6.347" />',
        ],
        [
            'name' => 'EDR',
            'url' => 'https://edr.dbtmaesod.com',
            'icon_color_class' => 'text-blue-600',
            'bg_color_class' => 'bg-blue-100',
            'border_color_class' => 'border-blue-200',
            'svg_path' =>
                '<path stroke-linecap="round" stroke-linejoin="round" d="M3 13.5l7.5 7.5 7.5-7.5m0-9l-7.5 7.5-7.5-7.5" />',
        ],
        [
            'name' => 'Email',
            'url' => 'https://mail.dbtmaesod.com',
            'icon_color_class' => 'text-purple-600',
            'bg_color_class' => 'bg-purple-100',
            'border_color_class' => 'border-purple-200',
            'svg_path' =>
                '<path stroke-linecap="round" stroke-linejoin="round" d="M21 12.75v-6a2.25 2.25 0 00-2.25-2.25h-13.5A2.25 2.25 0 003 6.75v6a2.25 2.25 0 002.25 2.25h13.5a2.25 2.25 0 002.25-2.25z" /><path stroke-linecap="round" stroke-linejoin="round" d="M3 6l9 6 9-6" />',
        ],
        [
            'name' => 'V-COP',
            'url' => 'https://vcop.dbtmaesod.com',
            'icon_color_class' => 'text-orange-600',
            'bg_color_class' => 'bg-orange-100',
            'border_color_class' => 'border-orange-200',
            'svg_path' => '<path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />',
        ],
    ];
@endphp

{{-- =========================================================
    SECTION 4: E-SERVICE LINKS (Redesign)
========================================================== --}}
<section class="py-14 bg-white">
    <div class="container mx-auto max-w-7xl px-4 text-center">
        <div class="relative inline-block mb-12">
            <h2 class="text-3xl md:text-4xl font-bold text-tech-slate-dark">บริการอิเล็กทรอนิกส์</h2>
            <div class="absolute bottom-[-10px] left-1/2 -translate-x-1/2 h-1 w-24 bg-tech-green rounded-full">
            </div>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-4 gap-6">

            @foreach ($services as $service)
                <a href="{{ $service['url'] }}" target="_blank"
                    class="p-6 bg-white rounded-2xl shadow-lg border border-gray-100 text-center group
                           transition-all transform hover:-translate-y-1 hover:shadow-xl hover:border-tech-green/50">

                    <div
                        class="w-20 h-20 mx-auto rounded-full flex items-center justify-center border-2 mb-5
                               {{ $service['bg_color_class'] }} {{ $service['border_color_class'] }}
                               transition duration-300">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="w-10 h-10 {{ $service['icon_color_class'] }}">
                            {!! $service['svg_path'] !!}
                        </svg>
                    </div>

                    <h3
                        class="font-semibold text-lg text-tech-slate-dark transition-colors group-hover:text-tech-green
                               inline-flex items-center justify-center">
                        {{ $service['name'] }}

                        <svg class="w-4 h-4 ml-2 opacity-0 transform -translate-x-2 
                                    group-hover:opacity-100 group-hover:translate-x-0 
                                    transition-all duration-300"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                        </svg>
                    </h3>
                </a>
            @endforeach

        </div>
    </div>
</section>
