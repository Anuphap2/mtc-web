<x-public-layout>

    {{-- 
        RE-DESIGN: เปลี่ยนจากแบนเนอร์เต็มจอ เป็นแบบ 2 คอลัมน์ 
        (ข้อความ + รูปภาพ) บนพื้นหลังสีเทาอ่อน
    --}}
    <section class="bg-tech-slate-light">
        <div class="container mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="grid md:grid-cols-2 items-center gap-12 py-16 md:py-24">

                {{-- Column 1: Text & CTA --}}
                <div>
                    <span class="text-tech-green-dark font-semibold">MAESOD TECHNICAL COLLEGE</span>
                    <h1 class="mt-2 text-4xl md:text-5xl font-extrabold text-tech-slate-dark leading-tight">
                        เปิดโลกทักษะวิชาชีพ
                        สร้างอนาคตที่มั่นคง
                    </h1>
                    <p class="mt-4 text-lg text-gray-600">
                        มุ่งผลิตและพัฒนากำลังคนอาชีวศึกษา สู่มาตรฐานสากล
                        พร้อมทักษะที่ตลาดแรงงานต้องการ
                    </p>
                    <a href="https://admission.dbtmaesod.com" target="_blank"
                        class="mt-8 inline-flex items-center px-8 py-3 bg-tech-green text-white font-semibold rounded-lg shadow-lg 
                              hover:bg-tech-green-dark transition duration-200 hover:scale-105">
                        สมัครเรียนออนไลน์
                        <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                        </svg>
                    </a>
                </div>

                {{-- Column 2: Image --}}
                <div class="hidden md:block">
                    <img src="{{ asset('images/banner.jpg') }}" alt="Hero Image"
                        class="rounded-lg shadow-xl aspect-square object-cover">
                </div>
            </div>
        </div>
    </section>

    {{-- Section นี้ดีอยู่แล้วครับ (การ์ดไอคอน) คงเดิมไว้ --}}
    <section class="py-12 sm:py-16 bg-white">
        <div class="container mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="mb-10 text-center">
                <span class="block w-20 h-1 bg-tech-green mx-auto mb-4"></span>
                <h2 class="text-4xl font-bold text-tech-slate-dark">E-SERVICE</h2>
                <p class="mt-2 text-lg text-gray-600">ระบบสารสนเทศสำหรับนักศึกษาและบุคลากร</p>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                {{-- (โค้ดการ์ด E-Service ทั้ง 4 อัน... เหมือนเดิม) --}}
                <a href="https://admission.dbtmaesod.com" target="_blank"
                    class="flex flex-col items-center justify-center p-6 bg-white rounded-lg shadow-lg hover:shadow-xl hover:-translate-y-1 transition-all duration-300 group">
                    <div class="p-4 bg-emerald-50 rounded-full"> <svg class="w-8 h-8 text-tech-green-dark"
                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M4.26 10.147a60.438 60.438 0 0 0-.491 6.347A48.627 48.627 0 0 1 12 20.904a48.627 48.627 0 0 1 8.232-4.41 60.46 60.46 0 0 0-.491-6.347m-15.482 0a50.57 50.57 0 0 0-2.658-.813A59.906 59.906 0 0 1 12 3.493a59.903 59.903 0 0 1 10.399 5.84c-.896.248-1.783.52-2.658.814m-15.482 0A50.697 50.697 0 0 1 12 13.489a50.702 50.702 0 0 1 7.74-3.342M6.75 15a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5Zm0 0v-3.675A55.378 55.378 0 0 1 12 8.443m-7.007 11.55A5.981 5.981 0 0 0 6.75 15.75v-1.5" />
                        </svg> </div>
                    <h3
                        class="mt-4 font-semibold text-gray-800 text-center group-hover:text-tech-green-dark transition-colors">
                        ระบบรับสมัครนักศึกษา</h3>
                </a>
                <a href="http://maesod.appedr.com/edr/login.do" target="_blank"
                    class="flex flex-col items-center justify-center p-6 bg-white rounded-lg shadow-lg hover:shadow-xl hover:-translate-y-1 transition-all duration-300 group">
                    <div class="p-4 bg-emerald-50 rounded-full"> <svg class="w-8 h-8 text-tech-green-dark"
                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M9 17.25v1.007a3 3 0 0 1-.879 2.122L7.5 21h9l-1.621-.871A3 3 0 0 1 15 18.257V17.25m6-12V15a2.25 2.25 0 0 1-2.25 2.25H5.25A2.25 2.25 0 0 1 3 15V5.25A2.25 2.25 0 0 1 5.25 3h13.5A2.25 2.25 0 0 1 21 5.25Z" />
                        </svg> </div>
                    <h3
                        class="mt-4 font-semibold text-gray-800 text-center group-hover:text-tech-green-dark transition-colors">
                        EDR SYSTEM (ศธ.02)</h3>
                </a>
                <a href="https://webmail.maesod.ac.th/" target="_blank"
                    class="flex flex-col items-center justify-center p-6 bg-white rounded-lg shadow-lg hover:shadow-xl hover:-translate-y-1 transition-all duration-300 group">
                    <div class="p-4 bg-emerald-50 rounded-full"> <svg class="w-8 h-8 text-tech-green-dark"
                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M21.75 6.75v10.5a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25m19.5 0v.243a2.25 2.25 0 0 1-1.07 1.916l-7.5 4.615a2.25 2.25 0 0 1-2.36 0L3.32 8.91a2.25 2.25 0 0 1-1.07-1.916V6.75" />
                        </svg> </div>
                    <h3
                        class="mt-4 font-semibold text-gray-800 text-center group-hover:text-tech-green-dark transition-colors">
                        ระบบ e-mail วิทยาลัย</h3>
                </a>
                <a href="https://v-cop.go.th/v-cop/" target="_blank"
                    class="flex flex-col items-center justify-center p-6 bg-white rounded-lg shadow-lg hover:shadow-xl hover:-translate-y-1 transition-all duration-300 group">
                    <div class="p-4 bg-emerald-50 rounded-full"> <svg class="w-8 h-8 text-tech-green-dark"
                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M20.25 14.15v4.05a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25v-4.05m19.5 0a2.25 2.25 0 0 0-2.25-2.25H5.25a2.25 2.25 0 0 0-2.25 2.25m19.5 0v-2.1a2.25 2.25 0 0 0-2.25-2.25H5.25a2.25 2.25 0 0 0-2.25 2.25v2.1m19.5 0A2.25 2.25 0 0 1 19.5 12h-15a2.25 2.25 0 0 1-2.25 2.25m19.5 0v.243a2.25 2.25 0 0 1-1.07 1.916l-7.5 4.615a2.25 2.25 0 0 1-2.36 0L3.32 16.31a2.25 2.25 0 0 1-1.07-1.916V14.15" />
                        </svg> </div>
                    <h3
                        class="mt-4 font-semibold text-gray-800 text-center group-hover:text-tech-green-dark transition-colors">
                        ศูนย์กำลังคน V-COP</h3>
                </a>
            </div>
        </div>
    </section>

    <section class="py-12 sm:py-16 bg-tech-slate-light">
        <div class="container mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

            <div class="mb-10 text-center">
                <span class="block w-20 h-1 bg-tech-green mx-auto mb-4"></span>
                <h2 class="text-4xl font-bold text-tech-slate-dark">กิจกรรมและประชาสัมพันธ์</h2>
                <p class="mt-2 text-lg text-gray-600">ติดตามข่าวสารล่าสุดจาก MTC</p>
            </div>

            {{-- RE-DESIGN: เปลี่ยนเป็น Layout ข่าวเด่น + ข่าวรอง --}}
            <div class="grid lg:grid-cols-3 gap-8">

                @if ($posts->count() > 0)
                    {{-- ข่าวเด่น (ซ้าย) --}}
                    @php $featuredPost = $posts->first(); @endphp
                    <div
                        class="lg:col-span-2 bg-white rounded-lg shadow-lg overflow-hidden group border border-gray-200">
                        <a href="{{ route('post.show', $featuredPost) }}" class="block overflow-hidden">
                            <img class="h-80 w-full object-cover transition duration-300 ease-in-out group-hover:scale-105"
                                src="{{ $featuredPost->image_path ? Storage::url($featuredPost->image_path) : asset('images/placeholder.jpg') }}"
                                alt="{{ $featuredPost->title }}">
                        </a>
                        <div class="p-6">
                            <span class="text-sm text-tech-green-dark font-semibold">
                                {{ $featuredPost->category->name }}
                            </span>
                            <h3 class="mt-2 font-bold text-2xl text-gray-900">
                                <a href="{{ route('post.show', $featuredPost) }}"
                                    class="hover:text-tech-green-dark transition duration-150">
                                    {{ $featuredPost->title }}
                                </a>
                            </h3>
                            <p class="mt-3 text-gray-600 text-sm">
                                {{ Str::limit(strip_tags($featuredPost->content), 150) }}
                            </p>
                            <div class="mt-4 pt-4 border-t border-gray-100 text-sm text-gray-500">
                                {{ $featuredPost->created_at->diffForHumans() }}
                            </div>
                        </div>
                    </div>

                    {{-- ข่าวรอง (ขวา) --}}
                    <div class="lg:col-span-1 space-y-6">
                        @forelse ($posts->skip(1)->take(3) as $post)
                            {{-- เอามาอีก 3 ข่าว --}}
                            <a href="{{ route('post.show', $post) }}"
                                class="flex items-center bg-white rounded-lg shadow-lg overflow-hidden group border border-gray-200 
                                      transition-all duration-300 hover:shadow-xl hover:-translate-y-1">
                                <img class="h-28 w-28 object-cover flex-shrink-0"
                                    src="{{ $post->image_path ? Storage::url($post->image_path) : asset('images/placeholder-small.jpg') }}"
                                    alt="{{ $post->title }}">
                                <div class="p-4">
                                    <span class="text-xs text-tech-green-dark font-semibold">
                                        {{ $post->category->name }}
                                    </span>
                                    <h4
                                        class="font-bold text-gray-900 group-hover:text-tech-green-dark transition-colors">
                                        {{ $post->title }}
                                    </h4>
                                    <div class="mt-1 text-xs text-gray-500">
                                        {{ $post->created_at->diffForHumans() }}
                                    </div>
                                </div>
                            </a>
                        @empty
                            {{-- ไม่มีข่าวรอง --}}
                        @endforelse

                        {{-- ปุ่มดูทั้งหมด --}}
                        <a href="#"
                            class="block w-full text-center px-4 py-3 bg-white rounded-lg shadow-lg text-tech-green-dark font-semibold hover:bg-gray-50 transition-all">
                            ดูกิจกรรมทั้งหมด
                        </a>
                    </div>
                @else
                    {{-- ไม่มีข่าวเลย --}}
                    <p class="col-span-3 text-center text-gray-500 text-lg">
                        ยังไม่มีข่าวสารและกิจกรรมในขณะนี้
                    </p>
                @endif
            </div>

            {{-- ซ่อน Pagination เดิมไปก่อน เพราะเรามีปุ่ม "ดูทั้งหมด" แล้ว --}}
            {{-- <div class="mt-12"> {{ $posts->links() }} </div> --}}
        </div>
    </section>

    <section class="py-12 sm:py-16 bg-white">
        <div class="container mx-auto max-w-5xl px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row items-center gap-8 md:gap-12">
                <div class="md:w-1/3 text-center">
                    <img src="{{ asset('images/images.jpg') }}"
                        class="w-64 h-64 rounded-full object-cover shadow-lg mx-auto border-8 border-tech-slate-light"
                        alt="ผู้อำนวยการ">
                </div>
                <div class="md:w-2/3">
                    <h2 class="text-3xl font-bold text-tech-slate-dark">สารจากผู้อำนวยการ</h2>
                    <p class="mt-4 text-xl text-gray-800 font-semibold">
                        นายเดโชวัต ทักคุ้ม
                    </p>
                    <p class="text-md text-gray-600">
                        ผู้อำนวยการวิทยาลัยเทคนิคแม่สอด
                    </p>
                    <p class="mt-6 text-lg text-gray-700 italic border-l-4 border-tech-green pl-4">
                        "วิทยาลัยเทคนิคแม่สอด มุ่งมั่นที่จะผลิตและพัฒนากำลังคนอาชีวศึกษาให้มีคุณภาพ..."
                    </p>
                </div>
            </div>
        </div>
    </section>

    <section class="py-12 sm:py-16 bg-tech-slate-light">
        <div class="container mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="mb-10 text-center">
                <span class="block w-20 h-1 bg-tech-green mx-auto mb-4"></span>
                <h2 class="text-4xl font-bold text-tech-slate-dark">สาขาวิชาในวิทยาลัย</h2>
                <p class="mt-2 text-lg text-gray-600">เลือกเส้นทางที่ใช่สำหรับคุณ</p>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                {{-- (โค้ดการ์ดสาขาวิชาทั้ง 8 อัน... เหมือนเดิม) --}}
                <a href="#" class="relative rounded-lg overflow-hidden shadow-lg group h-64"> <img
                        src="{{ asset('images/dept-mechanic.jpg') }}"
                        class="w-full h-full object-cover transition duration-300 group-hover:scale-110"
                        alt="ช่างยนต์">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/80 to-transparent"></div>
                    <h3
                        class="absolute bottom-4 left-4 text-2xl font-semibold text-white transition-all duration-300 group-hover:bottom-6">
                        ช่างยนต์</h3>
                </a>
                <a href="#" class="relative rounded-lg overflow-hidden shadow-lg group h-64"> <img
                        src="{{ asset('images/dept-electric.jpg') }}"
                        class="w-full h-full object-cover transition duration-300 group-hover:scale-110"
                        alt="ช่างไฟฟ้ากำลัง">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/80 to-transparent"></div>
                    <h3
                        class="absolute bottom-4 left-4 text-2xl font-semibold text-white transition-all duration-300 group-hover:bottom-6">
                        ช่างไฟฟ้ากำลัง</h3>
                </a>
                <a href="#" class="relative rounded-lg overflow-hidden shadow-lg group h-64"> <img
                        src="{{ asset('images/dept-electronic.jpg') }}"
                        class="w-full h-full object-cover transition duration-300 group-hover:scale-110"
                        alt="ช่างอิเล็กทรอนิกส์">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/80 to-transparent"></div>
                    <h3
                        class="absolute bottom-4 left-4 text-2xl font-semibold text-white transition-all duration-300 group-hover:bottom-6">
                        ช่างอิเล็กทรอนิกส์</h3>
                </a>
                <a href="#" class="relative rounded-lg overflow-hidden shadow-lg group h-64"> <img
                        src="{{ asset('images/dept-it.jpg') }}"
                        class="w-full h-full object-cover transition duration-300 group-hover:scale-110"
                        alt="เทคโนโลยีสารสนเทศ">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/80 to-transparent"></div>
                    <h3
                        class="absolute bottom-4 left-4 text-2xl font-semibold text-white transition-all duration-300 group-hover:bottom-6">
                        เทคโนโลยีสารสนเทศ</h3>
                </a>
                <a href="#" class="relative rounded-lg overflow-hidden shadow-lg group h-64"> <img
                        src="{{ asset('images/dept-account.jpg') }}"
                        class="w-full h-full object-cover transition duration-300 group-hover:scale-110"
                        alt="การบัญชี">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/80 to-transparent"></div>
                    <h3
                        class="absolute bottom-4 left-4 text-2xl font-semibold text-white transition-all duration-300 group-hover:bottom-6">
                        การบัญชี</h3>
                </a>
                <a href="#" class="relative rounded-lg overflow-hidden shadow-lg group h-64"> <img
                        src="{{ asset('images/dept-marketing.jpg') }}"
                        class="w-full h-full object-cover transition duration-300 group-hover:scale-110"
                        alt="การตลาด">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/80 to-transparent"></div>
                    <h3
                        class="absolute bottom-4 left-4 text-2xl font-semibold text-white transition-all duration-300 group-hover:bottom-6">
                        การตลาด</h3>
                </a>
                <a href="#" class="relative rounded-lg overflow-hidden shadow-lg group h-64"> <img
                        src="{{ asset('images/dept-hotel.jpg') }}"
                        class="w-full h-full object-cover transition duration-300 group-hover:scale-110"
                        alt="การโรงแรม">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/80 to-transparent"></div>
                    <h3
                        class="absolute bottom-4 left-4 text-2xl font-semibold text-white transition-all duration-300 group-hover:bottom-6">
                        การโรงแรม</h3>
                </a>
                <a href="#" class="relative rounded-lg overflow-hidden shadow-lg group h-64"> <img
                        src="{{ asset('images/dept-construct.jpg') }}"
                        class="w-full h-full object-cover transition duration-300 group-hover:scale-110"
                        alt="ช่างก่อสร้าง">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/80 to-transparent"></div>
                    <h3
                        class="absolute bottom-4 left-4 text-2xl font-semibold text-white transition-all duration-300 group-hover:bottom-6">
                        ช่างก่อสร้าง</h3>
                </a>
            </div>
        </div>
    </section>

    <section class="bg-tech-slate-dark text-white py-16">
        <div class="container mx-auto max-w-4xl px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-3xl md:text-4xl font-bold">รับสมัครนักศึกษาใหม่</h2>
            <p class="mt-4 text-lg text-slate-300">
                วิทยาลัยเทคนิคแม่สอด เปิดรับสมัครนักเรียน นักศึกษาใหม่
            </p>
            <a href="https://admission.dbtmaesod.com" target="_blank"
                class="mt-8 inline-block px-8 py-3 bg-tech-green text-white font-semibold rounded-lg shadow-lg 
                      hover:bg-tech-green-dark transition-all duration-200 hover:scale-105">
                ดูรายละเอียดและสมัครเรียน
            </a>
        </div>
    </section>

</x-public-layout>
