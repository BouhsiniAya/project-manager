<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center space-x-4">
            <a href="{{ route('tasks.index') }}" class="text-slate-400 hover:text-slate-600 transition-colors">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            </a>
            <h2 class="font-bold text-2xl text-slate-800 leading-tight">
                {{ __('Create New Task') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12 bg-slate-50 min-h-screen">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
                <div class="p-6 md:p-8">
                    <form method="POST" action="{{ route('tasks.store') }}" enctype="multipart/form-data" class="space-y-6">
                        @csrf
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="md:col-span-2">
                                <label for="title" class="block text-sm font-medium text-slate-700 mb-2">{{ __('Task Title') }} <span class="text-red-500">*</span></label>
                                <input type="text" name="title" id="title" value="{{ old('title') }}" class="block w-full rounded-xl border-slate-200 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm py-3 px-4 transition-colors" placeholder="{{ __('e.g. Design Homepage') }}" required>
                                <x-input-error :messages="$errors->get('title')" class="mt-2" />
                            </div>
                            
                            <div class="md:col-span-2">
                                <label for="description" class="block text-sm font-medium text-slate-700 mb-2">{{ __('Description') }}</label>
                                <textarea name="description" id="description" rows="4" class="block w-full rounded-xl border-slate-200 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm py-3 px-4 transition-colors resize-none" placeholder="{{ __('Task details and requirements...') }}">{{ old('description') }}</textarea>
                                <x-input-error :messages="$errors->get('description')" class="mt-2" />
                            </div>

                            <div>
                                <label for="project_id" class="block text-sm font-medium text-slate-700 mb-2">{{ __('Project') }} <span class="text-red-500">*</span></label>
                                <select name="project_id" id="project_id" class="block w-full rounded-xl border-slate-200 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm py-3 px-4 transition-colors bg-white" required>
                                    <option value="" disabled {{ old('project_id') ? '' : 'selected' }}>{{ __('Select Project') }}</option>
                                    @foreach($projects as $project)
                                        <option value="{{ $project->id }}" {{ old('project_id') == $project->id ? 'selected' : '' }}>{{ $project->name }}</option>
                                    @endforeach
                                </select>
                                <x-input-error :messages="$errors->get('project_id')" class="mt-2" />
                            </div>

                            <div>
                                <label for="user_id" class="block text-sm font-medium text-slate-700 mb-2">{{ __('Assign To') }}</label>
                                <select name="user_id" id="user_id" class="block w-full rounded-xl border-slate-200 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm py-3 px-4 transition-colors bg-white">
                                    <option value="">{{ __('Unassigned') }}</option>
                                    @foreach($users as $user)
                                        <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>{{ $user->name }}</option>
                                    @endforeach
                                </select>
                                <x-input-error :messages="$errors->get('user_id')" class="mt-2" />
                            </div>

                            <div>
                                <label for="status" class="block text-sm font-medium text-slate-700 mb-2">{{ __('Status') }} <span class="text-red-500">*</span></label>
                                <select name="status" id="status" class="block w-full rounded-xl border-slate-200 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm py-3 px-4 transition-colors bg-white" required>
                                    <option value="todo" {{ old('status') == 'todo' ? 'selected' : '' }}>{{ __('To Do') }}</option>
                                    <option value="in_progress" {{ old('status') == 'in_progress' ? 'selected' : '' }}>{{ __('In Progress') }}</option>
                                    <option value="done" {{ old('status') == 'done' ? 'selected' : '' }}>{{ __('Done') }}</option>
                                </select>
                                <x-input-error :messages="$errors->get('status')" class="mt-2" />
                            </div>

                            <div>
                                <label for="due_date" class="block text-sm font-medium text-slate-700 mb-2">{{ __('Due Date') }}</label>
                                <input type="date" name="due_date" id="due_date" value="{{ old('due_date') }}" class="block w-full rounded-xl border-slate-200 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm py-3 px-4 transition-colors">
                                <x-input-error :messages="$errors->get('due_date')" class="mt-2" />
                            </div>

                            <div>
                                <label for="file" class="block text-sm font-medium text-slate-700 mb-2">{{ __('Attachment (Optional)') }}</label>
                                <input type="file" name="file" id="file" class="block w-full text-sm text-slate-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 transition-colors border border-slate-200 rounded-xl">
                                <x-input-error :messages="$errors->get('file')" class="mt-2" />
                            </div>
                        </div>

                        <div class="pt-6 flex items-center justify-end space-x-3 border-t border-slate-50 mt-8">
                            <a href="{{ route('tasks.index') }}" class="px-5 py-2.5 text-sm font-medium text-slate-600 hover:text-slate-800 hover:bg-slate-50 rounded-lg transition-colors">
                                {{ __('Cancel') }}
                            </a>
                            <button type="submit" class="px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg shadow-sm transition-colors flex items-center">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                {{ __('Create Task') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
