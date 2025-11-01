<x-admin-layout>
    <div class="bg-white p-6 rounded-lg shadow-md overflow-x-auto">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-xl font-semibold text-gray-800">จัดการเมนู</h2>
            <a href="{{ route('admin.menus.create') }}">
                <x-primary-button>เพิ่มใหม่</x-primary-button>
            </a>
        </div>

        <table id="menusTable" class="w-full dt-responsive" style="width:100%">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ลำดับ</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">URL</th>
                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Actions
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach ($menus as $menu)
                    <tr>
                        <td class="px-6 py-4 text-sm text-gray-500">{{ $menu->order }}</td>
                        <td class="px-6 py-4 text-sm font-medium text-gray-900">{{ $menu->name }}</td>
                        <td class="px-6 py-4 text-sm text-gray-500">{{ $menu->url }}</td>
                        <td class="px-6 py-4 text-center">
                            {!! $menu->actionButtons() !!}
                        </td>
                    </tr>

                    {{-- Children --}}
                    @foreach ($menu->children->sortBy('order') as $child)
                        <tr class="bg-gray-50">
                            <td class="px-6 py-4 text-sm text-gray-500">↳ {{ $child->order }}</td>
                            <td class="px-6 py-4 text-sm font-medium text-gray-900">{{ $child->name }}</td>
                            <td class="px-6 py-4 text-sm text-gray-500">{{ $child->url }}</td>
                            <td class="px-6 py-4 text-center">
                                {!! $child->actionButtons() !!}
                            </td>
                        </tr>
                    @endforeach
                @endforeach
            </tbody>
        </table>
    </div>

    {{-- Modal Confirm Delete --}}
    <div id="confirmDeleteModal"
        class="fixed inset-0 z-50 hidden items-center justify-center bg-black/40 backdrop-blur-sm">
        <div class="absolute inset-0" onclick="closeDeleteModal()"></div>
        <div
            class="relative z-10 bg-white rounded-xl shadow-xl w-[90%] max-w-sm mx-auto p-6 text-center animate-fadeIn">
            <h3 class="text-lg font-semibold text-gray-800 mb-3">🗑️ ยืนยันการลบ</h3>
            <p id="deleteModalMessage" class="text-sm text-gray-600 mb-5">คุณต้องการลบข้อมูลนี้หรือไม่?</p>
            <div class="flex justify-center space-x-3">
                <button type="button" onclick="closeDeleteModal()"
                    class="px-4 py-2 bg-gray-200 rounded-md hover:bg-gray-300 text-sm w-24">ยกเลิก</button>
                <form id="deleteForm" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                        class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 text-sm w-24">ลบ</button>
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

        document.addEventListener('keydown', function(e) {
            if (e.key === "Escape") closeDeleteModal();
        });

        $(document).ready(function() {
            $('#menusTable').DataTable({
                responsive: true,
                pageLength: 15,
                lengthMenu: [5, 10, 15, 25, 50, 100],
                order: [
                    [0, 'asc']
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
                createdRow: function(row, data, dataIndex) {
                    $(row).addClass('border-b border-gray-200 hover:bg-gray-50 transition-colors');
                }
            });
        });
    </script>

    @push('styles')
        <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
        <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.dataTables.min.css">
    @endpush

    @push('scripts')
        <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
        <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>

        <script>
            $(document).ready(function() {
                $('#menusTable').DataTable({
                    responsive: true,
                    pageLength: 15,
                    lengthMenu: [5, 10, 15, 25, 50, 100],
                    order: [
                        [0, 'asc']
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
                    createdRow: function(row, data, dataIndex) {
                        $(row).addClass('border-b border-gray-200 hover:bg-gray-50 transition-colors');
                    }
                });
            });
        </script>
    @endpush

</x-admin-layout>
