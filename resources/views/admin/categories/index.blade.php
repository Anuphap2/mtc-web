<x-admin-layout>
    {{-- 
      - ใช้ p-6 หรือ p-8 เพื่อให้โปร่งขึ้น
      - ปรับ mb-4 เป็น mb-6 เพื่อเพิ่มระยะห่าง
    --}}
    <div class="bg-white p-6 rounded-lg shadow-md overflow-x-auto">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-xl font-semibold text-gray-800">จัดการประเภทข่าว</h2>
            <a href="{{ route('admin.categories.create') }}">
                <x-primary-button>เพิ่มใหม่</x-primary-button>
            </a>
        </div>

        {{-- 
          - ปรับ <table> ให้รองรับ DataTables Responsive
          - ลบ class ที่ไม่จำเป็นออก
        --}}
        <table id="categoriesTable" class="w-full dt-responsive" style="width:100%">
            {{-- 
              - ปรับ <thead> ให้เป็นสไตล์โมเดิร์น
            --}}
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            {{-- 
              - ใน <tbody> เราจะปรับปรุง <td> และปุ่ม Action 
            --}}
            <tbody>
                @foreach ($categories as $category)
                    {{-- 
                      - เราจะใช้ <script> ด้านล่าง (createdRow) เพิ่ม class เส้นขอบและ hover 
                      - แต่เราสามารถกำหนด class ให้ <td> ตรงนี้ได้เลย
                    --}}
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $category->id }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                            {{ $category->name }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-center">
                            {{-- [ปรับปรุง] เปลี่ยนปุ่มเป็นไอคอนสวยงาม --}}
                            <div class="flex items-center justify-center space-x-3">
                                <a href="{{ route('admin.categories.edit', $category) }}" title="แก้ไข" class="text-indigo-600 hover:text-indigo-900 transition-colors">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                        <path d="M17.414 2.586a2 2 0 00-2.828 0L7 10.172V13h2.828l7.586-7.586a2 2 0 000-2.828z" />
                                        <path fill-rule="evenodd" d="M2 6a2 2 0 012-2h4a1 1 0 010 2H4v10h10v-4a1 1 0 112 0v4a2 2 0 01-2 2H4a2 2 0 01-2-2V6z" clip-rule="evenodd"/>
                                    </svg>
                                </a>
                                <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" onsubmit="return confirm('ยืนยันการลบประเภทนี้?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" title="ลบ" class="text-red-600 hover:text-red-900 transition-colors">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    @push('scripts')
        <script>
            $(document).ready(function() {
                $('#categoriesTable').DataTable({
                    responsive: true,
                    // [ปรับปรุง] แนะนำให้เรียงตามชื่อ (คอลัมน์ index 1)
                    order: [
                        [1, 'asc'] 
                    ],
                    language: {
                        lengthMenu: "แสดง _MENU_ รายการ",
                        zeroRecords: "ไม่พบข้อมูล",
                        info: "แสดงหน้า _PAGE_ จาก _PAGES_",
                        infoEmpty: "ไม่พบข้อมูล",
                        infoFiltered: "(กรองจากทั้งหมด _MAX_ รายการ)",
                        search: "ค้นหา:",
                        paginate: {
                            first: "หน้าแรก",
                            last: "หน้าสุดท้าย",
                            next: "ถัดไป",
                            previous: "ก่อนหน้า"
                        }
                    },
                    
                    // [เพิ่ม] เพิ่ม Callback เพื่อใส่ class ให้ <tr>
                    // เพื่อให้มีเส้นขอบและ Hover effect เหมือนหน้า Posts
                    createdRow: function(row, data, dataIndex) {
                        $(row).addClass('border-b border-gray-200 hover:bg-gray-50 transition-colors');
                    }
                });
            });
        </script>
    @endpush
</x-admin-layout>