<x-admin-layout :title="'จัดการข่าวสาร'" {{-- :addButton="['href' => route('admin.posts.create'), 'label' => 'เพิ่มข่าวใหม่']" --}} {{-- เราแสดงปุ่มด้านล่างแทน --}}>

    {{-- การ์ดสีขาวครอบตาราง --}}
    {{-- [ปรับปรุง] อาจจะเพิ่ม Padding เป็น p-8 ถ้าต้องการให้โปร่งขึ้นอีก --}}
    <div class="bg-white shadow-lg rounded-xl p-6 md:p-8 overflow-x-auto">

        {{-- ส่วนหัว + ปุ่มเพิ่มใหม่ (คงไว้ตามต้องการ) --}}
        <div class="flex flex-wrap justify-between items-center gap-4 mb-6"> {{-- Add flex-wrap & gap --}}
            <h2 class="text-xl font-semibold text-gray-800">จัดการข่าว</h2>
            <a href="{{ route('admin.posts.create') }}" class="flex-shrink-0">
                <x-primary-button>
                    <i class="fas fa-plus mr-2 -ml-1"></i> {{-- Add Icon --}}
                    เพิ่มใหม่
                </x-primary-button>
            </a>
        </div>

        {{-- ตาราง DataTables --}}
        <table id="postsTable" class="w-full dt-responsive" style="width:100%">
            <thead class="bg-gray-50 border-b border-gray-200"> {{-- Add border --}}
                <tr>
                    {{-- Header Columns --}}
                    <th
                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider dt-no-responsive">
                        ลำดับ</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">รูปภาพ
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">หัวข้อ
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ประเภท
                    </th>
                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">เด่น
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        วันที่สร้าง</th>
                    <th
                        class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider dt-no-responsive">
                        จัดการ</th>
                </tr>
            </thead>
            <tbody></tbody> {{-- tbody ว่างสำหรับ Server-Side --}}
        </table>
    </div>

    <!-- Modal ลบ -->
    <div id="confirmDeleteModal"
        class="fixed inset-0 z-50 hidden items-center justify-center bg-black/40 backdrop-blur-sm">
        <div class="absolute inset-0" onclick="closeDeleteModal()"></div>

        <div
            class="relative z-10 bg-white rounded-xl shadow-xl w-[90%] max-w-sm mx-auto p-6 text-center animate-fadeIn">
            <h3 class="text-lg font-semibold text-gray-800 mb-3">🗑️ ยืนยันการลบ</h3>
            <p id="deleteModalMessage" class="text-sm text-gray-600 mb-5">คุณต้องการลบข้อมูลนี้หรือไม่?</p>

            <div class="flex justify-center space-x-3">
                <button type="button" onclick="closeDeleteModal()"
                    class="px-4 py-2 bg-gray-200 rounded-md hover:bg-gray-300 text-sm w-24">
                    ยกเลิก
                </button>
                <form id="deleteForm" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                        class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 text-sm w-24">
                        ลบ
                    </button>
                </form>
            </div>
        </div>
    </div>

    <style>
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: scale(0.95);
            }

            to {
                opacity: 1;
                transform: scale(1);
            }
        }

        .animate-fadeIn {
            animation: fadeIn 0.2s ease-out;
        }
    </style>

    <script>
        function openDeleteModal(url, title) {
            const modal = document.getElementById('confirmDeleteModal');
            const form = document.getElementById('deleteForm');
            const msg = document.getElementById('deleteModalMessage');

            form.action = url;
            msg.innerHTML = `คุณต้องการลบ<br><b>${title}</b> หรือไม่?`;

            modal.classList.remove('hidden');
            modal.classList.add('flex');

            // ปิดด้วยปุ่ม Back (บนมือถือ)
            window.addEventListener('popstate', closeDeleteModal);
            history.pushState({
                modal: true
            }, '');
        }

        function closeDeleteModal() {
            const modal = document.getElementById('confirmDeleteModal');
            modal.classList.add('hidden');
            modal.classList.remove('flex');
            
        }
    </script>


    @push('scripts')
        <script>
            $(document).ready(function() {
                const table = $('#postsTable').DataTable({
                    processing: true,
                    serverSide: true,
                    responsive: true,
                    ajax: '{{ route('admin.posts.data') }}',
                    columns: [
                        // [ปรับปรุง] เพิ่ม align-middle
                        {
                            data: 'DT_RowIndex',
                            name: 'DT_RowIndex',
                            orderable: false,
                            searchable: false,
                            className: 'px-6 py-4 whitespace-nowrap text-sm text-gray-500 align-middle'
                        },
                        {
                            data: 'image',
                            name: 'image',
                            orderable: false,
                            searchable: false,
                            className: 'px-6 py-4 align-middle'
                        },
                        {
                            data: 'title',
                            name: 'title',
                            className: 'px-6 py-4 text-sm font-medium text-gray-900 min-w-[200px] align-middle'
                        },
                        {
                            data: 'category_name',
                            name: 'category_name',
                            className: 'px-6 py-4 whitespace-nowrap align-middle'
                        },
                        {
                            data: 'featured',
                            name: 'is_featured',
                            searchable: false,
                            className: 'px-6 py-4 whitespace-nowrap text-center align-middle'
                        },
                        {
                            data: 'created_at',
                            name: 'created_at',
                            className: 'px-6 py-4 whitespace-nowrap text-sm text-gray-500 align-middle'
                        },
                        {
                            data: 'action',
                            name: 'action',
                            orderable: false,
                            searchable: false,
                            className: 'px-6 py-4 whitespace-nowrap text-center text-sm font-medium align-middle'
                        },
                    ],
                    order: [
                        [5, 'desc']
                    ],
                    language: {
                        processing: '<div class="absolute inset-0 flex items-center justify-center bg-white/70 z-50"><i class="fas fa-spinner fa-spin fa-2x text-gray-400"></i><span class="ml-2 text-gray-500">กำลังโหลด...</span></div>', // Spinner + Text
                        lengthMenu: "แสดง _MENU_ รายการ",
                        zeroRecords: "<div class='text-center py-10 text-gray-500'>ไม่พบข้อมูลที่ตรงกัน</div>", // Nicer ZeroRecords
                        info: "แสดง _START_ ถึง _END_ จากทั้งหมด _TOTAL_ รายการ", // Clearer Info
                        infoEmpty: "แสดง 0 รายการ",
                        infoFiltered: "(กรองจาก _MAX_ รายการ)",
                        search: "", // Remove label text
                        searchPlaceholder: "ค้นหาข่าวสาร...", // More specific placeholder
                        paginate: {
                            first: "«",
                            last: "»",
                            next: "›",
                            previous: "‹"
                        }
                    },
                    // DOM Layout: Put Length menu and Filter on the same line, Info and Paginate below
                    // '<"top"lf>rt<"bottom"ip><"clear">' is default
                    // Let's try: '<"flex flex-wrap justify-between items-center mb-4 gap-4"l f> rt <"flex flex-wrap justify-between items-center mt-4 gap-4"i p>'
                    dom: '<"flex flex-col md:flex-row md:justify-between md:items-center gap-4 mb-4"l f> rt <"flex flex-col md:flex-row md:justify-between md:items-center gap-4 mt-4"i p>',
                    initComplete: function() {
                        const $filter = $('div.dataTables_filter input');
                        const $length = $('div.dataTables_length select');

                        // Style Search Input
                        $filter.addClass('form-input w-full md:w-auto text-sm');
                        $filter.attr('placeholder', 'ค้นหา...');
                        // Remove default label if needed (handled by dom option)
                        $('div.dataTables_filter label').contents().filter(function() {
                            return this.nodeType === 3;
                        }).remove(); // Remove text node "Search:"

                        // Style Length Select
                        $length.addClass(
                            'form-select text-sm !p-1 !px-2 !pr-6'); // Use !important carefully if needed
                        $('div.dataTables_length label').addClass('text-sm text-gray-600');
                    },
                    createdRow: function(row, data, dataIndex) {
                        $(row).addClass(
                            'border-b border-gray-200 last:border-b-0 hover:bg-gray-50/70 transition-colors duration-150'
                        ); // Add last:border-b-0
                    },
                    drawCallback: function(settings) {
                        // Add Tailwind classes to pagination buttons
                        $('.dataTables_paginate .paginate_button').addClass(
                            '!min-w-0 !p-2 !mx-0.5 rounded'); // Adjust padding/margin
                        $('.dataTables_paginate .paginate_button.current').addClass(
                            '!bg-tech-green !text-white !border-tech-green');
                        $('.dataTables_paginate .paginate_button:not(.current):hover').addClass(
                            '!bg-gray-100');
                        $('.dataTables_paginate .paginate_button.disabled').addClass(
                            '!opacity-50 !cursor-not-allowed');

                        // Style Info text
                        $('.dataTables_info').addClass('text-sm text-gray-600');
                    }
                });
            });
        </script>
    @endpush
</x-admin-layout>
