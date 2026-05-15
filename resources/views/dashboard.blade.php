<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-[#172B4D] leading-tight dark:text-white">
            {{ __('Dashboard Overview') }}
        </h2>
    </x-slot>

    <!-- Include Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <div class="max-w-7xl mx-auto">
        <div class="mb-6">
            <h3 class="text-lg font-medium text-gray-600 dark:text-gray-300 mb-2">Welcome back, {{ Auth::user()->name }}! 👋</h3>
            <p class="text-sm text-gray-500 dark:text-gray-400">Here's what's happening with your projects today.</p>
        </div>
        
        <!-- KPI Cards Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
            <!-- Total Projects -->
            <div class="bg-white dark:bg-gray-800 rounded-xl p-5 shadow-sm border border-gray-200 dark:border-gray-700 hover:shadow-md transition-shadow">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Total Projects</p>
                        <p class="text-3xl font-extrabold text-[#172B4D] dark:text-white mt-1">{{ $totalProjects }}</p>
                    </div>
                    <div class="p-3 bg-blue-50 text-blue-600 rounded-lg dark:bg-blue-900/30 dark:text-blue-400">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"></path></svg>
                    </div>
                </div>
            </div>

            <!-- In Progress Projects -->
            <div class="bg-white dark:bg-gray-800 rounded-xl p-5 shadow-sm border border-gray-200 dark:border-gray-700 hover:shadow-md transition-shadow">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider">In Progress Projects</p>
                        <p class="text-3xl font-extrabold text-[#172B4D] dark:text-white mt-1">{{ $inProgressProjects }}</p>
                    </div>
                    <div class="p-3 bg-yellow-50 text-yellow-600 rounded-lg dark:bg-yellow-900/30 dark:text-yellow-400">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                </div>
            </div>

            <!-- Completed Projects -->
            <div class="bg-white dark:bg-gray-800 rounded-xl p-5 shadow-sm border border-gray-200 dark:border-gray-700 hover:shadow-md transition-shadow">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Completed Projects</p>
                        <p class="text-3xl font-extrabold text-[#172B4D] dark:text-white mt-1">{{ $completedProjects }}</p>
                    </div>
                    <div class="p-3 bg-green-50 text-green-600 rounded-lg dark:bg-green-900/30 dark:text-green-400">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                </div>
            </div>

            <!-- Pending Tasks -->
            <div class="bg-white dark:bg-gray-800 rounded-xl p-5 shadow-sm border border-gray-200 dark:border-gray-700 hover:shadow-md transition-shadow">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Pending Tasks</p>
                        <p class="text-3xl font-extrabold text-[#172B4D] dark:text-white mt-1">{{ $pendingTasks }}</p>
                    </div>
                    <div class="p-3 bg-red-50 text-red-600 rounded-lg dark:bg-red-900/30 dark:text-red-400">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                    </div>
                </div>
            </div>

            <!-- Global Progress -->
            <div class="bg-white dark:bg-gray-800 rounded-xl p-5 shadow-sm border border-gray-200 dark:border-gray-700 hover:shadow-md transition-shadow">
                <div class="flex items-center justify-between">
                    <div class="w-full">
                        <div class="flex justify-between items-center mb-1">
                            <p class="text-sm font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Task Completion</p>
                            <span class="text-sm font-bold text-blue-600 dark:text-blue-400">{{ $progressPercentage }}%</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2.5 dark:bg-gray-700 mt-3">
                            <div class="bg-blue-600 h-2.5 rounded-full" style="width: {{ $progressPercentage }}%"></div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Active Users -->
            <div class="bg-white dark:bg-gray-800 rounded-xl p-5 shadow-sm border border-gray-200 dark:border-gray-700 hover:shadow-md transition-shadow">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Active Users</p>
                        <p class="text-3xl font-extrabold text-[#172B4D] dark:text-white mt-1">{{ $activeUsers }}</p>
                    </div>
                    <div class="p-3 bg-purple-50 text-purple-600 rounded-lg dark:bg-purple-900/30 dark:text-purple-400">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Charts Area -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
            <!-- Project Evolution Bar Chart -->
            <div class="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-sm border border-gray-200 dark:border-gray-700">
                <h4 class="text-sm font-bold text-[#172B4D] dark:text-white uppercase tracking-wider mb-4">Project Evolution</h4>
                <div class="relative h-64">
                    <canvas id="projectEvolutionChart"></canvas>
                </div>
            </div>

            <!-- Task Status Pie Chart -->
            <div class="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-sm border border-gray-200 dark:border-gray-700">
                <h4 class="text-sm font-bold text-[#172B4D] dark:text-white uppercase tracking-wider mb-4">Task Status Distribution</h4>
                <div class="relative h-64 flex justify-center">
                    <canvas id="taskStatusChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Chart Scripts -->
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Determine text colors based on theme
                const isDarkMode = document.documentElement.classList.contains('dark');
                const textColor = isDarkMode ? '#9CA3AF' : '#4B5563';
                const gridColor = isDarkMode ? '#374151' : '#F3F4F6';

                // Bar Chart Setup
                const ctxBar = document.getElementById('projectEvolutionChart').getContext('2d');
                new Chart(ctxBar, {
                    type: 'bar',
                    data: {
                        labels: {!! json_encode($months) !!},
                        datasets: [{
                            label: 'New Projects',
                            data: {!! json_encode($projectEvolution) !!},
                            backgroundColor: '#0052CC',
                            borderRadius: 4,
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: { display: false }
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                ticks: { stepSize: 1, color: textColor },
                                grid: { color: gridColor }
                            },
                            x: {
                                ticks: { color: textColor },
                                grid: { display: false }
                            }
                        }
                    }
                });

                // Pie Chart Setup
                const ctxPie = document.getElementById('taskStatusChart').getContext('2d');
                new Chart(ctxPie, {
                    type: 'doughnut',
                    data: {
                        labels: ['To Do', 'In Progress', 'Done'],
                        datasets: [{
                            data: [{{ $taskStats['todo'] }}, {{ $taskStats['in_progress'] }}, {{ $taskStats['done'] }}],
                            backgroundColor: ['#DFE1E6', '#0052CC', '#36B37E'],
                            borderWidth: 0,
                            hoverOffset: 4
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                position: 'bottom',
                                labels: { color: textColor, padding: 20 }
                            }
                        },
                        cutout: '70%'
                    }
                });
            });
        </script>
    </div>
</x-app-layout>
