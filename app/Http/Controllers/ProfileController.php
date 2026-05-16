<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        $user = $request->user();
        $user->load('projects');

        $totalProjects = \App\Models\Project::where(function ($q) use ($user) {
            $q->where('user_id', $user->id)
              ->orWhereHas('members', function ($q2) use ($user) {
                  $q2->where('users.id', $user->id);
              })
              ->orWhereHas('tasks', function ($q3) use ($user) {
                  $q3->where('user_id', $user->id);
              });
        })->count();
        $assignedTasks = \App\Models\Task::where('user_id', $user->id)->count();
        $completedTasks = \App\Models\Task::where('user_id', $user->id)->whereIn('status', ['done', 'completed'])->count();

        $recentTasks = \App\Models\Task::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get()
            ->map(function ($task) {
                return [
                    'type' => 'task',
                    'action' => 'Assigned task',
                    'target' => $task->title,
                    'date' => $task->created_at,
                    'icon' => '<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>',
                    'color' => 'text-blue-500 bg-blue-100'
                ];
            });

        $recentComments = \App\Models\Comment::where('user_id', $user->id)
            ->with('task')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get()
            ->map(function ($comment) {
                return [
                    'type' => 'comment',
                    'action' => 'Commented on',
                    'target' => $comment->task ? $comment->task->title : 'a task',
                    'date' => $comment->created_at,
                    'icon' => '<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>',
                    'color' => 'text-green-500 bg-green-100'
                ];
            });

        $recentProjects = \App\Models\Project::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get()
            ->map(function ($project) {
                return [
                    'type' => 'project',
                    'action' => 'Created project',
                    'target' => $project->name,
                    'date' => $project->created_at,
                    'icon' => '<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"></path></svg>',
                    'color' => 'text-purple-500 bg-purple-100'
                ];
            });

        $recentActivity = $recentTasks->concat($recentComments)->concat($recentProjects)
            ->sortByDesc('date')
            ->take(6);

        return view('profile.edit', compact(
            'user', 
            'totalProjects', 
            'assignedTasks', 
            'completedTasks', 
            'recentActivity'
        ));
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $validated = $request->validated();
        
        if ($request->hasFile('avatar')) {
            $path = $request->file('avatar')->store('avatars', 'public');
            $validated['avatar'] = $path;
        } else {
            unset($validated['avatar']);
        }

        $request->user()->fill($validated);

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
