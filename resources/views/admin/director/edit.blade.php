<x-admin-layout title="แก้ไขข้อมูลผู้อำนวยการ">


    <form action="{{ route('admin.director.update') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @method('PUT')

        <div>
            <label class="block font-semibold">ชื่อ</label>
            <input type="text" name="name" value="{{ old('name', $director->name ?? '') }}"
                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" />
        </div>

        <div>
            <label class="block font-semibold">ตำแหน่ง</label>
            <input type="text" name="position" value="{{ old('position', $director->position ?? '') }}"
                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" />
        </div>

        <div>
            <label class="block font-semibold">ข้อความต้อนรับ</label>
            <textarea name="message" rows="4" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">{{ old('message', $director->message ?? '') }}</textarea>
        </div>

        <div>
            <label class="block font-semibold">รูปภาพ</label>
            @if (!empty($director->image))
                <img src="{{ asset('storage/' . $director->image) }}" class="w-40 h-40 rounded-full mb-3 object-cover">
            @endif
            <input type="file" name="image" accept="image/*"
                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" />
        </div>

        <button type="submit" class="px-6 py-2 bg-tech-green text-white rounded-lg hover:bg-tech-green-dark">
            บันทึก
        </button>
    </form>
</x-admin-layout>
