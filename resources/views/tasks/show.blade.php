<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <nav class="text-sm font-medium text-gray-500 mb-2">
                    <ol class="list-none p-0 inline-flex">
                        <li class="flex items-center">
                            <a href="{{ route('projects.index') }}" class="hover:underline">{{ __('Projects') }}</a>
                            <svg class="w-4 h-4 mx-2" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
                        </li>
                        <li class="flex items-center">
                            <a href="{{ route('projects.show', $task->project) }}" class="hover:underline">{{ $task->project->name }}</a>
                            <svg class="w-4 h-4 mx-2" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
                        </li>
                        <li class="text-gray-800">
                            TSK-{{ $task->id }}
                        </li>
                    </ol>
                </nav>
                <h2 class="font-bold text-3xl text-[#172B4D] leading-tight">
                    {{ $task->title }}
                </h2>
            </div>
            <div class="flex space-x-3">
                <a href="{{ route('tasks.edit', $task) }}" class="px-4 py-2 bg-gray-100 hover:bg-gray-200 text-[#172B4D] text-sm font-medium rounded-md transition-colors flex items-center">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                    {{ __('Edit') }}
                </a>
                @if(auth()->user()->isAdmin())
                <form action="{{ route('tasks.destroy', $task) }}" method="POST" onsubmit="return confirm('{{ __('Are you sure you want to delete this task?') }}');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="px-4 py-2 bg-red-50 hover:bg-red-100 text-red-600 text-sm font-medium rounded-md transition-colors flex items-center">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                        {{ __('Delete') }}
                    </button>
                </form>
                @endif
            </div>
        </div>
    </x-slot>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mt-6">
        
        <!-- Main Content Area -->
        <div class="lg:col-span-2 space-y-8">
            
            <!-- Description Box -->
            <div>
                <h3 class="text-lg font-semibold text-[#172B4D] mb-4">{{ __('Description') }}</h3>
                <div class="bg-white p-6 rounded-xl border border-gray-200 shadow-sm">
                    <p class="text-gray-700 leading-relaxed whitespace-pre-wrap">{{ $task->description ?: __('No description provided.') }}</p>
                </div>
            </div>
            
            <!-- Attachments Box -->
            @if($task->files->count() > 0)
                <div>
                    <h3 class="text-lg font-semibold text-[#172B4D] mb-4">{{ __('Attachments') }}</h3>
                    <div class="bg-white p-6 rounded-xl border border-gray-200 shadow-sm">
                        <ul class="space-y-3">
                            @foreach($task->files as $file)
                                <li>
                                    <a href="{{ Storage::url($file->path) }}" target="_blank" class="flex items-center p-3 rounded-lg border border-gray-200 hover:bg-blue-50 hover:border-blue-200 transition-colors group">
                                        <div class="p-2 bg-gray-100 rounded-md group-hover:bg-blue-100 group-hover:text-blue-600 transition-colors text-gray-500 mr-4">
                                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"></path></svg>
                                        </div>
                                        <div>
                                            <p class="text-sm font-medium text-[#172B4D] group-hover:text-blue-600">{{ $file->name }}</p>
                                        </div>
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif

            <!-- Activity / Comments -->
            <div>
                <h3 class="text-lg font-semibold text-[#172B4D] mb-4">{{ __('Activity') }}</h3>
                <div class="bg-white p-6 rounded-xl border border-gray-200 shadow-sm">
                    
                    <div class="mb-8 border-b border-gray-100 pb-6">
                        <form method="POST" action="{{ route('comments.store', $task) }}" class="flex items-start space-x-4">
                            @csrf
                            <div class="flex-shrink-0">
                                <div class="h-10 w-10 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center font-bold text-sm">
                                    {{ substr(auth()->user()->name ?? 'U', 0, 1) }}
                                </div>
                            </div>
                            <div class="flex-1">
                                <textarea name="content" rows="3" class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm resize-none" placeholder="{{ __('Add a comment...') }}" required></textarea>
                                <div class="mt-3 flex justify-end">
                                    <button type="submit" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-md shadow-sm transition-colors">
                                        {{ __('Save') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>

                    <div class="space-y-6">
                        @forelse($task->comments as $comment)
                            <div class="flex space-x-4">
                                <div class="flex-shrink-0">
                                    <div class="h-10 w-10 rounded-full bg-gray-100 text-gray-600 flex items-center justify-center font-bold text-sm border border-gray-200">
                                        {{ substr($comment->user->name, 0, 1) }}
                                    </div>
                                </div>
                                <div class="flex-1">
                                    <div class="flex items-center mb-1">
                                        <h4 class="text-sm font-bold text-[#172B4D] mr-3">{{ $comment->user->name }}</h4>
                                        <span class="text-xs text-gray-500">{{ $comment->created_at->diffForHumans() }}</span>
                                    </div>
                                    <div class="text-sm text-gray-700 bg-gray-50 p-3 rounded-lg border border-gray-100">
                                        {{ $comment->content }}
                                    </div>
                                </div>
                            </div>
                        @empty
                            <p class="text-sm text-gray-500 italic text-center py-4">{{ __('No activity yet on this task.') }}</p>
                        @endforelse
                    </div>

                </div>
            </div>
        </div>

        <!-- Sidebar Meta Data -->
        <div class="lg:col-span-1 space-y-6">
            
            <div class="bg-white p-6 rounded-xl border border-gray-200 shadow-sm">
                <div class="flex justify-between items-center mb-6">
                    <h4 class="font-semibold text-[#172B4D]">{{ __('Details') }}</h4>
                </div>
                
                <div class="space-y-4">
                    <div class="flex items-center">
                        <span class="w-32 text-sm text-gray-500">{{ __('Status') }}</span>
                        <div class="flex-1">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-sm text-xs font-bold uppercase tracking-wider
                                {{ $task->status === 'todo' ? 'bg-gray-100 text-gray-700' : '' }}
                                {{ $task->status === 'in_progress' ? 'bg-blue-100 text-blue-700' : '' }}
                                {{ $task->status === 'done' ? 'bg-green-100 text-green-700' : '' }}
                            ">
                                {{ __(str_replace('_', ' ', $task->status)) }}
                            </span>
                        </div>
                    </div>

                    <div class="flex items-center">
                        <span class="w-32 text-sm text-gray-500">{{ __('Assignee') }}</span>
                        <div class="flex-1 flex items-center">
                            @if($task->assignee)
                                <div class="h-6 w-6 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center font-bold text-xs mr-2">
                                    {{ substr($task->assignee->name, 0, 1) }}
                                </div>
                                <span class="text-sm text-[#172B4D]">{{ $task->assignee->name }}</span>
                            @else
                                <span class="text-sm text-gray-500 italic">{{ __('Unassigned') }}</span>
                            @endif
                        </div>
                    </div>

                    <div class="flex items-center">
                        <span class="w-32 text-sm text-gray-500">{{ __('Reporter') }}</span>
                        <div class="flex-1 flex items-center">
                            <span class="text-sm text-[#172B4D]">{{ $task->project->manager->name ?? 'System' }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white p-6 rounded-xl border border-gray-200 shadow-sm">
                <h4 class="font-semibold text-[#172B4D] mb-4">{{ __('Dates') }}</h4>
                <div class="space-y-4">
                    <div class="flex items-center">
                        <span class="w-32 text-sm text-gray-500">{{ __('Created') }}</span>
                        <span class="flex-1 text-sm text-[#172B4D]">{{ $task->created_at->format('M d, Y g:i A') }}</span>
                    </div>
                    <div class="flex items-center">
                        <span class="w-32 text-sm text-gray-500">{{ __('Updated') }}</span>
                        <span class="flex-1 text-sm text-[#172B4D]">{{ $task->updated_at->diffForHumans() }}</span>
                    </div>
                </div>
            </div>

        </div>

    </div>
</x-app-layout>
