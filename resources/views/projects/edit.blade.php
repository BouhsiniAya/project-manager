<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center space-x-4">
            <a href="{{ route('projects.show', $project) }}" class="text-slate-400 hover:text-slate-600 transition-colors">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            </a>
            <h2 class="font-bold text-2xl text-slate-800 leading-tight">
                {{ __('Edit Project') }}: <span class="font-medium text-slate-500">{{ $project->name }}</span>
            </h2>
        </div>
    </x-slot>

    <div class="py-12 bg-slate-50 min-h-screen">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
                <div class="p-6 md:p-8">
                    <form method="POST" action="{{ route('projects.update', $project) }}" class="space-y-6">
                        @csrf
                        @method('PUT')
                        
                        <div>
                            <label for="name" class="block text-sm font-medium text-slate-700 mb-2">{{ __('Project Name') }} <span class="text-red-500">*</span></label>
                            <input type="text" name="name" id="name" value="{{ old('name', $project->name) }}" class="block w-full rounded-xl border-slate-200 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm py-3 px-4 transition-colors" required>
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>
                        
                        <div>
                            <label for="description" class="block text-sm font-medium text-slate-700 mb-2">{{ __('Description') }}</label>
                            <textarea name="description" id="description" rows="4" class="block w-full rounded-xl border-slate-200 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm py-3 px-4 transition-colors resize-none">{{ old('description', $project->description) }}</textarea>
                            <x-input-error :messages="$errors->get('description')" class="mt-2" />
                        </div>

                        <div>
                            <label for="due_date" class="block text-sm font-medium text-slate-700 mb-2">{{ __('Due Date') }}</label>
                            <input type="date" name="due_date" id="due_date" value="{{ old('due_date', $project->due_date ? $project->due_date->format('Y-m-d') : '') }}" class="block w-full rounded-xl border-slate-200 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm py-3 px-4 transition-colors">
                            <x-input-error :messages="$errors->get('due_date')" class="mt-2" />
                        </div>

                        <div class="pt-4 flex items-center justify-end space-x-3 border-t border-slate-50">
                            <a href="{{ route('projects.show', $project) }}" class="px-5 py-2.5 text-sm font-medium text-slate-600 hover:text-slate-800 hover:bg-slate-50 rounded-lg transition-colors">
                                {{ __('Cancel') }}
                            </a>
                            <button type="submit" class="px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg shadow-sm transition-colors flex items-center">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
                                {{ __('Save Changes') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
