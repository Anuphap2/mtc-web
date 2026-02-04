<x-public-layout>

    <x-modal name="mourning-modal" :show="true" maxWidth="2xl">
        <div class="relative p-10 text-center bg-white border-4 border-double border-gray-300">
            {{-- รูปพระบรมฉายาลักษณ์ (ใส่ Filter Grayscale) --}}
            <div class="mb-6">
                <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQtWbalrvNJ5P2X1iuOiP9p5Q5INLWVyqYDvA&s"
                    alt="สมเด็จพระนางเจ้าสิริกิติ์ พระบรมราชินีนาถ พระบรมราชชนนีพันปีหลวง"
                    class="mx-auto max-h-[450px] w-auto shadow-md grayscale">
            </div>

            {{-- ข้อความแสดงความไว้อาลัย --}}
            <div class="space-y-6">
                <h2 class="text-2xl font-bold text-gray-800">น้อมรำลึกในพระมหากรุณาธิคุณอันหาที่สุดมิได้</h2>

                <div class="text-lg text-gray-700 leading-relaxed italic">
                    <p>ข้าพระพุทธเจ้า คณะผู้บริหาร ครู บุคลากร และนักเรียน นักศึกษา</p>
                    <p class="font-bold text-gray-900">วิทยาลัยเทคนิคแม่สอด</p>
                    <p>ขอน้อมเกล้าน้อมกระหม่อมรำลึกในพระมหากรุณาธิคุณ</p>
                    <p>สมเด็จพระนางเจ้าสิริกิติ์ พระบรมราชินีนาถ พระบรมราชชนนีพันปีหลวง</p>
                </div>

                <p class="text-md text-gray-500">สถิตในดวงใจตราบนิจนิรันดร์</p>
            </div>

            {{-- ปุ่มเข้าสู่เว็บไซต์ --}}
            <div class="mt-8 border-t border-gray-100 pt-6">
                <button @click="$dispatch('close')"
                    class="px-12 py-4 bg-gradient-to-b from-gray-700 to-gray-900 text-gray-100 font-serif border-b-4 border-gray-950 rounded shadow-[0_10px_20px_rgba(0,0,0,0.3)] hover:brightness-110 hover:-translate-y-0.5 active:translate-y-0.5 active:border-b-0 transition-all duration-150">
                    <span class="tracking-widest">เข้าสู่เว็บไซต์</span>
                </button>
            </div>
        </div>
    </x-modal>
    {{-- 1. HERO SLIDER --}}
    <x-home.hero-slider :featuredPosts="$featuredPosts" />

    {{-- 2. DIRECTOR'S WELCOME --}}
    <x-home.director-welcome />

    {{-- 3. POSTS BY CATEGORY --}}
    <x-home.category-posts :categoriesWithPosts="$categoriesWithPosts" />

    <div id="video-gallery" class="row">
        <p id="loading">กำลังดึงวิดีโอลาสุด...</p>
    </div>

    <script>
        (async function() {
            const pageId = 'Mtcpr619'; // ใส่แค่ ID หรือ Username เพจ
            const container = document.getElementById('video-gallery');

            try {
                // ดึง HTML ผ่าน Proxy เพื่อเลี่ยง CORS
                const response = await fetch(
                    `https://api.allorigins.win/get?url=${encodeURIComponent('https://www.facebook.com/' + pageId + '/videos')}`
                    );
                const data = await response.json();
                const html = data.contents;

                // Regex ตัวนี้จะดึงเลข 15-16 หลักที่เป็น Video ID ได้แม่นขึ้น
                const regex = /"videoID":"(\d+)"/g;
                let matches;
                const videoIds = [];

                while ((matches = regex.exec(html)) !== null) {
                    videoIds.push(matches[1]);
                }

                const uniqueIds = [...new Set(videoIds)].slice(0, 6);

                if (uniqueIds.length === 0) {
                    document.getElementById('loading').innerText = 'ไม่พบวิดีโอสาธารณะในเพจนี้';
                    return;
                }

                container.innerHTML = '';
                uniqueIds.forEach(id => {
                    const col = document.createElement('div');
                    col.className = 'col-md-4 mb-4';
                    col.innerHTML = `
                <div style="background:#000; border-radius:8px; overflow:hidden;">
                    <iframe 
                        src="https://www.facebook.com/plugins/video.php?href=https://www.facebook.com/watch/?v=${id}&show_text=0" 
                        width="100%" height="250" style="border:none;overflow:hidden" scrolling="no" 
                        frameborder="0" allowfullscreen="true"
                        allow="autoplay; clipboard-write; encrypted-media; picture-in-picture; web-share">
                    </iframe>
                </div>
            `;
                    container.appendChild(col);
                });
            } catch (error) {
                console.error(error);
                document.getElementById('loading').innerText = 'ระบบดึงข้อมูลขัดข้อง';
            }
        })();
    </script>

    {{-- 4. E-SERVICE LINKS --}}
    <x-home.eservice-links />

    {{-- 5. DEPARTMENTS --}}
    <x-home.departments />

    {{-- 6. CTA APPLY --}}
    <x-home.cta-apply />

    <section class="py-16 bg-white">
        <div class="max-w-6xl mx-auto px-4">
            <div class="text-center mb-10">
                <h2 class="text-4xl font-extrabold text-gray-900 tracking-tight">MTC <span
                        class="text-blue-600">Present</span></h2>
                <div class="h-1 w-20 bg-blue-600 mx-auto mt-4 rounded-full"></div>
            </div>

            <div class="relative aspect-video rounded-2xl overflow-hidden shadow-2xl border-4 border-gray-100 group">
                <iframe class="absolute inset-0 w-full h-full"
                    src="https://www.youtube.com/embed/odsuzMewbFM?si=wkc1Xel_GeTFoEDh" title="MTC Video"
                    frameborder="0"
                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                    allowfullscreen></iframe>
            </div>
            <p class="mt-6 text-center text-gray-500 text-lg font-medium italic">
                "วิดีโอประชาสัมพันธ์วิทยาลัยเทคนิคแม่สอด"
            </p>
        </div>
    </section>

    <section class="py-16 bg-gray-50 border-t border-gray-100">
        <div class="max-w-7xl mx-auto px-4">
            <div class="flex flex-col md:flex-row justify-between items-end mb-12">
                <div>
                    <h2 class="text-3xl font-bold text-gray-800">MTC Start up <span
                            class="text-red-600">FC.D.I.Y.</span></h2>
                    <p class="text-gray-500 mt-2 text-lg font-['Sarabun']">
                        คลังวิดีโอความรู้และการสอนจากคุณครูผู้เชี่ยวชาญ</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 font-['Sarabun']">

                <div
                    class="bg-white rounded-xl overflow-hidden shadow-sm hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2 border border-gray-100">
                    <div class="aspect-video bg-black">
                        <iframe class="w-full h-full" src="https://www.youtube.com/embed/la3WI307sko" frameborder="0"
                            allowfullscreen></iframe>
                    </div>
                    <div class="p-5">
                        <span
                            class="px-3 py-1 text-xs font-semibold text-blue-600 bg-blue-50 rounded-full">ช่างกลโรงงาน</span>
                        <h3 class="mt-3 text-lg font-bold text-gray-800 leading-snug">
                            หัวจับชิ้นงานเครื่องกลึงงานเครื่องมือกลเบื้องต้น</h3>
                        <p class="mt-2 text-sm text-gray-600 line-clamp-2">สำหรับงานเทคนิคพื้นฐาน
                            และช่างกลโรงงานที่ต้องการปูพื้นฐานการใช้งาน</p>
                        <div class="mt-4 pt-4 border-t border-gray-50 flex items-center">
                            <div
                                class="w-8 h-8 rounded-full bg-gray-200 flex items-center justify-center text-xs font-bold text-gray-500">
                                ว</div>
                            <p class="ml-3 text-sm font-medium text-gray-700">อ.วรวิทย์ ไววิทยานนท์</p>
                        </div>
                    </div>
                </div>

                <div
                    class="bg-white rounded-xl overflow-hidden shadow-sm hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2 border border-gray-100">
                    <div class="aspect-video bg-black">
                        <iframe class="w-full h-full" src="https://www.youtube.com/embed/dbrfNBhhWvE" frameborder="0"
                            allowfullscreen></iframe>
                    </div>
                    <div class="p-5">
                        <span
                            class="px-3 py-1 text-xs font-semibold text-green-600 bg-green-50 rounded-full">คอมพิวเตอร์</span>
                        <h3 class="mt-3 text-lg font-bold text-gray-800 leading-snug">การสอนประกอบและถอดคอมพิวเตอร์ PC
                        </h3>
                        <p class="mt-2 text-sm text-gray-600 line-clamp-2">
                            เจาะลึกทุกขั้นตอนการดูแลรักษาคอมพิวเตอร์และการประกอบอุปกรณ์</p>
                        <div class="mt-4 pt-4 border-t border-gray-50 flex items-center">
                            <div
                                class="w-8 h-8 rounded-full bg-gray-200 flex items-center justify-center text-xs font-bold text-gray-500">
                                ก</div>
                            <p class="ml-3 text-sm font-medium text-gray-700">อ.เกียรติศักดิ์ บุญยืน</p>
                        </div>
                    </div>
                </div>

                <div
                    class="bg-white rounded-xl overflow-hidden shadow-sm hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2 border border-gray-100">
                    <div class="aspect-video bg-black">
                        <iframe class="w-full h-full" src="https://www.youtube.com/embed/v_5YslnpIwE" frameborder="0"
                            allowfullscreen></iframe>
                    </div>
                    <div class="p-5">
                        <span
                            class="px-3 py-1 text-xs font-semibold text-purple-600 bg-purple-50 rounded-full">อิเล็กทรอนิกส์</span>
                        <h3 class="mt-3 text-lg font-bold text-gray-800 leading-snug">การใช้งานโปรแกรม Proteus เบื้องต้น
                        </h3>
                        <p class="mt-2 text-sm text-gray-600 line-clamp-2">
                            เรียนรู้การเขียนแบบอิเล็กทรอนิกส์ด้วยคอมพิวเตอร์แบบ Step-by-Step</p>
                        <div class="mt-4 pt-4 border-t border-gray-50 flex items-center">
                            <div
                                class="w-8 h-8 rounded-full bg-gray-200 flex items-center justify-center text-xs font-bold text-gray-500">
                                พ</div>
                            <p class="ml-3 text-sm font-medium text-gray-700">อ.พงศกร อินทรีย์</p>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>
</x-public-layout>
