<!-- resources/views/tasks/edit.blade.php -->
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

<div class="max-w-3xl mx-auto bg-white rounded-2xl shadow-xl overflow-hidden" dir="rtl">
    <div class="bg-gray-50 px-6 py-4 border-b border-gray-200">
        <h1 class="text-3xl font-semibold text-gray-800 text-center" style="font-family: 'Cairo', sans-serif;">تعديل المهمة</h1>
    </div>

    <div class="p-6">
        <form action="{{ route('tasks.update', $task) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label for="title" class="block text-gray-700 text-sm font-bold mb-2 text-right" style="font-family: 'Cairo', sans-serif;">
                        عنوان المهمة:
                    </label>
                    <input type="text" name="title" id="title" value="{{ $task->title }}"
                           class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline text-right" required style="font-family: 'Cairo', sans-serif;">
                </div>
                <div>
                    <label for="due_date" class="block text-gray-700 text-sm font-bold mb-2 text-right" style="font-family: 'Cairo', sans-serif;">
                        تاريخ الاستحقاق:
                    </label>
                    <input type="date" name="due_date" id="due_date" value="{{ $task->due_date ? $task->due_date->format('Y-m-d') : '' }}"
                           class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline text-right" style="font-family: 'Cairo', sans-serif;">
                </div>
            </div>

            <div class="mt-4">
                <label for="priority" class="block text-gray-700 text-sm font-bold mb-2 text-right" style="font-family: 'Cairo', sans-serif;">
                    الأولوية:
                </label>
                <div class="relative">
                    <select name="priority" id="priority"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline text-right pr-8" style="font-family: 'Cairo', sans-serif;">
                        <option value="low" @if($task->priority === 'low') selected @endif style="font-family: 'Cairo', sans-serif;">أولوية منخفضة</option>
                        <option value="medium" @if($task->priority === 'medium') selected @endif style="font-family: 'Cairo', sans-serif;">أولوية متوسطة</option>
                        <option value="high" @if($task->priority === 'high') selected @endif style="font-family: 'Cairo', sans-serif;">أولوية عالية</option>
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center px-2 text-gray-700">
                        <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
                    </div>
                </div>
            </div>

            <div class="mt-4">
                <label for="description" class="block text-gray-700 text-sm font-bold mb-2 text-right" style="font-family: 'Cairo', sans-serif;">
                    وصف المهمة:
                </label>
                <textarea name="description" id="description"
                          class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline text-right" style="font-family: 'Cairo', sans-serif;">{{ $task->description }}</textarea>
            </div>

            <div class="mt-6 flex justify-center">
                <button type="submit"
                        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" style="font-family: 'Cairo', sans-serif;">
                    تحديث المهمة
                </button>
                <a href="{{ route('tasks.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline mr-2" style="font-family: 'Cairo', sans-serif;">
                    إلغاء
                </a>
            </div>
        </form>
    </div>
</div>
@endsection