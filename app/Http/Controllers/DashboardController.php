<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\Task;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $totalProjects = Project::count();
        $completedProjects = Project::where('status', 'completed')->count();
        $inProgressProjects = Project::where('status', 'in_progress')->count();
        
        $totalTasks = Task::count();
        $completedTasks = Task::where('status', 'done')->count();
        $pendingTasks = Task::whereIn('status', ['todo', 'in_progress'])->count();
        
        $progressPercentage = $totalTasks > 0 ? round(($completedTasks / $totalTasks) * 100) : 0;
        
        $activeUsers = User::count();

        // Data for Task Status Pie Chart
        $taskStats = [
            'todo' => Task::where('status', 'todo')->count(),
            'in_progress' => Task::where('status', 'in_progress')->count(),
            'done' => $completedTasks,
        ];

        // Data for Project Evolution Bar Chart (Last 6 months)
        $projectEvolution = [];
        $months = [];
        for ($i = 5; $i >= 0; $i--) {
            $month = Carbon::now()->subMonths($i);
            $months[] = $month->format('M');
            $projectEvolution[] = Project::whereYear('created_at', $month->year)
                                        ->whereMonth('created_at', $month->month)
                                        ->count();
        }

        return view('dashboard', compact(
            'totalProjects',
            'completedProjects',
            'inProgressProjects',
            'pendingTasks',
            'progressPercentage',
            'activeUsers',
            'taskStats',
            'projectEvolution',
            'months'
        ));
    }
}
