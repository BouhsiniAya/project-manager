<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <nav class="text-sm font-medium text-gray-500 mb-2">
                    <ol class="list-none p-0 inline-flex">
                        <li class="flex items-center">
                            <span class="text-gray-800">My Tasks</span>
                        </li>
                    </ol>
                </nav>
                <h2 class="font-bold text-3xl text-[#172B4D] leading-tight">
                    Your Work
                </h2>
            </div>
            <div class="flex items-center space-x-4">
                <form action="{{ route('tasks.index') }}" method="GET" class="relative">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Search tasks..." class="pl-10 pr-4 py-2 border border-gray-300 rounded-md text-sm focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-300">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-4 w-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    </div>
                </form>
                <a href="{{ route('tasks.create') }}" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-md shadow-sm transition-colors flex items-center">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                    Create Task
                </a>
            </div>
        </div>
    </x-slot>

    <div class="flex flex-col lg:flex-row gap-6 overflow-x-auto pb-4 h-full mt-6">
        @php
            $statuses = [
                'todo' => ['title' => 'TO DO', 'bg' => 'bg-gray-100', 'border' => 'border-gray-200'],
                'in_progress' => ['title' => 'IN PROGRESS', 'bg' => 'bg-blue-50', 'border' => 'border-blue-100'],
                'done' => ['title' => 'DONE', 'bg' => 'bg-green-50', 'border' => 'border-green-100'],
            ];
            // Since $tasks is paginated, we group the current page items
            $groupedTasks = collect($tasks->items())->groupBy('status');
        @endphp

        @foreach($statuses as $statusKey => $statusData)
            <div class="flex-1 min-w-[300px] {{ $statusData['bg'] }} rounded-xl p-4 flex flex-col min-h-[500px] border {{ $statusData['border'] }}">
                <div class="flex items-center justify-between mb-4">
                    <h4 class="text-xs font-bold text-gray-500 uppercase tracking-wider">{{ $statusData['title'] }}</h4>
                    <span class="bg-white text-gray-600 text-xs font-bold px-2 py-1 rounded-full shadow-sm">{{ $groupedTasks->get($statusKey, collect())->count() }}</span>
                </div>
                
                <div class="flex-1 space-y-3">
                    @forelse($groupedTasks->get($statusKey, collect()) as $task)
                        <a href="{{ route('tasks.show', $task) }}" class="block bg-white p-4 rounded-lg shadow-sm border border-gray-200 hover:border-blue-400 hover:shadow-md transition-all cursor-pointer group">
                            <div class="text-sm font-medium text-[#172B4D] mb-2 group-hover:text-blue-600 transition-colors line-clamp-2">
                                {{ $task->title }}
                            </div>
                            
                            <div class="flex items-center justify-between mt-4">
                                <div class="flex items-center space-x-2">
                                    <span class="text-xs font-medium text-gray-500">TSK-{{ $task->id }}</span>
                                    <span class="text-xs text-gray-400 truncate max-w-[100px]">{{ $task->project->name }}</span>
                                </div>
                                @if($task->assignee)
                                    <div class="w-6 h-6 rounded-full bg-blue-100 text-blue-700 flex items-center justify-center text-xs font-bold" title="{{ $task->assignee->name }}">
                                        {{ substr($task->assignee->name, 0, 1) }}
                                    </div>
                                @else
                                    <div class="w-6 h-6 rounded-full bg-gray-100 text-gray-400 flex items-center justify-center text-xs" title="Unassigned">
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path></svg>
                                    </div>
                                @endif
                            </div>
                        </a>
                    @empty
                        <div class="p-4 rounded-lg border-2 border-dashed border-gray-300 text-center text-gray-400 text-sm">
                            No tasks
                        </div>
                    @endforelse
                </div>
            </div>
        @endforeach
    </div>
    
    <div class="mt-6">
        {{ $tasks->links() }}
    </div>
</x-app-layout>
