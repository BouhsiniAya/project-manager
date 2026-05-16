<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-slate-800 leading-tight">
            {{ __('Profile') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-slate-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Left Column: User Profile Info, Stats, Activity -->
                <div class="md:col-span-1 space-y-6">
                    <!-- Profile Card -->
                    <div class="bg-white shadow-sm sm:rounded-2xl p-6 border border-slate-100 relative">
                        <div class="flex flex-col items-center">
                            @if ($user->avatar_url)
                                <img src="{{ $user->avatar_url }}" alt="Avatar" class="h-32 w-32 min-w-[8rem] min-h-[8rem] max-w-[8rem] max-h-[8rem] rounded-full object-cover shadow-lg border-4 border-white mb-4" style="width: 128px; height: 128px; object-fit: cover;">
                            @else
                                <div class="h-32 w-32 min-w-[8rem] min-h-[8rem] max-w-[8rem] max-h-[8rem] rounded-full bg-slate-100 text-slate-400 flex items-center justify-center shadow-lg border-4 border-white mb-4" style="width: 128px; height: 128px;">
                                    <svg class="h-16 w-16" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 3c1.66 0 3 1.34 3 3s-1.34 3-3 3-3-1.34-3-3 1.34-3 3-3zm0 14.2c-2.5 0-4.71-1.28-6-3.22.03-1.99 4-3.08 6-3.08 1.99 0 5.97 1.09 6 3.08-1.29 1.94-3.5 3.22-6 3.22z"/></svg>
                                </div>
                            @endif
                            
                            <h2 class="text-xl font-bold text-slate-800">{{ $user->name }}</h2>
                            @if($user->job_title)
                                <p class="text-slate-500 font-medium">{{ $user->job_title }}</p>
                            @endif
                            @if($user->username)
                                <p class="text-sm text-slate-400 mt-1">{{ '@' . $user->username }}</p>
                            @endif

                            <div class="mt-4 flex flex-wrap justify-center gap-2">
                                @if($user->isAdmin())
                                    <span class="px-3 py-1 bg-red-100 text-red-700 text-xs font-bold rounded-full uppercase tracking-wider">{{ __('Admin') }}</span>
                                @elseif($user->role === 'manager')
                                    <span class="px-3 py-1 bg-purple-100 text-purple-700 text-xs font-bold rounded-full uppercase tracking-wider">{{ __('Manager') }}</span>
                                @else
                                    <span class="px-3 py-1 bg-blue-100 text-blue-700 text-xs font-bold rounded-full uppercase tracking-wider">{{ __('Member') }}</span>
                                @endif
                            </div>
                        </div>

                        <div class="mt-6 border-t border-slate-100 pt-6 space-y-3">
                            @if($user->location)
                            <div class="flex items-center text-sm text-slate-600">
                                <svg class="w-5 h-5 mr-3 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                {{ $user->location }}
                            </div>
                            @endif
                            @if($user->phone_number)
                            <div class="flex items-center text-sm text-slate-600">
                                <svg class="w-5 h-5 mr-3 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                                {{ $user->phone_number }}
                            </div>
                            @endif
                            <div class="flex items-center text-sm text-slate-600">
                                <svg class="w-5 h-5 mr-3 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                                {{ $user->email }}
                            </div>
                        </div>

                        @if($user->short_bio)
                        <div class="mt-6 border-t border-slate-100 pt-6">
                            <h3 class="text-sm font-semibold text-slate-800 mb-2">About</h3>
                            <p class="text-sm text-slate-600 leading-relaxed">{{ $user->short_bio }}</p>
                        </div>
                        @endif
                    </div>

                    <!-- Stats Cards -->
                    <div class="grid grid-cols-2 gap-4">
                        <div class="bg-white shadow-sm sm:rounded-2xl p-4 border border-slate-100 hover:shadow-md transition-shadow">
                            <div class="flex items-center justify-between mb-2">
                                <h3 class="text-xs font-bold text-slate-500 uppercase tracking-wider">{{ __('Projects') }}</h3>
                                <div class="p-2 bg-blue-50 text-blue-600 rounded-lg">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"></path></svg>
                                </div>
                            </div>
                            <p class="text-2xl font-bold text-slate-800">{{ $totalProjects ?? 0 }}</p>
                        </div>
                        
                        <div class="bg-white shadow-sm sm:rounded-2xl p-4 border border-slate-100 hover:shadow-md transition-shadow">
                            <div class="flex items-center justify-between mb-2">
                                <h3 class="text-xs font-bold text-slate-500 uppercase tracking-wider">{{ __('Assigned') }}</h3>
                                <div class="p-2 bg-orange-50 text-orange-600 rounded-lg">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                </div>
                            </div>
                            <p class="text-2xl font-bold text-slate-800">{{ $assignedTasks ?? 0 }}</p>
                        </div>
                        
                        <div class="bg-white shadow-sm sm:rounded-2xl p-4 border border-slate-100 hover:shadow-md transition-shadow col-span-2">
                            <div class="flex items-center justify-between mb-2">
                                <h3 class="text-xs font-bold text-slate-500 uppercase tracking-wider">{{ __('Completed Tasks') }}</h3>
                                <div class="p-2 bg-green-50 text-green-600 rounded-lg">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                </div>
                            </div>
                            <p class="text-2xl font-bold text-slate-800">{{ $completedTasks ?? 0 }}</p>
                        </div>
                    </div>

                    <!-- Recent Activity Jira Style -->
                    <div class="bg-white shadow-sm sm:rounded-2xl p-6 border border-slate-100">
                        <h3 class="text-sm font-bold text-slate-800 uppercase tracking-wider mb-4 flex items-center">
                            <svg class="w-4 h-4 mr-2 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            {{ __('Recent Activity') }}
                        </h3>
                        <div class="space-y-6">
                            @if(isset($recentActivity) && $recentActivity->count() > 0)
                                @foreach($recentActivity as $activity)
                                    <div class="flex">
                                        <div class="flex-shrink-0 mr-4">
                                            <div class="w-8 h-8 rounded-full flex items-center justify-center {!! $activity['color'] !!}">
                                                {!! $activity['icon'] !!}
                                            </div>
                                        </div>
                                        <div>
                                            <p class="text-sm text-slate-800">
                                                <span class="font-medium">{{ __($activity['action']) }}</span> 
                                                <span class="text-slate-600">{{ $activity['target'] }}</span>
                                            </p>
                                            <p class="text-xs text-slate-500 mt-1">{{ $activity['date']->diffForHumans() }}</p>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <p class="text-sm text-slate-500 italic">{{ __('No recent activity found.') }}</p>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Right Column: Edit Forms -->
                <div class="md:col-span-2 space-y-6">
                    <div class="bg-white shadow-sm sm:rounded-2xl p-6 md:p-8 border border-slate-100">
                        @include('profile.partials.update-profile-information-form')
                    </div>

                    <div class="bg-white shadow-sm sm:rounded-2xl p-6 md:p-8 border border-slate-100">
                        @include('profile.partials.update-password-form')
                    </div>

                    <div class="bg-white shadow-sm sm:rounded-2xl p-6 md:p-8 border border-slate-100 border-l-4 border-l-red-500">
                        @include('profile.partials.delete-user-form')
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
