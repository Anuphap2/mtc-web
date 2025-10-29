@php
    // Array ข้อมูลสาขา (ไม่เปลี่ยนแปลง)
    $departments = [
        [
            'name' => 'เทคโนโลยีธุรกิจดิจิทัล',
            'description' => 'ผสมผสานเทคโนโลยีดิจิทัลกับการดำเนินธุรกิจยุคใหม่',
            'icon_color_class' => 'text-blue-600',
            'bg_color_class' => 'bg-blue-100',
            'border_color_class' => 'border-blue-200',
            'svg_path' => '<path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />',
        ],
        [
            'name' => 'การบัญชี',
            'description' => 'เสริมสร้างความรู้ด้านบัญชี และการเงินเพื่อธุรกิจ',
            'icon_color_class' => 'text-green-600',
            'bg_color_class' => 'bg-green-100',
            'border_color_class' => 'border-green-200',
            'svg_path' => '<path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />',
        ],
        [
            'name' => 'การตลาด',
            'description' => 'พัฒนาทักษะการวางแผน และการสื่อสารทางการตลาด',
            'icon_color_class' => 'text-red-600',
            'bg_color_class' => 'bg-red-100',
            'border_color_class' => 'border-red-200',
            'svg_path' =>
                '<path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7-3 7 3 4-2v12l-4-2-7 3-7-3-4 2V6l4 2z" />',
        ],
        [
            'name' => 'การจัดการโลจิสติกส์',
            'description' => 'เรียนรู้การบริหารจัดการคลังสินค้า และระบบขนส่ง',
            'icon_color_class' => 'text-yellow-600',
            'bg_color_class' => 'bg-yellow-100',
            'border_color_class' => 'border-yellow-200',
            'svg_path' => '<path stroke-linecap="round" stroke-linejoin="round" d="M3 6h18v12H3z" />',
        ],
        [
            'name' => 'การโรงแรม',
            'description' => 'ฝึกทักษะงานบริการและการจัดการในธุรกิจโรงแรม',
            'icon_color_class' => 'text-purple-600',
            'bg_color_class' => 'bg-purple-100',
            'border_color_class' => 'border-purple-200',
            'svg_path' => '<path stroke-linecap="round" stroke-linejoin="round" d="M3 12h18M3 6h18M3 18h18" />',
        ],
        [
            'name' => 'ช่างยนต์',
            'description' => 'เรียนรู้การซ่อมบำรุง และเทคโนโลยียานยนต์สมัยใหม่',
            'icon_color_class' => 'text-gray-700',
            'bg_color_class' => 'bg-gray-200',
            'border_color_class' => 'border-gray-300',
            'svg_path' =>
                '<path stroke-linecap="round" stroke-linejoin="round" d="M5 16l-2 4h18l-2-4M6 8h12v8H6V8z" />',
        ],
        [
            'name' => 'ช่างไฟฟ้ากำลัง',
            'description' => 'พัฒนาทักษะด้านระบบไฟฟ้ากำลัง และการติดตั้งวงจร',
            'icon_color_class' => 'text-yellow-700',
            'bg_color_class' => 'bg-yellow-100',
            'border_color_class' => 'border-yellow-200',
            'svg_path' => '<path stroke-linecap="round" stroke-linejoin="round" d="M13 2L3 14h9l-1 8 10-12h-9l1-8z" />',
        ],
        [
            'name' => 'ช่างกลโรงงาน',
            'description' => 'ฝึกปฏิบัติงานเครื่องจักรกล และการผลิตชิ้นส่วน',
            'icon_color_class' => 'text-indigo-600',
            'bg_color_class' => 'bg-indigo-100',
            'border_color_class' => 'border-indigo-200',
            'svg_path' => '<path stroke-linecap="round" stroke-linejoin="round" d="M4 16h16v4H4v-4zM4 8h16v4H4V8z" />',
        ],
        [
            'name' => 'เทคนิคเครื่องกล',
            'description' => 'ศึกษาระบบกลไก และการควบคุมเครื่องจักรกล',
            'icon_color_class' => 'text-pink-600',
            'bg_color_class' => 'bg-pink-100',
            'border_color_class' => 'border-pink-200',
            'svg_path' => '<path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16v12H4V6z" />',
        ],
        [
            'name' => 'เทคนิคเครื่องยนต์',
            'description' => 'พัฒนาทักษะด้านเครื่องยนต์และระบบส่งกำลัง',
            'icon_color_class' => 'text-orange-600',
            'bg_color_class' => 'bg-orange-100',
            'border_color_class' => 'border-orange-200',
            'svg_path' => '<path stroke-linecap="round" stroke-linejoin="round" d="M3 12h18v4H3v-4z" />',
        ],
        [
            'name' => 'ช่างอิเล็กทรอนิกส์',
            'description' => 'เรียนรู้การออกแบบวงจร และการซ่อมอุปกรณ์อิเล็กทรอนิกส์',
            'icon_color_class' => 'text-teal-600',
            'bg_color_class' => 'bg-teal-100',
            'border_color_class' => 'border-teal-200',
            'svg_path' =>
                '<circle cx="12" cy="12" r="9" stroke="currentColor" stroke-width="2" /><path stroke-linecap="round" stroke-linejoin="round" d="M12 3v18M3 12h18" />',
        ],
        [
            'name' => 'เทคโนโลยีอิเล็กทรอนิกส์',
            'description' => 'พัฒนาเทคโนโลยีและนวัตกรรมในระบบอิเล็กทรอนิกส์',
            'icon_color_class' => 'text-blue-700',
            'bg_color_class' => 'bg-blue-100',
            'border_color_class' => 'border-blue-200',
            'svg_path' =>
                '<rect x="4" y="4" width="16" height="16" stroke="currentColor" stroke-width="2" /><path stroke-linecap="round" stroke-linejoin="round" d="M4 12h16M12 4v16" />',
        ],
        [
            'name' => 'ช่างก่อสร้าง',
            'description' => 'ฝึกทักษะงานก่อสร้าง และออกแบบโครงสร้างอาคาร',
            'icon_color_class' => 'text-gray-600',
            'bg_color_class' => 'bg-gray-200',
            'border_color_class' => 'border-gray-300',
            'svg_path' => '<path stroke-linecap="round" stroke-linejoin="round" d="M3 21V7l9-4 9 4v14H3z" />',
        ],
        [
            'name' => 'เทคโนโลยีเครื่องนุ่งห่ม',
            'description' => 'ออกแบบแฟชั่น และสร้างผลิตภัณฑ์สิ่งทออย่างสร้างสรรค์',
            'icon_color_class' => 'text-pink-700',
            'bg_color_class' => 'bg-pink-100',
            'border_color_class' => 'border-pink-200',
            'svg_path' =>
                '<path stroke-linecap="round" stroke-linejoin="round" d="M4 4h16v16H4V4z" /><path stroke-linecap="round" stroke-linejoin="round" d="M4 12h16M12 4v16" />',
        ],
    ];
