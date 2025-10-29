<x-public-layout>

    {{-- =========================================================
         SECTION 1: HERO SLIDER (Glassmorphism + Fullscreen)
    ========================================================== --}}
    @if ($featuredPosts?->count())
        <section class="relative w-full h-[600px] lg:h-[750px]">
            <div class="swiper mySwiper h-full overflow-hidden shadow-2xl relative group">
                <div class="swiper-wrapper">
                    @foreach ($featuredPosts as $featured)
                        <div class="swiper-slide relative group">
                            <a href="{{ route('post.show', $featured) }}" class="block h-full">
                                <!-- รูปพื้นหลัง -->
                                <img src="{{ $featured->image_path ? Storage::url($featured->image_path) : asset('images/placeholder-large.jpg') }}"
                                    alt="{{ $featured->title }}"
                                    class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105" />

                                <!-- Gradient overlay ให้ข้อความอ่านง่าย -->
                                <div class="absolute inset-0 bg-gradient-to-t from-black/50 via-black/20 to-transparent">
                                </div>

                                <!-- Glassmorphism text box -->
                                <div
                                    class="absolute bottom-8 right-8 md:right-16 p-6 md:p-10 bg-black/40 rounded-3xl text-white shadow-xl w-2/3 md:w-1/2 transition-transform duration-500 group-hover:translate-y-[-5px]">
                                    <span
                                        class="bg-tech-green/90 text-xs px-3 py-1 rounded-full uppercase tracking-wider">
                                        {{ $featured->category?->name ?? 'ข่าวสาร' }}
                                    </span>
                                    <h3 class="mt-3 text-2xl md:text-4xl font-bold line-clamp-2">{{ $featured->title }}
                                    </h3>
                                    <p class="mt-2 text-sm md:text-base text-gray-200 line-clamp-3 hidden sm:block">
                                        {{ Str::limit(strip_tags($featured->content), 120) }}
                                    </p>
                                    <span class="mt-4 inline-block text-xs text-gray-300">อ่านเพิ่มเติม →</span>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>

                <!-- Navigation -->
                <div
                    class="swiper-button-prev absolute left-4 top-1/2 -translate-y-1/2 z-20 w-12 h-12 rounded-full bg-white/20 hover:bg-white/50 flex items-center justify-center transition-opacity opacity-0 group-hover:opacity-100">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5"
                        stroke="currentColor" class="w-6 h-6 text-white">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5" />
                    </svg>
                </div>
                <div
                    class="swiper-button-next absolute right-4 top-1/2 -translate-y-1/2 z-20 w-12 h-12 rounded-full bg-white/20 hover:bg-white/50 flex items-center justify-center transition-opacity opacity-0 group-hover:opacity-100">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5"
                        stroke="currentColor" class="w-6 h-6 text-white">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                    </svg>
                </div>

                <!-- Pagination -->
                <div class="swiper-pagination !bottom-5 !left-1/2 !-translate-x-1/2 !w-auto z-10"></div>
            </div>
        </section>



    @endif

    {{-- =========================================================
         SECTION 2: DIRECTOR'S WELCOME
    ========================================================== --}}
    <section class="py-16 bg-gray-50">
        <div class="container mx-auto max-w-6xl px-4">
            <div
                class="flex flex-col md:flex-row items-center gap-12 bg-white/80 backdrop-blur-xl p-10 rounded-3xl shadow-2xl border border-gray-200">
                <div class="md:w-1/3 text-center">
                    <img src="{{ asset('images/images.jpg') }}" alt="นายเดโชวัต ทักคุ้ม"
                        class="w-60 h-60 md:w-64 md:h-64 rounded-full object-cover shadow-xl border-4 border-white hover:scale-105 transition-transform duration-300 mx-auto">
                </div>
                <div class="md:w-2/3 text-center md:text-left">
                    <h2 class="text-3xl md:text-4xl font-bold text-tech-slate-dark relative inline-block mb-6">
                        ยินดีต้อนรับ
                        <span class="absolute bottom-[-6px] left-0 h-1 w-20 bg-tech-green rounded-full"></span>
                    </h2>
                    <p class="text-xl font-semibold text-gray-800">นายเดโชวัต ทักคุ้ม</p>
                    <p class="text-gray-600 mb-4">ผู้อำนวยการวิทยาลัยเทคนิคแม่สอด</p>
                    <blockquote class="text-gray-700 italic border-l-4 border-tech-green pl-4 py-2">
                        "วิทยาลัยเทคนิคแม่สอด มุ่งมั่นพัฒนากำลังคนอาชีวศึกษาให้มีคุณภาพ..."
                    </blockquote>
                </div>
            </div>
        </div>
    </section>


    {{-- =========================================================
         SECTION 3: POSTS BY CATEGORY
    ========================================================== --}}
    <section class="py-16 bg-gray-50">
        <div class="container mx-auto max-w-7xl px-4 space-y-12">
            @foreach ($categoriesWithPosts as $category)
                <div
                    class="bg-white rounded-3xl shadow-lg border border-gray-100 p-6 md:p-8 hover:shadow-2xl transition">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-3xl font-bold text-tech-slate-dark relative">
                            {{ $category->name }}
                            <span class="absolute bottom-[-6px] left-0 h-1 w-20 bg-tech-green rounded-full"></span>
                        </h2>
                        <a href="{{ route('category.show', $category) }}"
                            class="text-tech-green font-semibold flex items-center hover:underline">
                            ดูทั้งหมด
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 ml-1" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                            </svg>
                        </a>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                        @foreach ($category->posts as $post)
                            <a href="{{ route('post.show', $post) }}"
                                class="group relative block rounded-2xl overflow-hidden shadow-md hover:shadow-2xl transition transform hover:-translate-y-1">
                                <div class="relative h-60 overflow-hidden">
                                    <img src="{{ $post->image_path ? Storage::url($post->image_path) : asset('images/placeholder.jpg') }}"
                                        class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">
                                    <!-- Glass overlay -->
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
                        @endforeach
                    </div>
                </div>
            @endforeach
        </div>
    </section>



    {{-- =========================================================
         SECTION 4: E-SERVICE LINKS
    ========================================================== --}}
    <section class="py-14 bg-white">
        <div class="container mx-auto max-w-6xl px-4 text-center">
            <div class="relative inline-block mb-12">
                <h2 class="text-3xl md:text-4xl font-bold text-tech-slate-dark">บริการอิเล็กทรอนิกส์</h2>
                <div class="absolute bottom-[-10px] left-1/2 -translate-x-1/2 h-1 w-24 bg-tech-green rounded-full">
                </div>
            </div>
            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-x-6 gap-y-8 md:gap-x-8 md:gap-y-10">
                {{-- สมัครเรียน --}}
                <a href="https://admission.dbtmaesod.com" target="_blank"
                    class="p-6 bg-gray-50 rounded-xl shadow-sm hover:shadow-lg transition-all transform hover:-translate-y-1 text-center group border border-gray-100 hover:border-tech-green/50">
                    <div
                        class="w-16 h-16 mx-auto bg-emerald-100 text-tech-green-dark rounded-full flex items-center justify-center mb-4 transition duration-300 group-hover:bg-tech-green group-hover:text-white">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="w-8 h-8">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M4.26 10.147a60.438 60.438 0 00-.491 6.347A48.627 48.627 0 0112 20.904a48.627 48.627 0 018.232-4.41 60.46 60.46 0 00-.491-6.347" />
                        </svg>
                    </div>
                    <p class="font-semibold text-gray-700 text-sm group-hover:text-tech-green transition">สมัครเรียน</p>
                </a>

                {{-- EDR --}}
                <a href="https://edr.dbtmaesod.com" target="_blank"
                    class="p-6 bg-gray-50 rounded-xl shadow-sm hover:shadow-lg transition-all transform hover:-translate-y-1 text-center group border border-gray-100 hover:border-tech-green/50">
                    <div
                        class="w-16 h-16 mx-auto bg-blue-100 text-blue-600 rounded-full flex items-center justify-center mb-4 transition duration-300 group-hover:bg-blue-600 group-hover:text-white">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="w-8 h-8">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M3 13.5l7.5 7.5 7.5-7.5m0-9l-7.5 7.5-7.5-7.5" />
                        </svg>
                    </div>
                    <p class="font-semibold text-gray-700 text-sm group-hover:text-tech-green transition">EDR</p>
                </a>

                {{-- Email --}}
                <a href="https://mail.dbtmaesod.com" target="_blank"
                    class="p-6 bg-gray-50 rounded-xl shadow-sm hover:shadow-lg transition-all transform hover:-translate-y-1 text-center group border border-gray-100 hover:border-tech-green/50">
                    <div
                        class="w-16 h-16 mx-auto bg-purple-100 text-purple-600 rounded-full flex items-center justify-center mb-4 transition duration-300 group-hover:bg-purple-600 group-hover:text-white">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                            stroke-width="1.5" stroke="currentColor" class="w-8 h-8">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M21 12.75v-6a2.25 2.25 0 00-2.25-2.25h-13.5A2.25 2.25 0 003 6.75v6a2.25 2.25 0 002.25 2.25h13.5a2.25 2.25 0 002.25-2.25z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 6l9 6 9-6" />
                        </svg>
                    </div>
                    <p class="font-semibold text-gray-700 text-sm group-hover:text-tech-green transition">Email</p>
                </a>

                {{-- V-COP --}}
                <a href="https://vcop.dbtmaesod.com" target="_blank"
                    class="p-6 bg-gray-50 rounded-xl shadow-sm hover:shadow-lg transition-all transform hover:-translate-y-1 text-center group border border-gray-100 hover:border-tech-green/50">
                    <div
                        class="w-16 h-16 mx-auto bg-orange-100 text-orange-600 rounded-full flex items-center justify-center mb-4 transition duration-300 group-hover:bg-orange-600 group-hover:text-white">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                            stroke-width="1.5" stroke="currentColor" class="w-8 h-8">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                        </svg>
                    </div>
                    <p class="font-semibold text-gray-700 text-sm group-hover:text-tech-green transition">V-COP</p>
                </a>
            </div>

        </div>
    </section>

    {{-- =========================================================
         SECTION 5: DEPARTMENTS
    ========================================================== --}}
    <section class="py-14 bg-tech-slate-light">
        <div class="container mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="relative inline-block mb-12 text-center w-full">
                <h2 class="text-3xl md:text-4xl font-bold text-tech-slate-dark">สาขาวิชา</h2>
                <p class="mt-2 text-lg text-gray-600">เลือกเส้นทางอาชีพที่เหมาะกับคุณ</p>
                <div class="absolute bottom-[-10px] left-1/2 -translate-x-1/2 h-1 w-24 bg-tech-green rounded-full">
                </div>
            </div>
            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-6 text-center">

                {{-- เทคโนโลยีธุรกิจดิจิทัล --}}
                <div
                    class="flex flex-col items-center space-y-2 p-4 bg-white rounded-xl shadow hover:shadow-lg transition">
                    <svg class="w-16 h-16 text-blue-500" fill="none" stroke="currentColor" stroke-width="2"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                    </svg>
                    <h3 class="text-md font-semibold text-gray-800">เทคโนโลยีธุรกิจดิจิทัล</h3>
                    <p class="text-xs text-gray-600">ผสมผสานเทคโนโลยีดิจิทัลกับการดำเนินธุรกิจยุคใหม่</p>
                </div>

                {{-- การบัญชี --}}
                <div
                    class="flex flex-col items-center space-y-2 p-4 bg-white rounded-xl shadow hover:shadow-lg transition">
                    <svg class="w-16 h-16 text-green-500" fill="none" stroke="currentColor" stroke-width="2"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                    <h3 class="text-md font-semibold text-gray-800">การบัญชี</h3>
                    <p class="text-xs text-gray-600">เสริมสร้างความรู้ด้านบัญชี และการเงินเพื่อธุรกิจ</p>
                </div>

                {{-- การตลาด --}}
                <div
                    class="flex flex-col items-center space-y-2 p-4 bg-white rounded-xl shadow hover:shadow-lg transition">
                    <svg class="w-16 h-16 text-red-500" fill="none" stroke="currentColor" stroke-width="2"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M3 8l7-3 7 3 4-2v12l-4-2-7 3-7-3-4 2V6l4 2z" />
                    </svg>
                    <h3 class="text-md font-semibold text-gray-800">การตลาด</h3>
                    <p class="text-xs text-gray-600">พัฒนาทักษะการวางแผน และการสื่อสารทางการตลาด</p>
                </div>

                {{-- การจัดการโลจิสติกส์ --}}
                <div
                    class="flex flex-col items-center space-y-2 p-4 bg-white rounded-xl shadow hover:shadow-lg transition">
                    <svg class="w-16 h-16 text-yellow-500" fill="none" stroke="currentColor" stroke-width="2"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 6h18v12H3z" />
                    </svg>
                    <h3 class="text-md font-semibold text-gray-800">การจัดการโลจิสติกส์</h3>
                    <p class="text-xs text-gray-600">เรียนรู้การบริหารจัดการคลังสินค้า และระบบขนส่ง</p>
                </div>

                {{-- การโรงแรม --}}
                <div
                    class="flex flex-col items-center space-y-2 p-4 bg-white rounded-xl shadow hover:shadow-lg transition">
                    <svg class="w-16 h-16 text-purple-500" fill="none" stroke="currentColor" stroke-width="2"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 12h18M3 6h18M3 18h18" />
                    </svg>
                    <h3 class="text-md font-semibold text-gray-800">การโรงแรม</h3>
                    <p class="text-xs text-gray-600">ฝึกทักษะงานบริการและการจัดการในธุรกิจโรงแรม</p>
                </div>

                {{-- ช่างยนต์ --}}
                <div
                    class="flex flex-col items-center space-y-2 p-4 bg-white rounded-xl shadow hover:shadow-lg transition">
                    <svg class="w-16 h-16 text-gray-700" fill="none" stroke="currentColor" stroke-width="2"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 16l-2 4h18l-2-4M6 8h12v8H6V8z" />
                    </svg>
                    <h3 class="text-md font-semibold text-gray-800">ช่างยนต์</h3>
                    <p class="text-xs text-gray-600">เรียนรู้การซ่อมบำรุง และเทคโนโลยียานยนต์สมัยใหม่</p>
                </div>

                {{-- ช่างไฟฟ้ากำลัง --}}
                <div
                    class="flex flex-col items-center space-y-2 p-4 bg-white rounded-xl shadow hover:shadow-lg transition">
                    <svg class="w-16 h-16 text-yellow-600" fill="none" stroke="currentColor" stroke-width="2"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13 2L3 14h9l-1 8 10-12h-9l1-8z" />
                    </svg>
                    <h3 class="text-md font-semibold text-gray-800">ช่างไฟฟ้ากำลัง</h3>
                    <p class="text-xs text-gray-600">พัฒนาทักษะด้านระบบไฟฟ้ากำลัง และการติดตั้งวงจร</p>
                </div>

                {{-- ช่างกลโรงงาน --}}
                <div
                    class="flex flex-col items-center space-y-2 p-4 bg-white rounded-xl shadow hover:shadow-lg transition">
                    <svg class="w-16 h-16 text-indigo-500" fill="none" stroke="currentColor" stroke-width="2"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 16h16v4H4v-4zM4 8h16v4H4V8z" />
                    </svg>
                    <h3 class="text-md font-semibold text-gray-800">ช่างกลโรงงาน</h3>
                    <p class="text-xs text-gray-600">ฝึกปฏิบัติงานเครื่องจักรกล และการผลิตชิ้นส่วน</p>
                </div>

                {{-- เทคนิคเครื่องกล --}}
                <div
                    class="flex flex-col items-center space-y-2 p-4 bg-white rounded-xl shadow hover:shadow-lg transition">
                    <svg class="w-16 h-16 text-pink-500" fill="none" stroke="currentColor" stroke-width="2"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16v12H4V6z" />
                    </svg>
                    <h3 class="text-md font-semibold text-gray-800">เทคนิคเครื่องกล</h3>
                    <p class="text-xs text-gray-600">ศึกษาระบบกลไก และการควบคุมเครื่องจักรกล</p>
                </div>

                {{-- เทคนิคเครื่องยนต์ --}}
                <div
                    class="flex flex-col items-center space-y-2 p-4 bg-white rounded-xl shadow hover:shadow-lg transition">
                    <svg class="w-16 h-16 text-orange-500" fill="none" stroke="currentColor" stroke-width="2"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 12h18v4H3v-4z" />
                    </svg>
                    <h3 class="text-md font-semibold text-gray-800">เทคนิคเครื่องยนต์</h3>
                    <p class="text-xs text-gray-600">พัฒนาทักษะด้านเครื่องยนต์และระบบส่งกำลัง</p>
                </div>

                {{-- ช่างอิเล็กทรอนิกส์ --}}
                <div
                    class="flex flex-col items-center space-y-2 p-4 bg-white rounded-xl shadow hover:shadow-lg transition">
                    <svg class="w-16 h-16 text-teal-500" fill="none" stroke="currentColor" stroke-width="2"
                        viewBox="0 0 24 24">
                        <circle cx="12" cy="12" r="9" stroke="currentColor" stroke-width="2" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v18M3 12h18" />
                    </svg>
                    <h3 class="text-md font-semibold text-gray-800">ช่างอิเล็กทรอนิกส์</h3>
                    <p class="text-xs text-gray-600">เรียนรู้การออกแบบวงจร และการซ่อมอุปกรณ์อิเล็กทรอนิกส์</p>
                </div>

                {{-- เทคโนโลยีอิเล็กทรอนิกส์ --}}
                <div
                    class="flex flex-col items-center space-y-2 p-4 bg-white rounded-xl shadow hover:shadow-lg transition">
                    <svg class="w-16 h-16 text-blue-600" fill="none" stroke="currentColor" stroke-width="2"
                        viewBox="0 0 24 24">
                        <rect x="4" y="4" width="16" height="16" stroke="currentColor" stroke-width="2" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 12h16M12 4v16" />
                    </svg>
                    <h3 class="text-md font-semibold text-gray-800">เทคโนโลยีอิเล็กทรอนิกส์</h3>
                    <p class="text-xs text-gray-600">พัฒนาเทคโนโลยีและนวัตกรรมในระบบอิเล็กทรอนิกส์</p>
                </div>

                {{-- ช่างก่อสร้าง --}}
                <div
                    class="flex flex-col items-center space-y-2 p-4 bg-white rounded-xl shadow hover:shadow-lg transition">
                    <svg class="w-16 h-16 text-gray-500" fill="none" stroke="currentColor" stroke-width="2"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 21V7l9-4 9 4v14H3z" />
                    </svg>
                    <h3 class="text-md font-semibold text-gray-800">ช่างก่อสร้าง</h3>
                    <p class="text-xs text-gray-600">ฝึกทักษะงานก่อสร้าง และออกแบบโครงสร้างอาคาร</p>
                </div>

                {{-- เทคโนโลยีเครื่องนุ่งห่ม --}}
                <div
                    class="flex flex-col items-center space-y-2 p-4 bg-white rounded-xl shadow hover:shadow-lg transition">
                    <svg class="w-16 h-16 text-pink-600" fill="none" stroke="currentColor" stroke-width="2"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 4h16v16H4V4z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 12h16M12 4v16" />
                    </svg>
                    <h3 class="text-md font-semibold text-gray-800">เทคโนโลยีเครื่องนุ่งห่ม</h3>
                    <p class="text-xs text-gray-600">ออกแบบแฟชั่น และสร้างผลิตภัณฑ์สิ่งทออย่างสร้างสรรค์</p>
                </div>

            </div>





        </div>
    </section>

    {{-- =========================================================
         SECTION 6: CTA APPLY
    ========================================================== --}}
    <section class="py-20 bg-gradient-to-r from-tech-slate-dark to-gray-800 text-white text-center">
        <h2 class="text-3xl md:text-4xl font-bold">ร่วมเป็นส่วนหนึ่งกับเรา</h2>
        <p class="mt-4 text-lg text-gray-300">เปิดรับสมัครนักเรียน นักศึกษาใหม่แล้ววันนี้!</p>
        <a href="https://admission.dbtmaesod.com" target="_blank"
            class="mt-8 inline-block px-8 py-4 bg-tech-green rounded-xl shadow-lg hover:bg-tech-green-dark transition transform hover:scale-105 font-semibold">
            สมัครเรียนออนไลน์
        </a>
    </section>


    {{-- =========================================================
         SWIPER SCRIPTS
    ========================================================== --}}
    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                const swiper = new Swiper('.mySwiper', {
                    loop: true,
                    speed: 700,
                    autoplay: {
                        delay: 5000,
                        disableOnInteraction: false
                    },
                    pagination: {
                        el: '.swiper-pagination',
                        clickable: true
                    },
                    navigation: {
                        nextEl: '.swiper-button-next',
                        prevEl: '.swiper-button-prev'
                    },
                });
            });
        </script>
    @endpush

</x-public-layout>
