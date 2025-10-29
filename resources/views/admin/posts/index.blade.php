<x-admin-layout :title="'จัดการข่าวสาร'" :addButton="['href' => route('admin.posts.create'), 'label' => 'เพิ่มข่าวใหม่']">
    {{-- 
        ปรับปรุง div ครอบตาราง: 
        - เพิ่ม padding เป็น p-6 หรือ p-8 เพื่อให้โปร่งขึ้น
        - ยังคง overflow-x-auto ไว้เป็น fallback ที่ดี
    --}}
    <div class="bg-white shadow-lg rounded-xl p-6 overflow-x-auto">
        {{--
            ปรับปรุง <table>:
            - ใช้ width="100%" และ dt-responsive เพื่อให้ DataTables จัดการ responsiveness
            - ลบ class ที่ไม่จำเป็นเช่น min-w-full, table-auto, nowrap (DataTables จะจัดการเอง)
        --}}
        <table id="postsTable" class="w-full dt-responsive" style="width:100%">
            {{-- 
                ปรับปรุง <thead>:
                - ใช้ text-xs, font-medium, text-gray-500, uppercase, tracking-wider
                - เป็นสไตล์ที่นิยมใน Admin Panel สมัยใหม่ ดูสะอาดตา
                - เพิ่ม padding เป็น px-6 py-3
            --}}
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ลำดับ</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">รูปภาพ</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">หัวข้อ</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ประเภท</th>
                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">เด่น</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">วันที่สร้าง</th>
                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">จัดการ</th>
                </tr>
            </thead>
            {{-- tbody จะถูกสร้างโดย DataTables --}}
            <tbody></tbody>
        </table>
    </div>

    @push('scripts')
        <script>
            $(document).ready(function() {
                const table = $('#postsTable').DataTable({
                    processing: true,
                    serverSide: true,
                    responsive: true, // เปิดใช้งาน Responsive Extension
                    ajax: '{{ route('admin.posts.data') }}',
                    columns: [
                        // เพิ่ม className เพื่อกำหนด padding และ style ให้สอดคล้องกัน
                        { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false, className: 'px-6 py-4 whitespace-nowrap text-sm text-gray-500' },
                        { data: 'image', name: 'image', orderable: false, searchable: false, className: 'px-6 py-4' },
                        { data: 'title', name: 'title', className: 'px-6 py-4 text-sm font-medium text-gray-900' }, // ปล่อยให้หัวข้อตัดคำได้ (ลบ whitespace-nowrap)
                        { data: 'category_name', name: 'category_name', className: 'px-6 py-4 whitespace-nowrap' }, // แนะนำให้ส่ง HTML ที่เป็น Badge มาจาก Server
                        { data: 'featured', name: 'is_featured', orderable: false, searchable: false, className: 'px-6 py-4 whitespace-nowrap text-center' }, // แนะนำให้ส่ง HTML ที่เป็น Badge มา
                        { data: 'created_at', name: 'created_at', className: 'px-6 py-4 whitespace-nowrap text-sm text-gray-500' },
                        { data: 'action', name: 'action', orderable: false, searchable: false, className: 'px-6 py-4 whitespace-nowrap text-center text-sm font-medium' },
                    ],
                    order: [[5, 'desc']], // เรียงตามวันที่สร้าง (คอลัมน์ที่ 6, index 5)
                    language: {
                        processing: "กำลังประมวลผล...",
                        lengthMenu: "แสดง _MENU_ รายการ",
                        zeroRecords: "ไม่พบข้อมูล",
                        info: "แสดงหน้า _PAGE_ จาก _PAGES_",
                        infoEmpty: "ไม่พบข้อมูล",
                        infoFiltered: "(กรองจากทั้งหมด _MAX_ รายการ)",
                        search: "ค้นหา:",
                        paginate: { first: "หน้าแรก", last: "หน้าสุดท้าย", next: "ถัดไป", previous: "ก่อนหน้า" }
                    },
                    
                    // ใช้ createdRow Callback เพื่อเพิ่ม class ให้กับ <tr>
                    // จะทำงานทุกครั้งที่สร้างแถวใหม่
                    createdRow: function(row, data, dataIndex) {
                        $(row).addClass('border-b border-gray-200 hover:bg-gray-50 transition-colors');
                    }
                });
            });
        </script>
    @endpush
</x-admin-layout>