<header class="bg-[#172B4D] text-white border-b border-[#091E42] sticky top-0 z-30 px-6 py-2.5 flex justify-between items-center shadow-md">
    <div class="flex items-center space-x-6">
        <!-- Logo -->
        <a href="{{ route('dashboard') }}" class="flex items-center space-x-2 text-blue-400 hover:text-blue-300 transition-colors">
            <svg class="w-7 h-7" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"/></svg>
            <span class="font-bold text-2xl tracking-tight text-white">Planify</span>
        </a>

        <!-- Main Nav Items (Jira style) -->
        <div class="hidden md:flex space-x-1 text-sm font-medium">
            <a href="{{ route('dashboard') }}" class="px-3 py-1.5 {{ request()->routeIs('dashboard') ? 'bg-[#263959] text-blue-300' : 'text-gray-200 hover:bg-[#263959] hover:text-white' }} rounded-sm transition-colors">{{ __('Dashboard') }}</a>
            <a href="{{ route('projects.index') }}" class="px-3 py-1.5 {{ request()->routeIs('projects.*') ? 'bg-[#263959] text-blue-300' : 'text-gray-200 hover:bg-[#263959] hover:text-white' }} rounded-sm transition-colors">{{ __('Projects') }}</a>
            <a href="{{ route('tasks.index') }}" class="px-3 py-1.5 {{ request()->routeIs('tasks.*') ? 'bg-[#263959] text-blue-300' : 'text-gray-200 hover:bg-[#263959] hover:text-white' }} rounded-sm transition-colors">{{ __('My Tasks') }}</a>
            <a href="{{ route('tasks.create') }}" class="ml-4 px-4 py-1.5 bg-[#0052CC] hover:bg-[#0065FF] text-white font-medium rounded-sm shadow-sm transition-colors flex items-center">
                {{ __('Create') }}
            </a>
        </div>
    </div>

    <div class="flex items-center space-x-4">
        <!-- Search bar -->
        <div class="relative hidden lg:block">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <svg class="h-4 w-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
            </div>
            <input type="text" placeholder="{{ __('Search...') }}" class="bg-[#263959] border border-transparent text-sm text-white rounded-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent block w-48 pl-10 py-1.5 placeholder-gray-400 focus:bg-white focus:text-gray-900 transition-all">
        </div>

        <!-- Language Switcher -->
        <div class="relative" x-data="{ open: false }" @click.away="open = false">
            <button @click="open = !open" class="flex items-center space-x-1 text-gray-300 hover:text-white px-2 py-1 rounded transition-colors focus:outline-none">
                <span class="text-sm font-medium uppercase">{{ app()->getLocale() }}</span>
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
            </button>
            <div x-show="open" style="display: none;" class="absolute right-0 mt-2 w-24 bg-white rounded-md shadow-lg py-1 border border-gray-200 z-50">
                <a href="{{ route('lang.switch', 'en') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 transition-colors {{ app()->getLocale() == 'en' ? 'font-bold' : '' }}">EN</a>
                <a href="{{ route('lang.switch', 'fr') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 transition-colors {{ app()->getLocale() == 'fr' ? 'font-bold' : '' }}">FR</a>
            </div>
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
                    <span class="text-sm font-bold text-gray-700">{{ __('Notifications') }}</span>
                    @if(Auth::check() && Auth::user()->unreadNotifications->count() > 0)
                        <span class="bg-blue-100 text-blue-800 text-xs font-semibold px-2.5 py-0.5 rounded">{{ Auth::user()->unreadNotifications->count() }} {{ __('new') }}</span>
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
                            {{ __('No new notifications') }}
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Profile Dropdown -->
        <div class="relative" x-data="{ open: false }" @click.away="open = false">
            <button @click="open = !open" class="flex items-center space-x-3 focus:outline-none group">
                <div class="hidden md:flex flex-col items-end leading-tight">
                    @if(Auth::user()->isAdmin())
                        <span class="text-xs font-bold bg-purple-500 text-white px-2 py-1 rounded-full uppercase tracking-wider shadow-sm">{{ __('Admin') }}</span>
                    @else
                        <span class="text-xs font-bold bg-blue-500 text-white px-2 py-1 rounded-full uppercase tracking-wider shadow-sm">{{ __('Member') }}</span>
                    @endif
                </div>
                
                @if(Auth::user()->avatar_url)
                    <img src="{{ Auth::user()->avatar_url }}" alt="Profile" class="h-10 w-10 shrink-0 rounded-full object-cover border-2 border-[#263959] group-hover:border-blue-400 transition-all shadow-sm">
                @else
                    <div class="h-10 w-10 shrink-0 rounded-full bg-white border-2 border-[#263959] group-hover:border-blue-400 text-gray-400 flex items-center justify-center transition-all shadow-sm overflow-hidden">
                        <svg class="h-full w-full" fill="currentColor" viewBox="0 0 24 24">
                          <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 3c1.66 0 3 1.34 3 3s-1.34 3-3 3-3-1.34-3-3 1.34-3 3-3zm0 14.2c-2.5 0-4.71-1.28-6-3.22.03-1.99 4-3.08 6-3.08 1.99 0 5.97 1.09 6 3.08-1.29 1.94-3.5 3.22-6 3.22z"/>
                        </svg>
                    </div>
                @endif
            </button>

            <!-- Dropdown Menu -->
            <div x-show="open" style="display: none;" class="absolute right-0 mt-2 w-64 bg-white rounded-md shadow-lg py-2 border border-gray-200 z-50">
                <div class="px-4 py-4 border-b border-gray-100 flex flex-col items-center justify-center text-center">
                    @if(Auth::user()->avatar_url)
                        <img src="{{ Auth::user()->avatar_url }}" alt="Profile" class="h-16 w-16 shrink-0 rounded-full object-cover shadow-sm mb-3">
                    @else
                        <div class="h-16 w-16 shrink-0 rounded-full bg-white text-gray-400 flex items-center justify-center shadow-sm mb-3 overflow-hidden">
                            <svg class="h-full w-full" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 3c1.66 0 3 1.34 3 3s-1.34 3-3 3-3-1.34-3-3 1.34-3 3-3zm0 14.2c-2.5 0-4.71-1.28-6-3.22.03-1.99 4-3.08 6-3.08 1.99 0 5.97 1.09 6 3.08-1.29 1.94-3.5 3.22-6 3.22z"/></svg>
                        </div>
                    @endif
                    <p class="text-sm font-bold text-[#172B4D]">{{ Auth::user()->name }}</p>
                    <p class="text-xs text-gray-500">{{ Auth::user()->email }}</p>
                </div>
                
                <a href="{{ route('profile.edit') }}" class="block px-4 py-2 mt-2 text-sm text-gray-700 hover:bg-gray-50 transition-colors flex items-center">
                    <svg class="w-4 h-4 mr-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                    {{ __('Settings & Profile') }}
                </a>
                <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="block px-4 py-2 text-sm text-red-600 hover:bg-red-50 transition-colors flex items-center">
                    <svg class="w-4 h-4 mr-3 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                    {{ __('Log Out') }}
                </a>
            </div>
        </div>
        <form id="logout-form" method="POST" action="{{ route('logout') }}" class="hidden">
            @csrf
        </form>
    </div>
</header>
