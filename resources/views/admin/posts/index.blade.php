<x-admin-layout>
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-semibold text-gray-700">จัดการข่าวสาร</h2>
        <a href="{{ route('admin.posts.create') }}"
            class="inline-flex items-center px-4 py-2 bg-green-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-600 active:bg-green-700 focus:outline-none focus:border-green-700 focus:ring ring-green-300 disabled:opacity-25 transition ease-in-out duration-150">
            <svg class="w-4 h-4 mr-2 -ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6">
                </path>
            </svg>
            เพิ่มข่าวใหม่
        </a>
    </div>

    {{-- Session Messages --}}
    @if (session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @endif
    @if (session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
            <span class="block sm:inline">{{ session('error') }}</span>
        </div>
    @endif

    {{-- Bulk Delete Form --}}
    <form id="bulk-delete-form" action="{{ route('admin.posts.bulkDestroy') }}" method="POST">
        @csrf
        @method('DELETE')
        <div class="mb-4">
            {{-- Bulk Delete Button --}}
            <button type="submit" id="bulk-delete-btn"
                class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700 active:bg-red-900 focus:outline-none focus:border-red-900 focus:ring ring-red-300 disabled:opacity-50 transition ease-in-out duration-150"
                disabled>
                <svg class="w-4 h-4 mr-2 -ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                    </path>
                </svg>
                ลบรายการที่เลือก
            </button>
        </div>

        {{-- Table Structure for DataTables --}}
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200 overflow-x-auto">
                <table id="postsTable" class="display responsive nowrap min-w-full table-auto" style="width:100%">
                    <thead class="bg-gray-50">
                        <tr>
                            <th
                                class="px-3 py-3 border-b-2 border-gray-200 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider w-10">
                                <input type="checkbox" id="select-all-checkbox"
                                    class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500">
                            </th>
                            <th
                                class="px-4 py-3 border-b-2 border-gray-200 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                ลำดับ</th>
                            <th
                                class="px-4 py-3 border-b-2 border-gray-200 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                รูปภาพ</th>
                            <th
                                class="px-4 py-3 border-b-2 border-gray-200 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                หัวข้อ</th>
                            <th
                                class="px-4 py-3 border-b-2 border-gray-200 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                ประเภท</th>
                            <th
                                class="px-4 py-3 border-b-2 border-gray-200 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                เด่น</th>
                            <th
                                class="px-4 py-3 border-b-2 border-gray-200 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                วันที่สร้าง</th>
                            <th
                                class="px-4 py-3 border-b-2 border-gray-200 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                จัดการ</th>
                        </tr>
                    </thead>
                    <tbody>
                        {{-- Data loaded via AJAX --}}
                    </tbody>
                </table>
            </div>
        </div>
        {{-- Hidden inputs for selected IDs will be appended here by JS --}}
    </form> {{-- Close Bulk Delete Form --}}


    @push('scripts')
        <script>
            $(document).ready(function() {
                var table = $('#postsTable').DataTable({
                    processing: true,
                    serverSide: true,
                    responsive: true,
                    ajax: '{{ route('admin.posts.data') }}',
                    columns: [{
                            data: 'checkbox',
                            name: 'checkbox',
                            orderable: false,
                            searchable: false,
                            className: 'text-center'
                        },
                        {
                            data: 'DT_RowIndex',
                            name: 'DT_RowIndex',
                            orderable: false,
                            searchable: false
                        },
                        {
                            data: 'image',
                            name: 'image',
                            orderable: false,
                            searchable: false
                        },
                        {
                            data: 'title',
                            name: 'title'
                        },
                        {
                            data: 'category_name',
                            name: 'category.name'
                        },
                        {
                            data: 'featured',
                            name: 'is_featured',
                            className: 'text-center'
                        }, // Center align featured icon
                        {
                            data: 'created_at',
                            name: 'created_at'
                        },
                        {
                            data: 'action',
                            name: 'action',
                            orderable: false,
                            searchable: false
                        },
                    ],
                    // Default sort by created_at descending
                    order: [
                        [6, 'desc']
                    ],
                    // Language settings for Thai (optional)
                    language: {
                        processing: "กำลังประมวลผล...",
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
                    }
                });

                // --- Bulk Delete JS ---
                const selectAllCheckbox = $('#select-all-checkbox');
                const postCheckboxes = '.post-checkbox';
                const bulkDeleteBtn = $('#bulk-delete-btn');
                const bulkDeleteForm = $('#bulk-delete-form');

                selectAllCheckbox.on('click', function() {
                    // Ensure correct selector within the table body
                    table.rows({
                        search: 'applied'
                    }).nodes().to$().find(postCheckboxes).prop('checked', this.checked);
                    toggleBulkDeleteButton();
                });

                $('#postsTable tbody').on('change', postCheckboxes, function() {
                    // Check if all checkboxes in the current view are checked
                    const allChecked = table.rows({
                        search: 'applied'
                    }).nodes().to$().find(postCheckboxes).length === table.rows({
                        search: 'applied'
                    }).nodes().to$().find(postCheckboxes + ':checked').length;
                    selectAllCheckbox.prop('checked', allChecked);
                    toggleBulkDeleteButton();
                });


                function toggleBulkDeleteButton() {
                    // Count checked boxes within the currently displayed table rows
                    const checkedCount = table.rows({
                        search: 'applied'
                    }).nodes().to$().find(postCheckboxes + ':checked').length;
                    if (checkedCount > 0) {
                        bulkDeleteBtn.prop('disabled', false);
                        bulkDeleteBtn.text(`ลบ ${checkedCount} รายการที่เลือก`); // Update button text
                    } else {
                        bulkDeleteBtn.prop('disabled', true);
                        bulkDeleteBtn.text('ลบรายการที่เลือก'); // Reset button text
                    }
                }

                bulkDeleteForm.on('submit', function(e) {
                    // Remove any previously added hidden inputs to avoid duplicates
                    $(this).find('input[name="ids[]"]').remove();

                    const checkedBoxes = table.rows({
                        search: 'applied'
                    }).nodes().to$().find(postCheckboxes + ':checked');
                    const checkedCount = checkedBoxes.length;

                    if (checkedCount === 0) {
                        alert('กรุณาเลือกรายการที่ต้องการลบ');
                        return false;
                    }
                    if (!confirm(
                        `ยืนยันการลบ ${checkedCount} รายการที่เลือก? การกระทำนี้ไม่สามารถย้อนกลับได้`)) {
                        e.preventDefault();
                    } else {
                        // Add selected IDs as hidden inputs just before submitting
                        checkedBoxes.each(function() {
                            $('<input>').attr({
                                type: 'hidden',
                                name: 'ids[]',
                                value: $(this).val()
                            }).appendTo(bulkDeleteForm);
                        });
                    }
                });

                // Handle checkboxes after table draw (pagination, search)
                table.on('draw.dt', function() {
                    selectAllCheckbox.prop('checked', false);
                    toggleBulkDeleteButton();
                });

            });
        </script>
    @endpush

</x-admin-layout>
