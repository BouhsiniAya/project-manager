<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center space-x-4">
            <a href="{{ route('projects.index') }}" class="text-slate-400 hover:text-slate-600 transition-colors">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            </a>
            <h2 class="font-bold text-2xl text-slate-800 leading-tight">
                {{ __('Create New Project') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12 bg-slate-50 min-h-screen">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
                <div class="p-6 md:p-8">
                    <form method="POST" action="{{ route('projects.store') }}" class="space-y-6">
                        @csrf
                        
                        <div>
                            <label for="name" class="block text-sm font-medium text-slate-700 mb-2">{{ __('Project Name') }} <span class="text-red-500">*</span></label>
                            <input type="text" name="name" id="name" value="{{ old('name') }}" class="block w-full rounded-xl border-slate-200 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm py-3 px-4 transition-colors" placeholder="{{ __('e.g. Website Redesign') }}" required>
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>
                        
                        <div>
                            <label for="description" class="block text-sm font-medium text-slate-700 mb-2">{{ __('Description') }}</label>
                            <textarea name="description" id="description" rows="4" class="block w-full rounded-xl border-slate-200 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm py-3 px-4 transition-colors resize-none" placeholder="{{ __('Briefly describe the project goals...') }}">{{ old('description') }}</textarea>
                            <x-input-error :messages="$errors->get('description')" class="mt-2" />
                        </div>

                        <div>
                            <label for="due_date" class="block text-sm font-medium text-slate-700 mb-2">{{ __('Due Date') }}</label>
                            <input type="date" name="due_date" id="due_date" value="{{ old('due_date') }}" class="block w-full rounded-xl border-slate-200 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm py-3 px-4 transition-colors">
                            <x-input-error :messages="$errors->get('due_date')" class="mt-2" />
                        </div>

                        <div class="mt-6 border-t border-slate-200 pt-6">
                            <h3 class="text-lg font-medium text-slate-800 mb-4">{{ __('Project Members') }}</h3>
                            <div id="members-container" class="space-y-4">
                                <div class="flex items-center space-x-4 member-row">
                                    <div class="flex-1">
                                        <label class="block text-sm font-medium text-slate-700 mb-1">{{ __('Select Member') }}</label>
                                        <select name="members[]" class="block w-full rounded-xl border-slate-200 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm py-3 px-4 transition-colors">
                                            <option value="">{{ __('-- Select Member --') }}</option>
                                            @foreach($users as $user)
                                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="flex-1">
                                        <label class="block text-sm font-medium text-slate-700 mb-1">{{ __('Role') }}</label>
                                        <select name="roles[]" class="block w-full rounded-xl border-slate-200 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm py-3 px-4 transition-colors">
                                            <option value="member">{{ __('Member') }}</option>
                                            <option value="developer">{{ __('Developer') }}</option>
                                            <option value="designer">{{ __('Designer') }}</option>
                                            <option value="tester">{{ __('Tester') }}</option>
                                            <option value="manager">{{ __('Manager') }}</option>
                                        </select>
                                    </div>
                                    <div class="pt-6">
                                        <button type="button" class="text-red-500 hover:text-red-700 font-bold text-xl px-2 remove-member" title="{{ __('Remove') }}">&times;</button>
                                    </div>
                                </div>
                            </div>
                            <button type="button" id="add-member-btn" class="mt-4 px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 text-sm font-medium rounded-lg transition-colors">
                                {{ __('+ Add Another Member') }}
                            </button>
                        </div>

                        <div class="pt-4 flex items-center justify-end space-x-3 border-t border-slate-50">
                            <a href="{{ route('projects.index') }}" class="px-5 py-2.5 text-sm font-medium text-slate-600 hover:text-slate-800 hover:bg-slate-50 rounded-lg transition-colors">
                                {{ __('Cancel') }}
                            </a>
                            <button type="submit" class="px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg shadow-sm transition-colors flex items-center">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                {{ __('Create Project') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const container = document.getElementById('members-container');
            const addBtn = document.getElementById('add-member-btn');

            if (addBtn && container) {
                addBtn.addEventListener('click', function() {
                    const firstRow = container.querySelector('.member-row');
                    if (firstRow) {
                        const newRow = firstRow.cloneNode(true);
                        newRow.querySelector('select[name="members[]"]').value = '';
                        newRow.querySelector('select[name="roles[]"]').value = 'member';
                        container.appendChild(newRow);
                    }
                });

                container.addEventListener('click', function(e) {
                    if (e.target.classList.contains('remove-member')) {
                        const rows = container.querySelectorAll('.member-row');
                        if (rows.length > 1) {
                            e.target.closest('.member-row').remove();
                        } else {
                            const row = e.target.closest('.member-row');
                            row.querySelector('select[name="members[]"]').value = '';
                            row.querySelector('select[name="roles[]"]').value = 'member';
                        }
                    }
                });
            }
        });
    </script>
</x-app-layout>
