<!-- resources/views/tasks/create.blade.php -->
@extends('layouts.app')

@section('content')

{{-- Display all errors in a list --}}
@if ($errors->any())
    <div class="mb-4 rounded-lg bg-red-50 p-4 ring-1 ring-red-100" role="alert">
       
        <div class="mt-2 text-sm text-red-700">
            <ul class="list-none space-y-1 pl-0">
                @foreach ($errors->all() as $error)
                    <li class="flex items-start gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 translate-y-0.5 flex-shrink-0" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z" clip-rule="evenodd" />
                        </svg>
                        <span>{{ $error }}</span>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
@endif
{{-- ==========================form=============== --}}
 <div class="p-6">
    <div class="flex justify-center mb-4">
        <a href="{{ route('tasks.index') }}" class="bg-purple-500 hover:bg-purple-700 text-white font-bold py-2 px-4 rounded" style="font-family: 'Cairo', sans-serif;">
              عرض مهامي
        </a>
    </div>
    <div class="max-w-3xl mx-auto bg-white rounded-2xl shadow-xl overflow-hidden" dir="rtl">
        <div class="bg-gray-50 px-6 py-4 border-b border-gray-200">
            <h1 class="text-3xl font-semibold text-gray-800 text-center" style="font-family: 'Cairo', sans-serif;">إضافة مهمة جديدة</h1>
        </div>

        <div class="p-6">
            <form action="{{ route('tasks.store') }}" method="POST" class="space-y-6">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="title" class="block text-gray-700 text-sm font-bold mb-2 text-right" style="font-family: 'Cairo', sans-serif;">
                            عنوان المهمة:
                        </label>
                        <input type="text" name="title" id="title" placeholder="أضف مهمة جديدة"
                               class="shadow-md border rounded-lg w-full py-3 px-4 text-gray-700 focus:outline-none focus:ring-2 focus:ring-green-400 text-right"  style="font-family: 'Cairo', sans-serif;" required>
                    </div>
                    <div>
                        <label for="due_date" class="block text-gray-700 text-sm font-bold mb-2 text-right" style="font-family: 'Cairo', sans-serif;">
                            تاريخ الاستحقاق:
                        </label>
                        <input type="date" name="due_date" id="due_date"
                               class="shadow-md border rounded-lg w-full py-3 px-4 text-gray-700 focus:outline-none focus:ring-2 focus:ring-green-400 text-right" style="font-family: 'Cairo', sans-serif;" required>
                    </div>
                </div>

                <div>
                    <label for="priority" class="block text-gray-700 text-sm font-bold mb-2 text-right" style="font-family: 'Cairo', sans-serif;">
                        الأولوية:
                    </label>
                    <select name="priority" id="priority"
                            class="shadow-md border rounded-lg w-full py-3 px-4 text-gray-700 focus:outline-none focus:ring-2 focus:ring-green-400 text-right" style="font-family: 'Cairo', sans-serif;">
                        <option value="low"selected>أولوية منخفضة</option>
                        <option value="medium">أولوية متوسطة</option>
                        <option value="high">أولوية عالية</option>
                    </select>
                </div>

                <div>
                    <label for="description" class="block text-gray-700 text-sm font-bold mb-2 text-right" style="font-family: 'Cairo', sans-serif;">
                        وصف المهمة:
                    </label>
                    <textarea name="description" id="description" placeholder="أدخل وصفًا للمهمة"
                            class="shadow-md border rounded-lg w-full py-3 px-4 text-gray-700 focus:outline-none focus:ring-2 focus:ring-green-400 text-right" style="font-family: 'Cairo', sans-serif;"></textarea>
                </div>

                <div class="flex justify-center">
                    <button type="submit"
                            class="bg-gradient-to-r from-green-400 to-blue-500 hover:from-green-500 hover:to-blue-600 text-white font-bold py-3 px-6 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-400" style="font-family: 'Cairo', sans-serif;">
                        إضافة مهمة
                    </button>
                    <a href="{{ route('tasks.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline mr-2" style="font-family: 'Cairo', sans-serif;">
                        إلغاء
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection