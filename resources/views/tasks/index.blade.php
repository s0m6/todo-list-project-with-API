@extends('layouts.app')

@section('content')
    <div class="min-h-screen bg-gray-50 py-4 sm:py-8 px-2 sm:px-6 lg:px-8" dir="rtl">
        @if (session('success'))
            <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 4000)" x-show="show"
                x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 transform translate-y-4"
                x-transition:enter-end="opacity-100 transform translate-y-0"
                x-transition:leave="transition ease-in duration-200"
                x-transition:leave-start="opacity-100 transform translate-y-0"
                x-transition:leave-end="opacity-0 transform translate-y-4"
                class="fixed inset-x-0 top-6 z-50 mx-auto max-w-2xl px-4 sm:px-6 lg:px-8">
                <div
                    class="bg-emerald-600 backdrop-blur-xl rounded-xl shadow-2xl shadow-emerald-100/50 border border-emerald-50/70 overflow-hidden">
                    <div class="p-4 flex items-start justify-between gap-3">
                        <!-- Animated check icon -->
                        <div class="flex-shrink-0">
                            <div class="w-6 h-6 bg-emerald-100 rounded-full flex items-center justify-center">
                                <svg class="w-4 h-4 text-emerald-600 animate-pop-in" fill="currentColor"
                                    viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>
                        </div>

                        <!-- Message content -->
                        <div class="flex-1">
                            <p class="text-sm font-medium text-white leading-tight">
                                {{ session('success') }}
                            </p>
                        </div>

                        <!-- Close button -->
                        <button @click="show = false"
                            class="p-1 -m-1.5 rounded-lg hover:bg-emerald-50/50 transition-colors">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>

                    <!-- Progress bar -->
                    <div class="h-0.5 bg-emerald-100/50 w-full">
                        <div class="h-full bg-emerald-400/50 transition-all duration-4000 ease-linear origin-left"
                            x-ref="progress" x-init="setTimeout(() => $refs.progress.style.transform = 'scaleX(0)')"></div>
                    </div>
                </div>
            </div>
        @endif

        <div class="max-w-4xl mx-auto">
            <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
                <div class="bg-gradient-to-l from-purple-600 to-indigo-600 px-4 sm:px-6 py-6">
                    <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
                        <h1 class="text-2xl sm:text-3xl font-bold text-white" style="">
                            مهامك</h1>
                        <div class="flex flex-col sm:flex-row items-center gap-3 w-full sm:w-auto">
                            <div class="flex items-center gap-2 w-full sm:w-auto">
                                <!-- Date Input -->
                                <input type="date" id="taskDate"
                                    class="px-3 py-2 bg-white bg-opacity-20 text-white rounded-lg focus:outline-none focus:ring-2 focus:ring-white focus:ring-opacity-50"
                                    style="">
                                <!-- Clear Filter Button -->
                                <button onclick="clearDateFilter()"
                                    class="px-3 py-2 bg-white bg-opacity-20 hover:bg-opacity-30 rounded-lg text-white transition-all duration-200"
                                    style="">
                                    عرض الكل
                                </button>
                            </div>

                            <a href="{{ route('tasks.create') }}"
                                class="w-full sm:w-auto inline-flex items-center justify-center px-4 py-2 bg-white bg-opacity-20 hover:bg-opacity-30 rounded-lg transition-all duration-200 text-white font-semibold shadow-sm hover:shadow-md">
                                <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 4v16m8-8H4" />
                                </svg>
                                <span style="">إضافة مهمة</span>
                            </a>
                        </div>
                    </div>
                </div>

                <div class="divide-y divide-gray-100">
                    <div id="tasksContainer" class="divide-y divide-gray-100">
                        @forelse($tasks as $task)
                            <div class="task-item p-4 sm:p-6 hover:bg-gray-50 transition-colors duration-200 {{ $task->is_completed ? 'bg-gray-50' : '' }}"
                                data-date="{{ $task->due_date ? $task->due_date->format('Y-m-d') : '' }}">
                                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                                    <div class="flex-1">
                                        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2">
                                            <h3 class="text-lg font-semibold {{ $task->is_completed ? 'text-gray-400 line-through' : 'text-gray-900' }}"
                                                style="">
                                                {{ $task->title }}
                                            </h3>
                                            <div class="flex items-center gap-2">
                                                <span
                                                    class="px-2 py-1 rounded-full text-xs font-medium
                                                {{ $task->is_completed ? 'opacity-60' : '' }}"
                                                    style="
                                                        @if ($task->priority === 'high') background-color: #fee2e2; color: #b91c1c;
                                                        @elseif($task->priority === 'medium') background-color: #fef3c7; color: #92400e;
                                                        @else background-color: #d1fae5; color: #065f46; @endif">
                                                    <span>
                                                        {{ $task->priority === 'high' ? 'أولوية عالية' : ($task->priority === 'medium' ? 'أولوية متوسطة' : 'أولوية منخفضة') }}
                                                    </span>
                                                </span>
                                                @if ($task->due_date)
                                                    <span class="text-xs text-gray-500"
                                                        style="">
                                                        {{ $task->due_date->format('Y/m/d') }}
                                                    </span>
                                                @endif
                                            </div>
                                        </div>

                                        @if ($task->description)
                                            <p class="mt-2 text-sm {{ $task->is_completed ? 'text-gray-400 line-through' : 'text-gray-600' }}"
                                                style="">
                                                {{ $task->description }}
                                            </p>
                                        @endif
                                    </div>

                                    <div class="flex flex-wrap sm:flex-nowrap items-center gap-2">
                                        <form action="{{ route('tasks.toggle', $task) }}" method="POST"
                                            class="w-full sm:w-auto">
                                            @csrf
                                            <button type="submit"
                                                class="w-full sm:w-auto inline-flex items-center justify-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md shadow-sm text-white {{ $task->is_completed ? 'bg-gray-600 hover:bg-gray-700' : 'bg-green-600 hover:bg-green-700' }} transition-colors duration-200">
                                                <span style="">
                                                    {{ $task->is_completed ? 'إلغاء إكمال' : 'إكمال' }}
                                                </span>
                                            </button>
                                        </form>

                                        <a href="{{ route('tasks.edit', $task) }}"
                                            class="w-full sm:w-auto inline-flex items-center justify-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-white bg-yellow-600 hover:bg-yellow-700 transition-colors duration-200">
                                            <span style="">تعديل</span>
                                        </a>

                                        <form action="{{ route('tasks.destroy', $task) }}" method="POST"
                                            class="w-full sm:w-auto">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="w-full sm:w-auto inline-flex items-center justify-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-white bg-red-600 hover:bg-red-700 transition-colors duration-200"
                                                onclick="return confirm('هل أنت متأكد من حذف هذه المهمة؟')">
                                                <span style="">حذف</span>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div id="emptyState" class="text-center py-12">
                                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                </svg>
                                <h3 class="mt-2 text-sm font-medium text-gray-900"
                                    style="">لا توجد مهام</h3>
                                <p class="mt-1 text-sm text-gray-500" style="">ابدأ
                                    بإضافة مهمة جديدة لقائمة مهامك</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Get the date input element
            const dateInput = document.getElementById('taskDate');

            // Add change event listener
            dateInput.addEventListener('change', function(e) {
                filterTasks(e.target.value);
            });
        });

        function filterTasks(selectedDate) {
            const tasks = document.querySelectorAll('.task-item');
            const emptyState = document.getElementById('emptyState');
            let hasVisibleTasks = false;

            tasks.forEach(task => {
                const taskDate = task.dataset.date;
                if (!selectedDate || taskDate === selectedDate) {
                    task.style.display = '';
                    hasVisibleTasks = true;
                } else {
                    task.style.display = 'none';
                }
            });

            // Show/hide empty state
            if (!hasVisibleTasks) {
                if (!emptyState) {
                    const tasksContainer = document.getElementById('tasksContainer');
                    const newEmptyState = createEmptyState(selectedDate);
                    tasksContainer.appendChild(newEmptyState);
                } else {
                    emptyState.style.display = 'block';
                    updateEmptyStateMessage(emptyState, selectedDate);
                }
            } else if (emptyState) {
                emptyState.style.display = 'none';
            }
        }

        function clearDateFilter() {
            const dateInput = document.getElementById('taskDate');
            dateInput.value = '';
            filterTasks('');
        }

        function createEmptyState(selectedDate) {
            const div = document.createElement('div');
            div.id = 'emptyState';
            div.className = 'text-center py-12';
            div.innerHTML = `
        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
        </svg>
        <h3 class="mt-2 text-sm font-medium text-gray-900" style="">
            ${selectedDate ? 'لا توجد مهام في هذا اليوم' : 'لا توجد مهام'}
        </h3>
        <p class="mt-1 text-sm text-gray-500" style="">
            ابدأ بإضافة مهمة جديدة لقائمة مهامك
        </p>
    `;
            return div;
        }

        function updateEmptyStateMessage(emptyState, selectedDate) {
            const heading = emptyState.querySelector('h3');
            if (heading) {
                heading.textContent = selectedDate ? 'لا توجد مهام في هذا اليوم' : 'لا توجد مهام';
            }
        }
    </script>
@endsection
