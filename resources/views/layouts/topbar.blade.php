<header class="bg-[#172B4D] text-white border-b border-[#091E42] sticky top-0 z-30 px-6 py-2.5 flex justify-between items-center shadow-md">
    <div class="flex items-center space-x-6">
        <!-- Logo -->
        <a href="{{ route('dashboard') }}" class="flex items-center space-x-2 text-blue-400 hover:text-blue-300 transition-colors">
            <svg class="w-7 h-7" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"/></svg>
            <span class="font-bold text-2xl tracking-tight text-white">Planify</span>
        </a>

        <!-- Main Nav Items (Jira style) -->
        <div class="hidden md:flex space-x-1 text-sm font-medium">
            <a href="{{ route('dashboard') }}" class="px-3 py-1.5 {{ request()->routeIs('dashboard') ? 'bg-[#263959] text-blue-300' : 'text-gray-200 hover:bg-[#263959] hover:text-white' }} rounded-sm transition-colors">Dashboard</a>
            <a href="{{ route('projects.index') }}" class="px-3 py-1.5 {{ request()->routeIs('projects.*') ? 'bg-[#263959] text-blue-300' : 'text-gray-200 hover:bg-[#263959] hover:text-white' }} rounded-sm transition-colors">Projects</a>
            <a href="{{ route('tasks.index') }}" class="px-3 py-1.5 {{ request()->routeIs('tasks.*') ? 'bg-[#263959] text-blue-300' : 'text-gray-200 hover:bg-[#263959] hover:text-white' }} rounded-sm transition-colors">Filters & Issues</a>
            <a href="{{ route('tasks.create') }}" class="ml-4 px-4 py-1.5 bg-[#0052CC] hover:bg-[#0065FF] text-white font-medium rounded-sm shadow-sm transition-colors flex items-center">
                Create
            </a>
        </div>
    </div>

    <div class="flex items-center space-x-4">
        <!-- Search bar -->
        <div class="relative hidden lg:block">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <svg class="h-4 w-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
            </div>
            <input type="text" placeholder="Search..." class="bg-[#263959] border border-transparent text-sm text-white rounded-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent block w-48 pl-10 py-1.5 placeholder-gray-400 focus:bg-white focus:text-gray-900 transition-all">
        </div>

        <!-- Notification Bell -->
        <div class="relative group" x-data="{ open: false }" @click.away="open = false">
            <button @click="open = !open" class="relative p-1.5 text-gray-300 hover:text-white hover:bg-[#263959] rounded-full transition-colors">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
                @if(Auth::check() && Auth::user()->unreadNotifications->count() > 0)
                    <span class="absolute top-1.5 right-2 block h-2 w-2 rounded-full ring-2 ring-[#172B4D] bg-red-500"></span>
                @endif
            </button>

            <!-- Dropdown -->
            <div x-show="open" style="display: none;" class="absolute right-0 mt-2 w-80 bg-white rounded-md shadow-lg py-1 border border-gray-200 z-50">
                <div class="px-4 py-2 border-b border-gray-100 flex justify-between items-center">
                    <span class="text-sm font-bold text-gray-700">Notifications</span>
                    @if(Auth::check() && Auth::user()->unreadNotifications->count() > 0)
                        <span class="bg-blue-100 text-blue-800 text-xs font-semibold px-2.5 py-0.5 rounded">{{ Auth::user()->unreadNotifications->count() }} new</span>
                    @endif
                </div>
                <div class="max-h-64 overflow-y-auto">
                    @if(Auth::check() && Auth::user()->unreadNotifications->count() > 0)
                        @foreach(Auth::user()->unreadNotifications as $notification)
                            <a href="{{ $notification->data['url'] ?? '#' }}" class="block px-4 py-3 border-b border-gray-50 hover:bg-gray-50 transition-colors">
                                <p class="text-sm text-gray-800 font-medium">{{ $notification->data['message'] ?? 'New notification' }}</p>
                                <p class="text-xs text-gray-500 mt-1">{{ $notification->created_at->diffForHumans() }}</p>
                            </a>
                        @endforeach
                    @else
                        <div class="px-4 py-6 text-center text-gray-500 text-sm">
                            No new notifications
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Help / Settings -->
        <a href="{{ route('profile.edit') }}" class="p-1.5 text-gray-300 hover:text-white hover:bg-[#263959] rounded-full transition-colors block" title="Settings">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
        </a>

        <!-- Profile -->
        <div class="h-8 w-8 rounded-full bg-[#0052CC] border border-[#0065FF] text-white flex items-center justify-center font-bold text-sm cursor-pointer hover:ring-2 hover:ring-blue-300 transition-all shadow-sm" onclick="document.getElementById('logout-form').submit();" title="Logout">
            {{ substr(Auth::user()->name, 0, 1) }}
        </div>
        <form id="logout-form" method="POST" action="{{ route('logout') }}" class="hidden">
            @csrf
        </form>
    </div>
</header>
