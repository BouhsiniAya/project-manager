<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-bold text-2xl text-[#172B4D] leading-tight">
                {{ __('Projects') }}
            </h2>
            <div class="flex items-center space-x-4">
                <form action="{{ route('projects.index') }}" method="GET" class="relative">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="{{ __('Search projects...') }}" class="pl-10 pr-4 py-2 border border-gray-300 rounded-md text-sm focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-300">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-4 w-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    </div>
                </form>
                <a href="{{ route('projects.create') }}" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-md shadow-sm transition-colors flex items-center">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                    {{ __('New Project') }}
                </a>
            </div>
        </div>
    </x-slot>

    <div class="mt-6">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse ($projects as $project)
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 hover:-translate-y-1 hover:shadow-md transition-all duration-300 flex flex-col group cursor-pointer" onclick="window.location='{{ route('projects.show', $project) }}'">
                    <div class="flex justify-between items-start mb-4">
                        <h3 class="text-xl font-bold text-[#172B4D] line-clamp-1 group-hover:text-blue-600 transition-colors">{{ $project->name }}</h3>
                        <span class="bg-gray-100 text-gray-600 text-xs px-2 py-1 rounded-full whitespace-nowrap">{{ $project->tasks->count() }} {{ __('Tasks') }}</span>
                    </div>
                    <p class="text-gray-500 text-sm mb-4 flex-grow line-clamp-3">
                        {{ $project->description ?: __('No description provided.') }}
                    </p>
                    @if($project->due_date)
                        <div class="mb-4 text-xs font-medium {{ \Carbon\Carbon::parse($project->due_date)->isPast() ? 'text-red-500' : 'text-gray-500' }} flex items-center">
                            <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            {{ __('Due:') }} {{ \Carbon\Carbon::parse($project->due_date)->format('M d, Y') }}
                        </div>
                    @endif
                    <div class="flex items-center justify-between border-t border-gray-100 pt-4 mt-auto">
                        <div class="flex items-center">
                            <div class="h-8 w-8 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center font-bold text-xs mr-3">
                                {{ substr($project->manager->name, 0, 1) }}
                            </div>
                            <span class="text-sm font-medium text-gray-600">{{ $project->manager->name }}</span>
                        </div>
                        <div class="flex space-x-2">
                            <a href="{{ route('projects.edit', $project) }}" class="p-2 text-gray-400 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-colors" onclick="event.stopPropagation()">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full flex flex-col items-center justify-center p-12 bg-white rounded-xl border border-dashed border-gray-300">
                    <svg class="w-16 h-16 text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path></svg>
                    <p class="text-gray-500 text-lg mb-4">{{ __('No projects found.') }}</p>
                    <a href="{{ route('projects.create') }}" class="text-blue-600 hover:text-blue-700 font-medium">{{ __('Create your first project') }}</a>
                </div>
            @endforelse
        </div>
        <div class="mt-8">
            {{ $projects->links() }}
        </div>
    </div>
</x-app-layout>