@endphp

{{-- =========================================================
    SECTION 5: DEPARTMENTS (Redesign 2.0)
========================================================== --}}
<section class="py-14 bg-tech-slate-light">
    <div class="container mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="relative inline-block mb-12 text-center w-full">
            <h2 class="text-3xl md:text-4xl font-bold text-tech-slate-dark">สาขาวิชา</h2>
            <p class="mt-2 text-lg text-gray-600">เลือกเส้นทางอาชีพที่เหมาะกับคุณ</p>
            <div class="absolute bottom-[-10px] left-1/2 -translate-x-1/2 h-1 w-24 bg-tech-green rounded-full">
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 pt-5">

            {{-- วนลูปข้อมูลสาขาจาก Array --}}
            @foreach ($departments as $dept)
                <div class="relative p-6 bg-white rounded-2xl shadow-lg transition-shadow hover:shadow-xl h-full">

                    <div class="absolute top-0 right-0 -mt-5 mr-3">
                        <div
                            class="flex items-center justify-center w-16 h-16 rounded-full border-4 border-tech-slate-light {{ $dept['bg_color_class'] }}">
                            <svg class="w-8 h-8 {{ $dept['icon_color_class'] }}" fill="none" stroke="currentColor"
                                stroke-width="2" viewBox="0 0 24 24">
                                {!! $dept['svg_path'] !!}
                            </svg>
                        </div>
                    </div>

                    <div class="pt-8"> {{-- เพิ่ม pt-8 เพื่อให้มีที่ว่างใต้ไอคอน --}}
                        <h3 class="text-xl font-bold text-tech-slate-dark mb-1">{{ $dept['name'] }}</h3>
                        <p class="text-sm text-gray-600">{{ $dept['description'] }}</p>
                    </div>
                </div>
            @endforeach

        </div>
    </div>
</section>
